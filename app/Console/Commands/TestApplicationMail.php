<?php

namespace App\Console\Commands;

use App\Models\Application;
use App\Mail\ApplicationReceived;
use App\Support\OutboundMail;
use Illuminate\Console\Command;

class TestApplicationMail extends Command
{
    protected $signature = 'mail:test-application {to?}';
    protected $description = 'Send a test application email to check SMTP (e.g. php artisan mail:test-application)';

    public function handle()
    {
        $to = $this->argument('to') ?? config('mail.application_to', 'admin@viaanur.com');
        $this->info("Sending test application email to: {$to}");

        $application = new Application([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '+44 7500 000000',
            'course' => 'gcse-maths',
        ]);
        $application->id = 0;

        $result = OutboundMail::send(new ApplicationReceived($application), $to);
        if ($result['sent']) {
            $this->info('Email sent via ' . $result['mailer'] . '. Check admin@viaanur.com at https://mail.one.com (Inbox + Spam).');
            $note = \App\Support\OutboundMail::localDeliveryNote();
            if ($note) {
                $this->warn($note);
            }
            return 0;
        }

        $this->error('Mail failed: ' . ($result['error'] ?? 'unknown error'));
        return 1;
    }
}
