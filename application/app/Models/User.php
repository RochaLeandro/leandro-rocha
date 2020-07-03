<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $guarded = [];

    public function accesses()
    {
        return $this->hasMany(UserAccess::class, 'user_id');
    }
}
