<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = [
    'user_id',
    'position',
    'company',
    'description',
    'start_date',
    'end_date',
    
];
}
