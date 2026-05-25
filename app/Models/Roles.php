<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $fillable = [
        'name',
    ];

    public function role()
    {
        return $this->belongsTo(User::class, "role_id");
    }
}//class
