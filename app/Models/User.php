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

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'bio',
        'location',
        'availability_status',
        'avatar',
        'github',     
        'linkedin',   
        'instagram',  
        'is_suspended',
        'suspend_reason',
    ];

// Tambahkan fungsi relasi ini di dalam class User
public function skills()
{
    return $this->belongsToMany(Skill::class);
}

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function sentRequests()
{
    return $this->hasMany(CollaborationRequest::class, 'sender_id');
}

public function receivedRequests()
{
    return $this->hasMany(CollaborationRequest::class, 'receiver_id');
}

public function projects()
{
    return $this->hasMany(Project::class);
}

/**
     * Relasi untuk mengambil daftar talenta yang disimpan (Bookmark)
     */
    public function savedTalents()
    {
        return $this->belongsToMany(User::class, 'bookmarks', 'user_id', 'talent_id')->withTimestamps();
    }

}
