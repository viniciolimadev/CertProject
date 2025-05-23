<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    // Tabela correta no banco
    protected $table = 'educations';

    protected $fillable = [
        'user_id',
        'degree',
        'institution',
        'start_date',
        'end_date',
    ];

    // Relação com o usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
