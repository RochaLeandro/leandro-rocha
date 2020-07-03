<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAccess extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
