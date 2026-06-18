<?php

namespace App\Mail;

use App\Models\Application;
use App\Support\CourseApplicationMapper;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public Application $application;

    public string $courseLabel;

    public function __construct(Application $application)
    {
        $this->application = $application;
        $this->courseLabel = CourseApplicationMapper::label($application->course);
    }

    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('We received your application – ' . config('mail.from.name', 'ViAaNur Tutoring'))
            ->view('emails.application-confirmation');
    }
}
