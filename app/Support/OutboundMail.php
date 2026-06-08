<?php

namespace App\Support;

use App\Mail\ApplicationReceived;
use App\Mail\ContactReceived;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OutboundMail
{
    /** send.one.com — email clients & local dev (SMTP accept ≠ One.com inbox delivery). */
    public const MAILERS_CLIENT = [
        'onecom_send_587',
        'onecom_send_465',
        'onecom_send_25',
        'smtp',
    ];

    /** mailout.one.com — website on One.com hosting ([One.com docs](https://help.one.com/hc/en-us/articles/115005594345)). */
    public const MAILERS_WEBSITE = [
        'onecom_mailout_587',
        'onecom_mailout_465',
        'onecom_send_587',
        'onecom_send_465',
        'smtp',
    ];

    /**
     * @param  string|list<string>  $to
     * @param  list<string>  $bcc
     * @return array{sent: bool, error: ?string, mailer: ?string, inbox_delivery: bool}
     */
    public static function send(Mailable $mailable, string|array $to, array $bcc = []): array
    {
        $recipients = is_array($to) ? $to : [$to];
        $primaryTo = $recipients[0];

        if (config('mail.use_one_com_php_mail', false)) {
            $phpResult = self::sendViaPhpMail($mailable, $primaryTo, $bcc);
            if ($phpResult['sent']) {
                return array_merge($phpResult, ['inbox_delivery' => true]);
            }
            Log::warning('One.com PHP mail() failed, falling back to SMTP', [
                'error' => $phpResult['error'],
            ]);
        }

        if (config('mail.one_com_hosted', false)) {
            $sendmailResult = self::sendViaSendmail($mailable, $recipients, $bcc);
            if ($sendmailResult['sent']) {
                return array_merge($sendmailResult, ['inbox_delivery' => true]);
            }
        }

        $smtpResult = self::sendViaSmtp($mailable, $recipients, $bcc);

        return array_merge($smtpResult, [
            'inbox_delivery' => $smtpResult['sent'] && self::expectsInboxDelivery($smtpResult['mailer']),
        ]);
    }

    public static function expectsInboxDelivery(?string $mailer): bool
    {
        if (self::isLocalDevelopment()) {
            return false;
        }

        if (config('mail.use_one_com_php_mail', false) || config('mail.one_com_hosted', false)) {
            return true;
        }

        return $mailer !== null && str_contains($mailer, 'mailout');
    }

    public static function isLocalDevelopment(): bool
    {
        return app()->environment('local') && ! config('mail.one_com_hosted', false);
    }

    public static function localDeliveryNote(): ?string
    {
        if (! self::isLocalDevelopment()) {
            return null;
        }

        return 'Testing on local PC: SMTP may show success but One.com inbox (admin@viaanur.com) often stays empty. '
            . 'On live One.com hosting set MAIL_ONE_COM_HOSTED=true and MAIL_USE_ONE_COM_PHP_MAIL=true in .env.';
    }

    /**
     * @param  list<string>  $recipients
     * @param  list<string>  $bcc
     * @return array{sent: bool, error: ?string, mailer: ?string}
     */
    private static function sendViaPhpMail(Mailable $mailable, string $to, array $bcc = []): array
    {
        if (! function_exists('mail')) {
            return ['sent' => false, 'error' => 'PHP mail() is not available on this server', 'mailer' => null];
        }

        $mailable->build();
        $from = (string) config('mail.from.address');
        $fromName = (string) config('mail.from.name');
        $subject = (string) ($mailable->subject ?? 'Notification');
        $html = $mailable->render();
        $reply = self::replyToFor($mailable);

        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= 'From: ' . self::formatAddress($fromName, $from) . "\r\n";
        if ($reply['address']) {
            $headers .= 'Reply-To: ' . self::formatAddress($reply['name'], $reply['address']) . "\r\n";
        }
        if ($bcc !== []) {
            $headers .= 'Bcc: ' . implode(', ', $bcc) . "\r\n";
        }
        $headers .= "X-Mailer: ViAaNur-Website\r\n";

        $encodedSubject = function_exists('mb_encode_mimeheader')
            ? mb_encode_mimeheader($subject, 'UTF-8', 'B')
            : $subject;

        $ok = @mail($to, $encodedSubject, $html, $headers, '-f' . $from);

        if ($ok) {
            Log::info('Outbound email sent via PHP mail()', [
                'to' => $to,
                'mailable' => $mailable::class,
            ]);

            return ['sent' => true, 'error' => null, 'mailer' => 'onecom_php_mail'];
        }

        return ['sent' => false, 'error' => 'PHP mail() returned false', 'mailer' => null];
    }

    /**
     * @param  list<string>  $recipients
     * @param  list<string>  $bcc
     * @return array{sent: bool, error: ?string, mailer: ?string}
     */
    private static function sendViaSendmail(Mailable $mailable, array $recipients, array $bcc = []): array
    {
        try {
            $pending = Mail::mailer('sendmail')->to($recipients);
            if ($bcc !== []) {
                $pending->bcc($bcc);
            }
            $pending->send($mailable);
            Log::info('Outbound email sent via sendmail', [
                'to' => $recipients,
                'mailable' => $mailable::class,
            ]);

            return ['sent' => true, 'error' => null, 'mailer' => 'sendmail'];
        } catch (\Throwable $e) {
            Log::warning('Outbound sendmail failed', ['message' => $e->getMessage()]);

            return ['sent' => false, 'error' => $e->getMessage(), 'mailer' => null];
        }
    }

    /**
     * @param  list<string>  $recipients
     * @param  list<string>  $bcc
     * @return array{sent: bool, error: ?string, mailer: ?string}
     */
    private static function sendViaSmtp(Mailable $mailable, array $recipients, array $bcc = []): array
    {
        $username = config('mail.mailers.smtp.username');
        $password = config('mail.mailers.smtp.password');
        if (empty($username) || empty($password)) {
            return [
                'sent' => false,
                'error' => 'Set MAIL_USERNAME and MAIL_PASSWORD in .env, then php artisan config:clear',
                'mailer' => null,
            ];
        }

        $lastError = null;
        foreach (self::smtpMailers() as $mailerName) {
            try {
                $pending = Mail::mailer($mailerName)->to($recipients);
                if ($bcc !== []) {
                    $pending->bcc($bcc);
                }
                $pending->send($mailable);
                Log::info('Outbound email accepted by SMTP', [
                    'to' => $recipients,
                    'mailer' => $mailerName,
                    'mailable' => $mailable::class,
                ]);

                return ['sent' => true, 'error' => null, 'mailer' => $mailerName];
            } catch (\Throwable $e) {
                Log::warning('Outbound email failed: ' . $mailerName, [
                    'mailable' => $mailable::class,
                    'message' => $e->getMessage(),
                ]);
                $lastError = $e->getMessage();
            }
        }

        return ['sent' => false, 'error' => $lastError, 'mailer' => null];
    }

    /** @return list<string> */
    private static function smtpMailers(): array
    {
        return config('mail.one_com_hosted', false)
            ? self::MAILERS_WEBSITE
            : self::MAILERS_CLIENT;
    }

    /** @return array{address: ?string, name: ?string} */
    private static function replyToFor(Mailable $mailable): array
    {
        if ($mailable instanceof ApplicationReceived) {
            return [
                'address' => $mailable->application->email,
                'name' => $mailable->application->name,
            ];
        }

        if ($mailable instanceof ContactReceived) {
            return [
                'address' => $mailable->email,
                'name' => $mailable->name,
            ];
        }

        return ['address' => null, 'name' => null];
    }

    private static function formatAddress(?string $name, string $address): string
    {
        if ($name) {
            return sprintf('%s <%s>', $name, $address);
        }

        return $address;
    }
}
