<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    |
    | This option controls the default mailer that is used to send any email
    | messages sent by your application. Alternative mailers may be setup
    | and used as needed; however, this mailer will be used by default.
    |
    */

    'default' => env('MAIL_MAILER', 'smtp'),

    /*
    |--------------------------------------------------------------------------
    | Mailer Configurations
    |--------------------------------------------------------------------------
    |
    | Here you may configure all of the mailers used by your application plus
    | their respective settings. Several examples have been configured for
    | you and you are free to add your own as your application requires.
    |
    | Laravel supports a variety of mail "transport" drivers to be used while
    | sending an e-mail. You will specify which one you are using for your
    | mailers below. You are free to add additional mailers as required.
    |
    | Supported: "smtp", "sendmail", "mailgun", "ses",
    |            "postmark", "log", "array", "failover"
    |
    */

    'mailers' => [
        'smtp' => [
            'transport' => 'smtp',
            'host' => env('MAIL_HOST', 'send.one.com'),
            'port' => env('MAIL_PORT', 587),
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => env('MAIL_TIMEOUT', 60),
            'auth_mode' => null,
        ],

        // One.com: for email clients use send.one.com (587 recommended). mailout.one.com only works when site is on One.com.
        'onecom_send_587' => [
            'transport' => 'smtp',
            'host' => 'send.one.com',
            'port' => 587,
            'encryption' => 'tls',
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => 60,
            'auth_mode' => null,
        ],

        'onecom_send_465' => [
            'transport' => 'smtp',
            'host' => 'send.one.com',
            'port' => 465,
            'encryption' => 'ssl',
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => 60,
            'auth_mode' => null,
        ],

        'onecom_send_25' => [
            'transport' => 'smtp',
            'host' => 'send.one.com',
            'port' => 25,
            'encryption' => null,
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => 60,
            'auth_mode' => null,
        ],

        'onecom_mailout_587' => [
            'transport' => 'smtp',
            'host' => 'mailout.one.com',
            'port' => 587,
            'encryption' => 'tls',
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => 60,
            'auth_mode' => null,
        ],

        'onecom_mailout_465' => [
            'transport' => 'smtp',
            'host' => 'mailout.one.com',
            'port' => 465,
            'encryption' => 'ssl',
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => 60,
            'auth_mode' => null,
        ],

        'ses' => [
            'transport' => 'ses',
        ],

        'mailgun' => [
            'transport' => 'mailgun',
        ],

        'postmark' => [
            'transport' => 'postmark',
        ],

        'sendmail' => [
            'transport' => 'sendmail',
            'path' => env('MAIL_SENDMAIL_PATH', '/usr/sbin/sendmail -t -i'),
        ],

        'log' => [
            'transport' => 'log',
            'channel' => env('MAIL_LOG_CHANNEL'),
        ],

        'array' => [
            'transport' => 'array',
        ],

        'failover' => [
            'transport' => 'failover',
            'mailers' => [
                'smtp',
                'log',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    |
    | You may wish for all e-mails sent by your application to be sent from
    | the same address. Here, you may specify a name and address that is
    | used globally for all e-mails that are sent by your application.
    |
    */

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
        'name' => env('MAIL_FROM_NAME', 'Example'),
    ],

    // All form emails → admin@viaanur.com (https://mail.one.com)
    'application_to' => env('MAIL_APPLICATION_TO', 'admin@viaanur.com'),
    'contact_to' => env('MAIL_CONTACT_TO', 'admin@viaanur.com'),

    'application_bcc' => env('MAIL_APPLICATION_BCC', null),

    'send_applicant_confirmation' => env('MAIL_SEND_APPLICANT_CONFIRMATION', false),

    // true on live site hosted at One.com (enables mailout + PHP mail — real inbox delivery)
    'one_com_hosted' => env('MAIL_ONE_COM_HOSTED', false),

    // true on live One.com: use PHP mail() first (recommended by One.com for websites)
    'use_one_com_php_mail' => env('MAIL_USE_ONE_COM_PHP_MAIL', false),

    /*
    |--------------------------------------------------------------------------
    | Markdown Mail Settings
    |--------------------------------------------------------------------------
    |
    | If you are using Markdown based email rendering, you may configure your
    | theme and component paths here, allowing you to customize the design
    | of the emails. Or, you may simply stick with the Laravel defaults!
    |
    */

    'markdown' => [
        'theme' => 'default',

        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],

];
