<?php

namespace App\Services;

use App\Models\Lesson;
use App\Models\LmsEnrollment;
use App\Models\StudentLessonAttendance;
use App\Models\User;
use Illuminate\Support\Collection;

class LectureAttendanceService
{
    /**
     * @return Collection<int, array{lesson_id: int, title: string, course_title: string, attended: bool, status_message: string, attended_at: ?\Illuminate\Support\Carbon}>
     */
    public function assignedLecturesFor(User $student): Collection
    {
        $courseIds = LmsEnrollment::query()
            ->where('user_id', $student->id)
            ->where('status', LmsEnrollment::STATUS_APPROVED)
            ->pluck('course_id');

        if ($courseIds->isEmpty()) {
            return collect();
        }

        $lessons = Lesson::query()
            ->whereIn('course_id', $courseIds)
            ->with('course:id,title')
            ->orderBy('course_id')
            ->orderBy('order')
            ->get();

        if ($lessons->isEmpty()) {
            return collect();
        }

        $attendanceByLesson = StudentLessonAttendance::query()
            ->where('user_id', $student->id)
            ->whereIn('lesson_id', $lessons->pluck('id'))
            ->get()
            ->keyBy('lesson_id');

        return $lessons->map(function (Lesson $lesson) use ($attendanceByLesson) {
            $attendance = $attendanceByLesson->get($lesson->id);
            $attended = $attendance !== null && $attendance->isAttended();

            return [
                'lesson_id' => $lesson->id,
                'title' => $lesson->title,
                'course_title' => optional($lesson->course)->title ?? 'Course',
                'attended' => $attended,
                'status_message' => $attended
                    ? 'The student has attended the assigned lecture.'
                    : 'The lecture was assigned but not attended.',
                'attended_at' => $attendance?->attended_at,
            ];
        });
    }

    public function markAttended(int $userId, int $lessonId): void
    {
        StudentLessonAttendance::query()->updateOrCreate(
            [
                'user_id' => $userId,
                'lesson_id' => $lessonId,
            ],
            [
                'attended_at' => now(),
            ]
        );
    }
}
