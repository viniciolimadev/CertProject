<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Adicionado
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory; // Adicionado

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'city',
        'state',
        'phone',
        'email', // Considere se este campo é necessário ou se é redundante com User->email
        'social_links',
        'photo_path', // Adicionado para permitir atribuição em massa da foto
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'social_links' => 'array',
        // Se 'email' for mantido e deva ser verificado como um endereço de e-mail válido no nível do modelo
        // (embora a validação de requisição seja o local primário para isso):
        // 'email' => 'string',
    ];

    /**
     * Get the user that owns the profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
