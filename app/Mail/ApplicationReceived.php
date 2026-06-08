<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function build()
    {
        $mailable = $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('[ViAaNur] New application: ' . $this->application->name)
            ->replyTo($this->application->email, $this->application->name)
            ->view('emails.application-received');

        return $mailable->withSwiftMessage(function ($message) {
            $message->getHeaders()->addTextHeader('X-Auto-Response-Suppress', 'All');
        });
    }
}
