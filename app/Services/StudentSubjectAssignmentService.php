<?php

namespace App\Services;

use App\Models\LmsEnrollment;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class StudentSubjectAssignmentService
{
    public function assignedSubjectsFor(User $student): Collection
    {
        return $student->assignedSubjects()
            ->with(['course', 'teacher'])
            ->orderBy('name')
            ->get();
    }

    public function availableSubjectsFor(User $student): Collection
    {
        $assignedIds = $student->assignedSubjects()->pluck('subjects.id');

        return Subject::query()
            ->with(['course', 'teacher'])
            ->when($assignedIds->isNotEmpty(), fn ($query) => $query->whereNotIn('id', $assignedIds))
            ->orderBy('name')
            ->get();
    }

    public function assign(User $student, int $subjectId, ?string $notes = null): Subject
    {
        if ($student->assignedSubjects()->where('subjects.id', $subjectId)->exists()) {
            throw new \InvalidArgumentException('This subject is already assigned to the student.');
        }

        $subject = Subject::query()->findOrFail($subjectId);

        DB::transaction(function () use ($student, $subject, $notes) {
            $student->assignedSubjects()->attach($subject->id, [
                'assigned_at' => now(),
                'notes' => $notes,
            ]);

            $this->ensureCourseEnrollment($student, $subject);
            $this->syncSubjectsEnrolledText($student);
        });

        return $subject->load(['course', 'teacher']);
    }

    public function remove(User $student, Subject $subject): void
    {
        if ((int) $subject->id === 0) {
            return;
        }

        DB::transaction(function () use ($student, $subject) {
            $student->assignedSubjects()->detach($subject->id);
            $this->syncSubjectsEnrolledText($student);
        });
    }

    private function ensureCourseEnrollment(User $student, Subject $subject): void
    {
        if (! $subject->course_id) {
            return;
        }

        $enrollment = LmsEnrollment::firstOrCreate(
            [
                'user_id' => $student->id,
                'course_id' => $subject->course_id,
            ],
            [
                'status' => LmsEnrollment::STATUS_APPROVED,
                'approved_at' => now(),
            ]
        );

        if (! $enrollment->isApproved()) {
            $enrollment->update([
                'status' => LmsEnrollment::STATUS_APPROVED,
                'approved_at' => $enrollment->approved_at ?? now(),
            ]);
        }
    }

    private function syncSubjectsEnrolledText(User $student): void
    {
        $student->loadMissing('studentProfile');

        if (! $student->studentProfile) {
            return;
        }

        $names = $student->assignedSubjects()
            ->orderBy('name')
            ->pluck('name')
            ->filter()
            ->implode(', ');

        $student->studentProfile->update([
            'subjects_enrolled' => $names !== '' ? $names : null,
        ]);
    }
}
