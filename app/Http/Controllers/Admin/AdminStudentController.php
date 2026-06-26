<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\LectureAttendanceService;
use App\Support\StudentInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminStudentController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('studentProfile')
            ->where('role', User::ROLE_STUDENT)
            ->latest();

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
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        $genderOptions = StudentInformation::GENDER_OPTIONS;

        return view('admin.students.create', compact('genderOptions'));
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

        return redirect()->route('admin.students.show', $student)->with('success', 'Student account created successfully.');
    }

    public function show(User $student, LectureAttendanceService $lectureAttendance)
    {
        $this->ensureStudent($student);

        $student->loadMissing(['studentProfile', 'lmsEnrollments', 'enrolledCourses.quizzes', 'quizAttempts']);
        $genderOptions = StudentInformation::GENDER_OPTIONS;
        $lectureAttendanceItems = $lectureAttendance->assignedLecturesFor($student);

        return view('admin.students.show', compact('student', 'genderOptions', 'lectureAttendanceItems'));
    }

    public function edit(User $student)
    {
        $this->ensureStudent($student);

        $student->loadMissing('studentProfile');
        $genderOptions = StudentInformation::GENDER_OPTIONS;

        return view('admin.students.edit', compact('student', 'genderOptions'));
    }

    public function update(Request $request, User $student)
    {
        $this->ensureStudent($student);

        $student->loadMissing('studentProfile');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $student->id,
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

        return redirect()->route('admin.students.show', $student)->with('success', 'Student information updated successfully.');
    }

    public function updateProfileRecords(Request $request, User $student)
    {
        $this->ensureStudent($student);

        $validated = $request->validate(
            StudentInformation::dashboardMetricsRules() + StudentInformation::academicInfoRules()
        );

        $student->loadMissing('studentProfile');

        if (! $student->studentProfile) {
            return redirect()
                ->route('admin.students.show', $student)
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
            ->route('admin.students.show', $student)
            ->with('success', 'Dashboard metrics and academic information saved successfully.');
    }

    private function ensureStudent(User $student): void
    {
        if ($student->role !== User::ROLE_STUDENT) {
            abort(404);
        }
    }
}
