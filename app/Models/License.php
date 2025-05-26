<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'license_name', 'license_id', 'from', 'to', 'license_image'];

    // Har license ka user ke saath relation
    public function user() {
        return $this->belongsTo(User::class); // ya agar profile hai to ProfessionalProfile::class
    }
}
