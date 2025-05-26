<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoom Meeting Invitation</title>
</head>
<body>
    <h1>Zoom Meeting Invitation</h1>

    <p>Dear {{ $user->first_name }},</p>

    @if ($isProfessional)
        <p>You have been invited to a Zoom meeting as a professional for the following topic:</p>
    @else
        <p>You have been invited to a Zoom meeting for the following topic:</p>
    @endif

    <ul>
        <li><strong>Meeting Topic:</strong> {{ $data['topic'] }}</li>
        <li><strong>Start Time:</strong> {{ \Carbon\Carbon::parse($data['start_time'])->format('F j, Y, g:i a') }}</li>
        <li><strong>Duration:</strong> {{ $data['duration'] }} minutes</li>
        <li><strong>Join Link:</strong> <a href="{{ $data['join_url'] }}">Join Meeting</a></li>
        @if (!$isProfessional)
            <li><strong>Password:</strong> {{ $data['password'] }}</li>
        @endif
    </ul>

    <p>If you have any questions, feel free to reach out.</p>

    <p>Best regards,<br>The {{ config('app.name') }} Team</p>
</body>
</html>
