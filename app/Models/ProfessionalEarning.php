<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalEarning extends Model
{
    use HasFactory;
    protected $fillable = [
        'professional_id', 'earning_amount', 'earning_date', 'status','user_id', 'booking_id'
    ];
    public function professional()
    {
        return $this->belongsTo(User::class, 'professional_id');
    }
}
