<!DOCTYPE html>
<html>
<head>
    <title>Booking Dispute Notification</title>
</head>
<body>
    <h1>Booking Dispute Notification</h1>
    <p>Hello {{ $user->name }},</p>
    <p>A dispute has been raised for your booking. Here are the details:</p>
    <p><strong>Booking ID:</strong> NJE{{ str_pad($booking->id, 9, '0', STR_PAD_LEFT) }}</p>
    <p><strong>Reason for Dispute:</strong> {{ $disputeDetail['reason_dispute'] }}</p>
    <p><strong>Dispute Detail:</strong> {{ $disputeDetail['dispute_detail'] }}</p>
    <p></p>
    <p>Thank you.</p>
</body>
</html>
