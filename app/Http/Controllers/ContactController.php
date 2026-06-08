<?php

namespace App\Http\Controllers;

use App\Mail\ContactReceived;
use App\Support\OutboundMail;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'website' => 'nullable|string|max:500',
            'message' => 'required|string|max:5000',
        ]);

        $toEmail = config('mail.contact_to', 'admin@viaanur.com');
        $result = OutboundMail::send(new ContactReceived($validated), $toEmail);
        $mailSent = $result['sent'];
        $mailError = $result['error'];

        $message = $mailSent
            ? 'Your message has been sent successfully. We will get back to you soon.'
            : 'Message received. Email could not be sent (see error below).';

        return response()->json([
            'success' => true,
            'mail_sent' => $mailSent,
            'admin_mail_to' => $toEmail,
            'inbox_delivery' => $result['inbox_delivery'] ?? false,
            'message' => $message,
            'mail_error' => $mailError,
            'delivery_note' => OutboundMail::localDeliveryNote(),
        ], 200);
    }
}
