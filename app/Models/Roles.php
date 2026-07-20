<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $fillable = [
        'name',
    ];

    public function permission()
    {
        return $this->hasMany(Permissions::class);
    }

    public function hasPermission(int $page_id, int $role_id, string $type)
    {
        $has_permission = Permissions::where('role_id', $role_id)
            ->where('page_id', $page_id)
            ->where('can_'.$type, 1)
            ->exists();

        return $has_permission;
    }//permission
}//class
