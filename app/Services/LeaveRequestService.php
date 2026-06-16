<?php

namespace App\Services;

use App\Models\AttendanceRecord;
use App\Models\LeaveRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LeaveRequestService
{
    public const ALERT_WINDOW_MINUTES = 2;

    public function recentAlerts(int $minutes = self::ALERT_WINDOW_MINUTES): Collection
    {
        return LeaveRequest::query()
            ->with(['user:id,name,email'])
            ->where('status', LeaveRequest::STATUS_PENDING)
            ->where('created_at', '>=', now()->subMinutes($minutes))
            ->latest()
            ->get();
    }

    public function pendingRequests(int $limit = 20): Collection
    {
        return LeaveRequest::query()
            ->with(['user:id,name,email'])
            ->where('status', LeaveRequest::STATUS_PENDING)
            ->latest()
            ->take($limit)
            ->get();
    }

    public function pendingCount(): int
    {
        return LeaveRequest::query()
            ->where('status', LeaveRequest::STATUS_PENDING)
            ->count();
    }

    public function hasOverlappingPending(int $userId, string $startDate, string $endDate, ?int $ignoreId = null): bool
    {
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->startOfDay();

        return LeaveRequest::query()
            ->where('user_id', $userId)
            ->where('status', LeaveRequest::STATUS_PENDING)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('start_date', [$start, $end])
                    ->orWhereBetween('end_date', [$start, $end])
                    ->orWhere(function ($inner) use ($start, $end) {
                        $inner->where('start_date', '<=', $start)
                            ->where('end_date', '>=', $end);
                    });
            })
            ->exists();
    }

    public function approve(LeaveRequest $leaveRequest, ?string $adminNote = null): LeaveRequest
    {
        if ($leaveRequest->status !== LeaveRequest::STATUS_PENDING) {
            throw ValidationException::withMessages([
                'leave' => 'This leave request has already been reviewed.',
            ]);
        }

        return DB::transaction(function () use ($leaveRequest, $adminNote) {
            $leaveRequest->update([
                'status' => LeaveRequest::STATUS_APPROVED,
                'admin_note' => $adminNote,
            ]);

            $date = $leaveRequest->start_date->copy();
            while ($date->lte($leaveRequest->end_date)) {
                AttendanceRecord::updateOrCreate(
                    [
                        'user_id' => $leaveRequest->user_id,
                        'record_date' => $date->toDateString(),
                    ],
                    [
                        'status' => AttendanceRecord::STATUS_EXCUSED,
                        'notes' => 'Approved leave (request #'.$leaveRequest->id.')',
                    ]
                );
                $date->addDay();
            }

            return $leaveRequest->fresh(['user']);
        });
    }

    public function reject(LeaveRequest $leaveRequest, ?string $adminNote = null): LeaveRequest
    {
        if ($leaveRequest->status !== LeaveRequest::STATUS_PENDING) {
            throw ValidationException::withMessages([
                'leave' => 'This leave request has already been reviewed.',
            ]);
        }

        $leaveRequest->update([
            'status' => LeaveRequest::STATUS_REJECTED,
            'admin_note' => $adminNote,
        ]);

        return $leaveRequest->fresh(['user']);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function alertsPayload(): array
    {
        return $this->recentAlerts()->map(function (LeaveRequest $leave) {
            $expiresAt = $leave->created_at->copy()->addMinutes(self::ALERT_WINDOW_MINUTES);

            return [
                'id' => $leave->id,
                'student_name' => optional($leave->user)->name ?? 'Student',
                'student_email' => optional($leave->user)->email,
                'start_date' => $leave->start_date->format('M j, Y'),
                'end_date' => $leave->end_date->format('M j, Y'),
                'days' => $leave->dayCount(),
                'reason' => $leave->reason,
                'created_at' => $leave->created_at->toIso8601String(),
                'expires_at' => $expiresAt->toIso8601String(),
                'seconds_remaining' => max(0, $expiresAt->timestamp - now()->timestamp),
            ];
        })->values()->all();
    }
}
