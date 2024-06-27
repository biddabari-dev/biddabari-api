<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Backend\CircularManagement\Circular;
use Illuminate\Auth\Access\HandlesAuthorization;

class CircularPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the circular can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the circular can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\CircularManagement\Circular  $model
     * @return mixed
     */
    public function view(User $user, Circular $model)
    {
        return true;
    }

    /**
     * Determine whether the circular can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the circular can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\CircularManagement\Circular  $model
     * @return mixed
     */
    public function update(User $user, Circular $model)
    {
        return true;
    }

    /**
     * Determine whether the circular can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\CircularManagement\Circular  $model
     * @return mixed
     */
    public function delete(User $user, Circular $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\CircularManagement\Circular  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the circular can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\CircularManagement\Circular  $model
     * @return mixed
     */
    public function restore(User $user, Circular $model)
    {
        return false;
    }

    /**
     * Determine whether the circular can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\CircularManagement\Circular  $model
     * @return mixed
     */
    public function forceDelete(User $user, Circular $model)
    {
        return false;
    }
}
