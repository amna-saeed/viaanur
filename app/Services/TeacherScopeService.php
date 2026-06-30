<?php

namespace App\Services;

use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeacherScopeService
{
    private ?Teacher $teacher = null;

    public function currentTeacher(): Teacher
    {
        if ($this->teacher) {
            return $this->teacher;
        }

        $user = Auth::guard('teacher')->user();

        if (! $user) {
            abort(403, 'Teacher authentication required.');
        }

        $teacher = Teacher::query()->where('user_id', $user->id)->first();

        if (! $teacher) {
            abort(403, 'Your teacher profile is not linked. Contact the administrator.');
        }

        return $this->teacher = $teacher;
    }

    public function subjectIds(): Collection
    {
        return $this->currentTeacher()
            ->subjects()
            ->pluck('id');
    }

    public function studentIds(): Collection
    {
        $subjectIds = $this->subjectIds();

        if ($subjectIds->isEmpty()) {
            return collect();
        }

        return DB::table('student_subject')
            ->whereIn('subject_id', $subjectIds)
            ->distinct()
            ->pluck('user_id');
    }

    public function studentsQuery(): Builder
    {
        $studentIds = $this->studentIds();

        return User::query()
            ->with(['studentProfile', 'assignedSubjects'])
            ->where('role', User::ROLE_STUDENT)
            ->when(
                $studentIds->isNotEmpty(),
                fn (Builder $query) => $query->whereIn('id', $studentIds),
                fn (Builder $query) => $query->whereRaw('1 = 0')
            );
    }

    public function subjectsQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return Subject::query()
            ->where('teacher_id', $this->currentTeacher()->id)
            ->with(['course'])
            ->withCount('students');
    }

    public function ensureStudentAccess(User $student): void
    {
        if ($student->role !== User::ROLE_STUDENT) {
            abort(404);
        }

        if (! $this->studentIds()->contains($student->id)) {
            abort(403, 'This student is not assigned to your subjects.');
        }
    }

    public function ensureSubjectAccess(Subject $subject): void
    {
        if ((int) $subject->teacher_id !== (int) $this->currentTeacher()->id) {
            abort(403, 'You do not have access to this subject.');
        }
    }

    public function availableSubjectsFor(User $student): Collection
    {
        $assignedIds = $student->assignedSubjects()->pluck('subjects.id');
        $teacherSubjectIds = $this->subjectIds();

        return Subject::query()
            ->with(['course', 'teacher'])
            ->whereIn('id', $teacherSubjectIds)
            ->when($assignedIds->isNotEmpty(), fn ($query) => $query->whereNotIn('id', $assignedIds))
            ->orderBy('name')
            ->get();
    }
}
