<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // Table name if it's different from the plural of the model name
    protected $table = 'payments';

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'booking_id',
        'user_id',
        'professional_id',
        'intent_id',
        'amount',
        'status'
    ];

    // Define relationships (if applicable)
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function professional()
    {
        return $this->belongsTo(User::class, 'professional_id');
    }
}
