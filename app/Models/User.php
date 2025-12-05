<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'slug',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function skill()
    {
        return $this->hasOne(Skill::class);
    }

    // Relasi: 1 User punya banyak Project
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    // Relasi: 1 User punya banyak Certificate
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function assessmentSubmissions()
    {
        return $this->hasMany(AssessmentSubmission::class);
    }
}
