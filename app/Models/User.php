<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function projects()
{
    return $this->hasMany(Project::class);
}

public function certificates()
{
    return $this->hasMany(Certificate::class);
}

}
