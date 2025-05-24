<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Adicionado
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory; // Adicionado

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'position',
        'company',
        'description',
        'start_date',
        'end_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date', // Adicionado
        'end_date' => 'date',   // Adicionado
    ];

    /**
     * Get the user that owns the experience.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
