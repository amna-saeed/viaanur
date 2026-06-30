<?php

namespace App\Services;

use App\Models\Application;
use App\Models\Course;
use App\Models\LmsEnrollment;
use App\Models\User;
use App\Support\CourseApplicationMapper;
use App\Support\StudentInformation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class EnrollmentRequestService
{
    public const ALERT_WINDOW_MINUTES = 30;

    public function recentPending(int $minutes = self::ALERT_WINDOW_MINUTES): Collection
    {
        $since = now()->subMinutes($minutes);

        $enrollments = LmsEnrollment::query()
            ->with(['user:id,name,email', 'course:id,title'])
            ->where('status', LmsEnrollment::STATUS_PENDING)
            ->where('created_at', '>=', $since)
            ->latest()
            ->get();

        $applications = Application::query()
            ->with('courseRelation:id,title')
            ->pendingReview()
            ->where('created_at', '>=', $since)
            ->latest()
            ->get();

        return $enrollments->map(fn (LmsEnrollment $enrollment) => $this->enrollmentAlertItem($enrollment))
            ->concat($applications->map(fn (Application $application) => $this->applicationAlertItem($application)))
            ->sortByDesc('sort_at')
            ->values();
    }

    public function pendingEnrollments(int $limit = 20): Collection
    {
        return LmsEnrollment::query()
            ->with(['user:id,name,email', 'course:id,title'])
            ->where('status', LmsEnrollment::STATUS_PENDING)
            ->latest()
            ->take($limit)
            ->get();
    }

    public function pendingApplications(int $limit = 50): Collection
    {
        return Application::query()
            ->with('courseRelation:id,title')
            ->pendingReview()
            ->latest()
            ->take($limit)
            ->get();
    }

    public function pendingCount(): int
    {
        return LmsEnrollment::query()->where('status', LmsEnrollment::STATUS_PENDING)->count()
            + Application::query()->pendingReview()->count();
    }

    public function alertsPayload(): array
    {
        return $this->recentPending()
            ->map(fn (array $item) => [
                'id' => $item['alert_id'],
                'student_name' => $item['student_name'],
                'student_email' => $item['student_email'],
                'course_title' => $item['course_title'],
                'created_at' => $item['created_at'],
                'url' => $item['url'],
            ])
            ->values()
            ->all();
    }

    public function pendingItemsPayload(int $limit = 20): array
    {
        $enrollments = LmsEnrollment::query()
            ->with(['user:id,name,email', 'course:id,title'])
            ->where('status', LmsEnrollment::STATUS_PENDING)
            ->latest()
            ->get();

        $applications = Application::query()
            ->with('courseRelation:id,title')
            ->pendingReview()
            ->latest()
            ->get();

        return $enrollments
            ->map(fn (LmsEnrollment $enrollment) => $this->formatPendingItem(
                $this->enrollmentAlertItem($enrollment),
                'enrollment'
            ))
            ->concat($applications->map(fn (Application $application) => $this->formatPendingItem(
                $this->applicationAlertItem($application),
                'application'
            )))
            ->sortByDesc('sort_at')
            ->take($limit)
            ->map(function (array $item) {
                unset($item['sort_at']);

                return $item;
            })
            ->values()
            ->all();
    }

    public function syncEnrollmentFromApplication(Application $application): ?LmsEnrollment
    {
        $student = User::query()
            ->where('email', $application->email)
            ->where('role', User::ROLE_STUDENT)
            ->first();

        if (! $student || ! $application->course_id) {
            return null;
        }

        $enrollment = LmsEnrollment::firstOrCreate(
            [
                'user_id' => $student->id,
                'course_id' => $application->course_id,
            ],
            [
                'status' => LmsEnrollment::STATUS_PENDING,
            ]
        );

        if ($enrollment->status === LmsEnrollment::STATUS_REJECTED) {
            $enrollment->update([
                'status' => LmsEnrollment::STATUS_PENDING,
                'approved_at' => null,
            ]);
        }

        return $enrollment;
    }

    public function approve(LmsEnrollment $enrollment): LmsEnrollment
    {
        if ($enrollment->status !== LmsEnrollment::STATUS_PENDING) {
            throw ValidationException::withMessages([
                'enrollment' => 'This enrollment has already been reviewed.',
            ]);
        }

        $enrollment->update([
            'status' => LmsEnrollment::STATUS_APPROVED,
            'approved_at' => now(),
        ]);

        return $enrollment->fresh(['user', 'course']);
    }

    public function reject(LmsEnrollment $enrollment): LmsEnrollment
    {
        if ($enrollment->status !== LmsEnrollment::STATUS_PENDING) {
            throw ValidationException::withMessages([
                'enrollment' => 'This enrollment has already been reviewed.',
            ]);
        }

        $enrollment->update([
            'status' => LmsEnrollment::STATUS_REJECTED,
            'approved_at' => null,
        ]);

        return $enrollment->fresh(['user', 'course']);
    }

    public function approveApplication(Application $application): Application
    {
        if (! $application->isPendingReview()) {
            throw ValidationException::withMessages([
                'application' => 'This application has already been reviewed.',
            ]);
        }

        return DB::transaction(function () use ($application) {
            $student = $this->resolveOrCreateStudent($application);
            $course = $this->resolveApplicationCourse($application);

            if ($course) {
                $application->course_id = $course->id;
            }

            if ($student && $application->course_id) {
                LmsEnrollment::updateOrCreate(
                    [
                        'user_id' => $student->id,
                        'course_id' => $application->course_id,
                    ],
                    [
                        'status' => LmsEnrollment::STATUS_APPROVED,
                        'approved_at' => now(),
                    ]
                );
            }

            $application->update(['status' => Application::STATUS_APPROVED]);

            return $application->fresh(['courseRelation']);
        });
    }

    public function rejectApplication(Application $application): Application
    {
        if (! $application->isPendingReview()) {
            throw ValidationException::withMessages([
                'application' => 'This application has already been reviewed.',
            ]);
        }

        $application->update(['status' => Application::STATUS_REJECTED]);

        return $application->fresh(['courseRelation']);
    }

    public function courseTitleFor(Application $application): string
    {
        return optional($application->courseRelation)->title
            ?? CourseApplicationMapper::label($application->course);
    }

    private function resolveApplicationCourse(Application $application): ?Course
    {
        if ($application->course_id) {
            $course = Course::find($application->course_id);
            if ($course) {
                return $course;
            }
        }

        $course = CourseApplicationMapper::resolveCourse($application->course)
            ?? CourseApplicationMapper::resolveOrCreateLmsCourse($application->course);

        if ($course) {
            $application->course_id = $course->id;
            $application->save();
        }

        return $course;
    }

    public function reconcileApprovedApplications(): int
    {
        $synced = 0;

        Application::query()
            ->where('status', Application::STATUS_APPROVED)
            ->orderByDesc('id')
            ->chunk(100, function ($applications) use (&$synced) {
                foreach ($applications as $application) {
                    if ($this->ensureEnrollmentForApprovedApplication($application)) {
                        $synced++;
                    }
                }
            });

        return $synced;
    }

    public function ensureEnrollmentForApprovedApplication(Application $application): bool
    {
        $student = User::query()
            ->where('email', $application->email)
            ->where('role', User::ROLE_STUDENT)
            ->first();

        if (! $student) {
            return false;
        }

        $course = $this->resolveApplicationCourse($application);
        if (! $course) {
            return false;
        }

        $enrollment = LmsEnrollment::firstOrCreate(
            [
                'user_id' => $student->id,
                'course_id' => $course->id,
            ],
            [
                'status' => LmsEnrollment::STATUS_PENDING,
            ]
        );

        if ($enrollment->isApproved()) {
            return false;
        }

        $enrollment->update([
            'status' => LmsEnrollment::STATUS_APPROVED,
            'approved_at' => $enrollment->approved_at ?? now(),
        ]);

        return true;
    }

    private function resolveOrCreateStudent(Application $application): User
    {
        $existing = User::query()->where('email', $application->email)->first();

        if ($existing) {
            if ($existing->role !== User::ROLE_STUDENT) {
                throw ValidationException::withMessages([
                    'application' => 'This email belongs to a non-student account.',
                ]);
            }

            return $existing;
        }

        $student = User::create([
            'name' => $application->name,
            'email' => $application->email,
            'phone' => $application->phone,
            'password' => Hash::make(Str::random(32)),
            'role' => User::ROLE_STUDENT,
        ]);

        $student->studentProfile()->create(
            StudentInformation::profileDataFrom([
                'student_id_number' => $application->student_id_number,
                'date_of_birth' => optional($application->date_of_birth)->format('Y-m-d'),
                'gender' => $application->gender,
                'school_name' => $application->school_name,
                'home_address' => $application->home_address,
                'guardian_name' => $application->guardian_name,
                'guardian_contact_number' => $application->guardian_contact_number,
                'emergency_contact_number' => $application->emergency_contact_number,
            ])
        );

        return $student;
    }

    private function enrollmentAlertItem(LmsEnrollment $enrollment): array
    {
        return [
            'alert_id' => 'enrollment-'.$enrollment->id,
            'student_name' => optional($enrollment->user)->name ?? 'Student',
            'student_email' => optional($enrollment->user)->email,
            'course_title' => optional($enrollment->course)->title ?? 'Course',
            'created_at' => optional($enrollment->created_at)->toIso8601String(),
            'sort_at' => $enrollment->created_at,
            'url' => route('admin.enrollments.show', $enrollment),
        ];
    }

    private function applicationAlertItem(Application $application): array
    {
        return [
            'alert_id' => 'application-'.$application->id,
            'student_name' => $application->name,
            'student_email' => $application->email,
            'course_title' => $this->courseTitleFor($application),
            'created_at' => optional($application->created_at)->toIso8601String(),
            'sort_at' => $application->created_at,
            'url' => route('admin.applications.show', $application),
        ];
    }

    private function formatPendingItem(array $item, string $type): array
    {
        $message = $type === 'application'
            ? $item['student_name'].' submitted a new application for '.$item['course_title']
            : $item['student_name'].' requested enrollment in '.$item['course_title'];

        return array_merge($item, [
            'id' => $item['alert_id'],
            'type' => $type,
            'message' => $message,
        ]);
    }
}
