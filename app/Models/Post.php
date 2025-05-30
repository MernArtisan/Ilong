<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'post_id', 'id');
    }

    public function likes()
    {
        return $this->hasMany(ContentPostLike::class);
    }
    public function comments()
    {
        return $this->hasMany(ContentPostComment::class);
    }
}
