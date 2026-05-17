<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Mail\ApplicationReceived;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ApplicationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:50',
            'course' => 'required|string|max:100',
        ]);

        $application = Application::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'course' => $validated['course'],
            'message' => $request->input('message'),
        ]);

        $toEmail = config('mail.application_to', 'admin@viaanur.com');
        $bccRaw = (string) config('mail.application_bcc', '');
        $bccList = array_values(array_filter(array_map('trim', explode(',', $bccRaw))));
        $mailSent = false;
        $mailError = null;
        $mailable = new ApplicationReceived($application);

        $username = config('mail.mailers.smtp.username');
        $password = config('mail.mailers.smtp.password');
        if (empty($username) || empty($password)) {
            $mailError = 'Set MAIL_USERNAME and MAIL_PASSWORD (One.com) in .env, then php artisan config:clear';
        } else {
            $mailersToTry = ['onecom_send_587', 'onecom_send_465', 'onecom_send_25', 'smtp', 'onecom_mailout_587', 'onecom_mailout_465'];
            foreach ($mailersToTry as $mailerName) {
                try {
                    $pending = Mail::mailer($mailerName)->to($toEmail);
                    if ($bccList !== []) {
                        $pending->bcc($bccList);
                    }
                    $pending->send($mailable);
                    $mailSent = true;
                    $mailError = null;
                    Log::info('Application notification email accepted by SMTP', [
                        'to' => $toEmail,
                        'mailer' => $mailerName,
                    ]);
                    break;
                } catch (\Exception $e) {
                    \Log::warning('Application email failed: ' . $mailerName, ['message' => $e->getMessage()]);
                    $mailError = $e->getMessage();
                }
            }
        }

        $message = $mailSent
            ? 'Your request has been submitted successfully. We will reach out to you soon.'
            : 'Application saved. Email could not be sent (see error below).';

        return response()->json([
            'success' => true,
            'mail_sent' => $mailSent,
            'message' => $message,
            'mail_error' => $mailError,
        ], 200);
    }
}
