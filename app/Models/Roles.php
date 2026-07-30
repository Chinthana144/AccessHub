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

    public function hasPermission(User $user, int $page_id, string $type)
    {
        $role_id = $user->role_id;

        if($role_id == 1){
            return true;
        }
        else{
            $has_permission = Permissions::where('role_id', $role_id)
            ->where('page_id', $page_id)
            ->where('can_'.$type, 1)
            ->exists();

            return $has_permission;
        }
    }//permission
}//class
