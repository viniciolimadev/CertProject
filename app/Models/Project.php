<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'url_project',
        'public',
        'user_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'public' => 'boolean', // Adicionado para garantir que 'public' seja tratado como booleano
    ];

    /**
     * Get the user that owns the project.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
