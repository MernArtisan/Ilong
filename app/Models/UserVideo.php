<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVideo extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'video', 'description',
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(VideoLike::class, 'video_id');
    }
    public function comments()
    {
        return $this->hasMany(VideoComment::class, 'video_id');
    }
    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }

    // Add comments count to the video model
    public function getCommentsCountAttribute()
    {
        return $this->comments()->count();
    }

}
