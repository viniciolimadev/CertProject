<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
    
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    // Certifique-se que este método existe
    public function educations()
    {
        return $this->hasMany(Education::class);
    }
}
