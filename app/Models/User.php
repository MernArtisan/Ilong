<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['first_name', 'last_name', 'email', 'password', 'role', 'login_status', 'country', 'state_city', 'zip', 'phone', 'image', 'fcm_token', 'cover_image','age'];

    protected $hidden = ['password', 'remember_token',];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function childrens()
    {
        return $this->hasMany(Children::class,  'caregiver_id');
    }


    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_user')->withTimestamps();
    }

    public function createdGroups()
    {
        return $this->hasMany(Group::class, 'creator_id');
    }


    public function groupPosts()
    {
        return $this->hasMany(GroupPost::class);
    }
 
    public function professionalProfile()
    {
        return $this->hasOne(ProfessionalProfile::class);
    } 


    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    public function licenses()
    {
        return $this->hasMany(License::class);
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'user_id'); // Customer's bookings
    }

    public function professionalBookings()
    {
        return $this->hasMany(Booking::class, 'professional_id');
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id');
    }
 
    public function notification()
    {
        return $this->hasOne(Notification::class, 'user_id', 'user_id'); // Assuming user_id is used to link
    }
































    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles')->withTimestamps();
    }

    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    public function hasPermission($permissionName)
    {
        // Ensure relationship is queried, not collection
        return $this->roles()->whereHas('permissions', function ($query) use ($permissionName) {
            $query->where('name', $permissionName);
        })->exists();
    }
}
