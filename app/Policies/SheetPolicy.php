<?php

namespace App\Policies;

use App\Models\Permissions;
use App\Models\Sheets;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class SheetPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Sheets $sheets): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $role_id = $user->role->id;
        $page_id = 6; //sheet page ID

        if($role_id == 1){
            return true;
        }
        else{
            $has_permission = Permissions::where('role_id', $role_id)
                ->where('page_id', $page_id)
                ->where('can_create', 1)
                ->exists();

            return $has_permission ? 1 : 0;
        }//else
    }//create

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Sheets $sheets): bool
    {
        $role_id = $user->role->id;
        $page_id = 6; //sheet page ID

        if($role_id == 1){
            return true;
        }
        else{
            $has_permission = Permissions::where('role_id', $role_id)
                ->where('page_id', $page_id)
                ->where('can_edit', 1)
                ->exists();

            return $has_permission ? 1 : 0;
        } 
    }//update

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Sheets $sheets): bool
    {
        $role_id = $user->role->id;
        $page_id = 6; //sheet page ID

        if($role_id == 1)
        {
            return true;
        }
        else
        {
            $has_permission = Permissions::where('role_id', $role_id)
            ->where('page_id', $page_id)
            ->where('can_delete', 1)
            ->exists();

            return $has_permission ? 1 : 0;
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Sheets $sheets): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Sheets $sheets): bool
    {
        return false;
    }
}
