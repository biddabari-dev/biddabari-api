<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Backend\CircularManagement\CircularCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class CircularCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the circularCategory can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the circularCategory can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\CircularManagement\CircularCategory  $model
     * @return mixed
     */
    public function view(User $user, CircularCategory $model)
    {
        return true;
    }

    /**
     * Determine whether the circularCategory can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the circularCategory can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\CircularManagement\CircularCategory  $model
     * @return mixed
     */
    public function update(User $user, CircularCategory $model)
    {
        return true;
    }

    /**
     * Determine whether the circularCategory can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\CircularManagement\CircularCategory  $model
     * @return mixed
     */
    public function delete(User $user, CircularCategory $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\CircularManagement\CircularCategory  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the circularCategory can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\CircularManagement\CircularCategory  $model
     * @return mixed
     */
    public function restore(User $user, CircularCategory $model)
    {
        return false;
    }

    /**
     * Determine whether the circularCategory can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\CircularManagement\CircularCategory  $model
     * @return mixed
     */
    public function forceDelete(User $user, CircularCategory $model)
    {
        return false;
    }
}
