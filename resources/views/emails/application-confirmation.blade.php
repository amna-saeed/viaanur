<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        h2 { color: #322f89; margin-bottom: 16px; }
        .footer { margin-top: 24px; font-size: 12px; color: #888; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Thank you for applying</h2>
        <p>Hi {{ $application->name }},</p>
        <p>We have received your application for <strong>{{ $courseLabel }}</strong>. Our team will review your details and get back to you soon.</p>
        <p><strong>Your details:</strong></p>
        <ul>
            <li>Email: {{ $application->email }}</li>
            <li>Phone: {{ $application->phone }}</li>
            <li>Student ID: {{ $application->student_id_number }}</li>
            <li>Parent/Guardian: {{ $application->guardian_name }}</li>
            <li>Emergency Contact: {{ $application->emergency_contact_number ?: 'Same as guardian contact' }}</li>
            <li>Course: {{ $courseLabel }}</li>
        </ul>
        <p class="footer">This is an automated confirmation from {{ config('mail.from.name') }}. Please do not reply to this message unless you need to correct your details.</p>
    </div>
</body>
</html>
