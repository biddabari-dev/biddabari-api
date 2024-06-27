<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Backend\RoleManagement\PermissionCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the permissionCategory can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the permissionCategory can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\RoleManagement\PermissionCategory  $model
     * @return mixed
     */
    public function view(User $user, PermissionCategory $model)
    {
        return true;
    }

    /**
     * Determine whether the permissionCategory can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the permissionCategory can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\RoleManagement\PermissionCategory  $model
     * @return mixed
     */
    public function update(User $user, PermissionCategory $model)
    {
        return true;
    }

    /**
     * Determine whether the permissionCategory can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\RoleManagement\PermissionCategory  $model
     * @return mixed
     */
    public function delete(User $user, PermissionCategory $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\RoleManagement\PermissionCategory  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the permissionCategory can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\RoleManagement\PermissionCategory  $model
     * @return mixed
     */
    public function restore(User $user, PermissionCategory $model)
    {
        return false;
    }

    /**
     * Determine whether the permissionCategory can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\RoleManagement\PermissionCategory  $model
     * @return mixed
     */
    public function forceDelete(User $user, PermissionCategory $model)
    {
        return false;
    }
}
