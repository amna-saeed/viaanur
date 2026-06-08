<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        h2 { color: #322f89; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 10px 0; border-bottom: 1px solid #eee; }
        td:first-child { font-weight: 600; width: 140px; color: #555; }
        .footer { margin-top: 30px; font-size: 12px; color: #888; }
    </style>
</head>
<body>
    <div class="container">
        <h2>New course application received</h2>
        <p>You have received a new application from the website.</p>
        <table>
            <tr><td>Name</td><td>{{ $application->name }}</td></tr>
            <tr><td>Email</td><td>{{ $application->email }}</td></tr>
            <tr><td>Phone</td><td>{{ $application->phone }}</td></tr>
            <tr><td>Student ID</td><td>{{ $application->student_id_number ?: 'Not provided' }}</td></tr>
            <tr><td>Date of Birth</td><td>{{ $application->date_of_birth ? $application->date_of_birth->format('M d, Y') : 'Not provided' }}</td></tr>
            <tr><td>Gender</td><td>{{ $application->gender ? (\App\Support\StudentInformation::GENDER_OPTIONS[$application->gender] ?? ucfirst(str_replace('_', ' ', $application->gender))) : 'Not provided' }}</td></tr>
            <tr><td>School</td><td>{{ $application->school_name ?: 'Not applicable' }}</td></tr>
            <tr><td>Home Address</td><td>{{ $application->home_address ?: 'Not provided' }}</td></tr>
            <tr><td>Guardian</td><td>{{ $application->guardian_name ?: 'Not provided' }}</td></tr>
            <tr><td>Guardian Contact</td><td>{{ $application->guardian_contact_number ?: 'Not provided' }}</td></tr>
            <tr><td>Emergency Contact</td><td>{{ $application->emergency_contact_number ?: 'Same as guardian contact' }}</td></tr>
            <tr><td>Course</td><td>{{ $application->course }}</td></tr>
            @if($application->message)
            <tr><td>Message</td><td>{{ $application->message }}</td></tr>
            @endif
        </table>
        <p class="footer">This email was sent from ViAaNur Tutoring website. Reply directly to the applicant's email above.</p>
    </div>
</body>
</html>
