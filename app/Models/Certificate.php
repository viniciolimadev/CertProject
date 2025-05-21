<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = ['title', 'file_path', 'description_certificate'];
    
    public function user()
{
    return $this->belongsTo(User::class);
}

}

