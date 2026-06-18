<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\User;
use App\Services\EnrollmentRequestService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class AdminApplicationController extends Controller
{
    public function show(Application $application, EnrollmentRequestService $enrollmentService)
    {
        $application->load('courseRelation');

        return view('admin.enrollments.application-show', [
            'application' => $application,
            'courseTitle' => $enrollmentService->courseTitleFor($application),
        ]);
    }

    public function approve(Application $application, EnrollmentRequestService $enrollmentService): RedirectResponse
    {
        try {
            $createdStudent = ! User::query()->where('email', $application->email)->exists();
            $application = $enrollmentService->approveApplication($application);
        } catch (ValidationException $e) {
            return redirect()->back()->with('error', $e->validator->errors()->first('application'));
        }

        $message = $application->name.' has been approved.';
        if ($createdStudent) {
            $message .= ' A new student account was created — ask them to use Forgot Password on the login page to set their password.';
        }
        if ($application->course_id) {
            $message .= ' Course access is now active.';
        }

        return redirect()
            ->route('admin.enrollments.index')
            ->with('success', $message);
    }

    public function reject(Application $application, EnrollmentRequestService $enrollmentService): RedirectResponse
    {
        try {
            $application = $enrollmentService->rejectApplication($application);
        } catch (ValidationException $e) {
            return redirect()->back()->with('error', $e->validator->errors()->first('application'));
        }

        return redirect()
            ->route('admin.enrollments.index')
            ->with('success', 'Enrollment request for '.$application->name.' has been rejected.');
    }
}
