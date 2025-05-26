<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',      // Professional's ID
        'date',         // Available date
        'time_slot',    // Specific time slot (e.g., "9-10 AM")
        'status',       // 'available' or 'booked'
    ];

    public function professional()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function booking()
    {
        return $this->hasOne(Booking::class, 'availability_id'); // One booking per availability
    }
}
