<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Children extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'age', 'gender', 'concern', 'interests','image', 'caregiver_id','description'];

    protected $casts = [
        'interests' => 'array', 
        'concern' => 'array', 
    ];

    public function caregiver(){
        return $this->belongsTo(User::class);
    }
}
