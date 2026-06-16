<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Services\LeaveRequestService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdminLeaveRequestController extends Controller
{
    public function approve(Request $request, LeaveRequest $leaveRequest, LeaveRequestService $leaveService): RedirectResponse
    {
        $validated = $request->validate([
            'admin_note' => ['nullable', 'string', 'max:1000'],
        ]);

        try {
            $leave = $leaveService->approve($leaveRequest, $validated['admin_note'] ?? null);
        } catch (ValidationException $e) {
            return redirect()
                ->route('admin.dashboard')
                ->with('error', $e->validator->errors()->first('leave'));
        }

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Leave request for '.optional($leave->user)->name.' has been approved.');
    }

    public function reject(Request $request, LeaveRequest $leaveRequest, LeaveRequestService $leaveService): RedirectResponse
    {
        $validated = $request->validate([
            'admin_note' => ['nullable', 'string', 'max:1000'],
        ]);

        try {
            $leave = $leaveService->reject($leaveRequest, $validated['admin_note'] ?? null);
        } catch (ValidationException $e) {
            return redirect()
                ->route('admin.dashboard')
                ->with('error', $e->validator->errors()->first('leave'));
        }

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Leave request for '.optional($leave->user)->name.' has been rejected.');
    }

    public function alerts(LeaveRequestService $leaveService): JsonResponse
    {
        return response()->json([
            'alerts' => $leaveService->alertsPayload(),
            'pending_count' => $leaveService->pendingCount(),
            'generated_at' => now()->toIso8601String(),
        ]);
    }
}
