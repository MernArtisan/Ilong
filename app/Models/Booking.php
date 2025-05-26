<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'professional_id',
        'availability_id',
        'date',
        'time_slot',
        'note',
        'status',
        'cancel_by',
        'cancel_reason',
        'cancel_details',
        'reason_dispute',
        'dispute_detail',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function professional()
    {
        return $this->belongsTo(User::class, foreignKey: 'professional_id');
    }


    public function availability()
    {
        return $this->belongsTo(Availability::class, 'availability_id');
    }

    public function zoomMeeting()
    {
        return $this->hasOne(ZoomMeeting::class, 'booking_id');
    }

    public function Bookingearnings()
    {
        return $this->hasOne(ProfessionalEarning::class, 'booking_id', 'id');
    }
}
