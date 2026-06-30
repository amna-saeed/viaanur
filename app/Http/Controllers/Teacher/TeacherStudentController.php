<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\User;
use App\Services\LectureAttendanceService;
use App\Services\StudentSubjectAssignmentService;
use App\Services\TeacherScopeService;
use App\Support\StudentInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;

class TeacherStudentController extends Controller
{
    public function index(Request $request, TeacherScopeService $scope)
    {
        $query = $scope->studentsQuery()->latest();

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($qry) use ($q) {
                $qry->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhereHas('studentProfile', function ($profileQuery) use ($q) {
                        $profileQuery->where('student_id_number', 'like', "%{$q}%");
                    });
            });
        }

        $students = $query->paginate(10)->withQueryString();

        return view('teacher.students.index', compact('students'));
    }

    public function create()
    {
        $genderOptions = StudentInformation::GENDER_OPTIONS;

        return view('teacher.students.create', compact('genderOptions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ] + StudentInformation::profileRules(), StudentInformation::validationMessages());

        $student = DB::transaction(function () use ($validated) {
            $student = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'password' => Hash::make($validated['password']),
                'role' => User::ROLE_STUDENT,
            ]);

            $student->studentProfile()->create(StudentInformation::profileDataFrom($validated));

            return $student;
        });

        return redirect()
            ->route('teacher.students.assign-subject', $student)
            ->with('success', 'Student created. Assign one of your subjects to add them to your roster.');
    }

    public function show(
        User $student,
        TeacherScopeService $scope,
        LectureAttendanceService $lectureAttendance
    ) {
        $scope->ensureStudentAccess($student);

        $student->loadMissing(['studentProfile', 'lmsEnrollments', 'assignedSubjects.course', 'assignedSubjects.teacher']);
        $genderOptions = StudentInformation::GENDER_OPTIONS;
        $lectureAttendanceItems = $lectureAttendance->assignedLecturesFor($student);
        $assignedSubjects = $student->assignedSubjects()
            ->whereIn('subjects.id', $scope->subjectIds())
            ->with(['course', 'teacher'])
            ->get();

        return view('teacher.students.show', compact('student', 'genderOptions', 'lectureAttendanceItems', 'assignedSubjects'));
    }

    public function assignSubjectForm(User $student, TeacherScopeService $scope)
    {
        $this->ensureStudentRole($student);

        $assignedSubjects = $student->assignedSubjects()
            ->whereIn('subjects.id', $scope->subjectIds())
            ->with(['course', 'teacher'])
            ->orderBy('name')
            ->get();
        $availableSubjects = $scope->availableSubjectsFor($student);

        return view('teacher.students.assign-subject', compact('student', 'assignedSubjects', 'availableSubjects'));
    }

    public function assignSubject(
        Request $request,
        User $student,
        TeacherScopeService $scope,
        StudentSubjectAssignmentService $subjectAssignments
    ) {
        $this->ensureStudentRole($student);

        $validated = $request->validate([
            'subject_id' => ['required', 'exists:subjects,id'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $subject = Subject::query()->findOrFail($validated['subject_id']);
        $scope->ensureSubjectAccess($subject);

        try {
            $subjectAssignments->assign($student, (int) $validated['subject_id'], $validated['notes'] ?? null);
        } catch (InvalidArgumentException $exception) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $exception->getMessage());
        }

        return redirect()
            ->route('teacher.students.assign-subject', $student)
            ->with('success', $subject->name.' assigned to '.$student->name.' successfully.');
    }

    public function removeSubject(
        User $student,
        Subject $subject,
        TeacherScopeService $scope,
        StudentSubjectAssignmentService $subjectAssignments
    ) {
        $scope->ensureStudentAccess($student);
        $scope->ensureSubjectAccess($subject);

        if (! $student->assignedSubjects()->where('subjects.id', $subject->id)->exists()) {
            return redirect()
                ->back()
                ->with('error', 'This subject is not assigned to the student.');
        }

        $subjectAssignments->remove($student, $subject);

        return redirect()
            ->back()
            ->with('success', $subject->name.' removed from '.$student->name.'.');
    }

    public function edit(User $student, TeacherScopeService $scope)
    {
        $scope->ensureStudentAccess($student);

        $student->loadMissing('studentProfile');
        $genderOptions = StudentInformation::GENDER_OPTIONS;

        return view('teacher.students.edit', compact('student', 'genderOptions'));
    }

    public function update(Request $request, User $student, TeacherScopeService $scope)
    {
        $scope->ensureStudentAccess($student);
        $student->loadMissing('studentProfile');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$student->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ] + StudentInformation::profileRules(optional($student->studentProfile)->id), StudentInformation::validationMessages());

        DB::transaction(function () use ($student, $validated, $request) {
            $data = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($validated['password']);
            }

            $student->update($data);
            $student->studentProfile()->updateOrCreate(
                ['user_id' => $student->id],
                StudentInformation::profileDataFrom($validated)
            );
        });

        return redirect()->route('teacher.students.show', $student)->with('success', 'Student information updated successfully.');
    }

    public function updateProfileRecords(Request $request, User $student, TeacherScopeService $scope)
    {
        $scope->ensureStudentAccess($student);

        $validated = $request->validate(
            StudentInformation::dashboardMetricsRules() + StudentInformation::academicInfoRules()
        );

        $student->loadMissing('studentProfile');

        if (! $student->studentProfile) {
            return redirect()
                ->route('teacher.students.show', $student)
                ->with('error', 'Complete basic student information before saving dashboard and academic records.');
        }

        $student->update([
            'attendance_percentage' => $validated['attendance_percentage'] ?? 0,
        ]);

        $profileData = array_merge(
            StudentInformation::dashboardMetricsFrom($validated),
            StudentInformation::academicInfoFrom($validated)
        );

        $profileData['total_sessions_booked'] = (int) ($profileData['total_sessions_booked'] ?? 0);
        $profileData['total_sessions_attended'] = (int) ($profileData['total_sessions_attended'] ?? 0);

        $student->studentProfile->update($profileData);

        return redirect()
            ->route('teacher.students.show', $student)
            ->with('success', 'Dashboard metrics and academic information saved successfully.');
    }

    private function ensureStudentRole(User $student): void
    {
        if ($student->role !== User::ROLE_STUDENT) {
            abort(404);
        }
    }
}
