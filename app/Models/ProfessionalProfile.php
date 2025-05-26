<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalProfile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'professional_field',
        'education_degrees',
        'certifications',
        'credentials',
        'skills',
        'languages',
        'website',
        'about',
        'hour_rate',
        'practice',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
