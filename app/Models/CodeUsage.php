<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CodeUsage extends Model
{
    protected $fillable = [
        'camp_id',
        'username',
        'password',
        'profile',
        'mac_address',
        'first_login_at',
        'expire_at',
        'status',
    ];

    public function camp()
    {
        return $this->belongsTo(Camps::class, 'camp_id');
    }
}//class
