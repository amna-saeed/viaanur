<?php

namespace App\Mail;

use App\Models\Application;
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
        $this->courseLabel = self::courseLabelFor($application->course);
    }

    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('We received your application – ' . config('mail.from.name', 'ViAaNur Tutoring'))
            ->view('emails.application-confirmation');
    }

    public static function courseLabelFor(string $course): string
    {
        return match ($course) {
            'social-media' => 'Introduction to Social Media Concepts',
            'gcse-maths' => 'GCSE Level Mathematics',
            'islamic-studies' => 'Islamic Studies',
            'esol' => 'Introduction to ESOL',
            'english' => 'Introduction to English',
            default => $course,
        };
    }
}
