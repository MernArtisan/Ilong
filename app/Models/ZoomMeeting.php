<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoomMeeting extends Model
{
    use HasFactory;

    // Specify the table name if it's not the plural form of the model name
    protected $table = 'zoom_meetings';

    // Define the fillable fields
    protected $fillable = [
        'meeting_id',
        'host_id',
        'topic',
        'start_time',
        'duration',
        'password',
        'start_url',
        'join_url',
        'status',
        'professional_id',
        'user_id',
        'availability_id',
        'booking_id'
    ];

    protected $casts = [
        'start_time' => 'datetime', 
    ];

    public function availability()
    {
        return $this->belongsTo(Availability::class, 'availability_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function professional()
    {
        return $this->belongsTo(User::class, 'professional_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
}
