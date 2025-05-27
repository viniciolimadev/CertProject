<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Importar BelongsTo para type hinting

class UserProfile extends Model
{
    use HasFactory;

    /**
     * Os atributos que são atribuíveis em massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
    'user_id',
    'phone',
    'city',
    'state',
    'social_links',
    'photo_path',
    'cep',
    'street_name',
    'street_number',
    'address_complement',
    'bairro',
    'marital_status',
    'date_of_birth',
    'nationality',
    'about_me',
];

    /**
     * Os atributos que devem ser convertidos para tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_of_birth' => 'date',
        'social_links' => 'array', // Converte a coluna 'social_links' para array (e vice-versa)
    ];

    /**
     * Obtém o usuário ao qual este perfil pertence.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo // Adicionado type hint para clareza
    {
        return $this->belongsTo(User::class);
    }
}