<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Mail\ApplicationConfirmation;
use App\Mail\ApplicationReceived;
use App\Services\EnrollmentRequestService;
use App\Support\CourseApplicationMapper;
use App\Support\OutboundMail;
use App\Support\StudentInformation;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function store(Request $request, EnrollmentRequestService $enrollmentService)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:50',
            'course' => 'required|string|max:100',
            'message' => 'nullable|string|max:2000',
        ] + StudentInformation::applicationRules(), StudentInformation::validationMessages());

        $courseId = CourseApplicationMapper::resolveCourseId($validated['course']);

        $application = Application::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'student_id_number' => $validated['student_id_number'],
            'date_of_birth' => $validated['date_of_birth'],
            'gender' => $validated['gender'],
            'school_name' => $validated['school_name'] ?? null,
            'home_address' => $validated['home_address'],
            'guardian_name' => $validated['guardian_name'],
            'guardian_contact_number' => $validated['guardian_contact_number'],
            'emergency_contact_number' => $validated['emergency_contact_number'] ?? null,
            'course' => $validated['course'],
            'course_id' => $courseId,
            'message' => $validated['message'] ?? null,
            'status' => Application::STATUS_PENDING,
        ]);

        $enrollmentService->syncEnrollmentFromApplication($application);

        $toEmail = config('mail.application_to', 'admin@viaanur.com');
        $bccRaw = (string) config('mail.application_bcc', '');
        $bccList = array_values(array_filter(array_map('trim', explode(',', $bccRaw))));

        $adminResult = OutboundMail::send(
            new ApplicationReceived($application),
            $toEmail,
            $bccList
        );

        $mailSent = $adminResult['sent'];
        $mailError = $adminResult['error'];
        $confirmationSent = false;

        if (config('mail.send_applicant_confirmation', false)) {
            $confirmationResult = OutboundMail::send(
                new ApplicationConfirmation($application),
                $application->email
            );
            $confirmationSent = $confirmationResult['sent'];
            if (! $mailSent) {
                $mailError = $adminResult['error'] ?? 'Admin notification to One.com failed.';
            }
        }

        $message = $mailSent
            ? 'Your enrollment request has been submitted successfully. You will get course access after admin approval.'
            : 'Enrollment request saved. Email could not be sent (see error below).';

        $deliveryNote = OutboundMail::localDeliveryNote();
        if ($mailSent && ! ($adminResult['inbox_delivery'] ?? false) && $deliveryNote === null) {
            $deliveryNote = 'Email was handed off to SMTP. If admin@viaanur.com inbox is still empty, enable MAIL_ONE_COM_HOSTED and MAIL_USE_ONE_COM_PHP_MAIL on your live One.com server.';
        }

        return response()->json([
            'success' => true,
            'mail_sent' => $mailSent,
            'admin_mail_sent' => $mailSent,
            'admin_mail_to' => $toEmail,
            'inbox_delivery' => $adminResult['inbox_delivery'] ?? false,
            'confirmation_sent' => $confirmationSent,
            'message' => $message,
            'mail_error' => $mailError,
            'delivery_note' => $deliveryNote,
        ], 200);
    }
}
