<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    protected $fillable = [
        'role_id',
        'page_id',
        'can_create',
        'can_edit',
        'can_view',
        'can_delete',
    ];

    public function role()
    {
        return $this->belongsTo(Roles::class, 'role_id');
    }

    public function page()
    {
        return $this->belongsTo(Pages::class, 'page_id');
    }
}//class
