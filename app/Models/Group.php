<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'creator_id','image','description'];

    public function users(){
        return $this->belongsToMany(User::class,'group_user');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
    

    public function groupPost(){
        return $this->belongsTo(GroupPost::class);
    }
}
