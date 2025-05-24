<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description_certificate',
        'user_id',
        'file_path',
        'start_date',
        'end_date',
        'duration', // 'duration' já está fillable, o comentário anterior foi removido.
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
     * Get the user that owns the certificate.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
