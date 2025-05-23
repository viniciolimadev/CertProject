<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

   protected $fillable = [
    'title',
    'description_certificate',
    'user_id',
    'file_path',
    'start_date',
    'end_date',
    'duration' // no fillable

];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


