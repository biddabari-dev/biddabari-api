<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Backend\RoleManagement\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the permission can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the permission can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Permission  $model
     * @return mixed
     */
    public function view(User $user, Permission $model)
    {
        return true;
    }

    /**
     * Determine whether the permission can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the permission can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Permission  $model
     * @return mixed
     */
    public function update(User $user, Permission $model)
    {
        return true;
    }

    /**
     * Determine whether the permission can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Permission  $model
     * @return mixed
     */
    public function delete(User $user, Permission $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Permission  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the permission can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Permission  $model
     * @return mixed
     */
    public function restore(User $user, Permission $model)
    {
        return false;
    }

    /**
     * Determine whether the permission can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Permission  $model
     * @return mixed
     */
    public function forceDelete(User $user, Permission $model)
    {
        return false;
    }
}
