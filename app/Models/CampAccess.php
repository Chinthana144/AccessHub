<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampAccess extends Model
{
    protected $fillable = [
        'user_id',
        'camp_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function camp()
    {
        return $this->belongsTo(Camps::class, 'camp_id');
    }
}
