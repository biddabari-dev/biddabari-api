<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Backend\ModelTestManagement\ModelTest;
use Illuminate\Auth\Access\HandlesAuthorization;

class ModelTestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the modelTest can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the modelTest can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ModelTestManagement\ModelTest  $model
     * @return mixed
     */
    public function view(User $user, ModelTest $model)
    {
        return true;
    }

    /**
     * Determine whether the modelTest can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the modelTest can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ModelTestManagement\ModelTest  $model
     * @return mixed
     */
    public function update(User $user, ModelTest $model)
    {
        return true;
    }

    /**
     * Determine whether the modelTest can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ModelTestManagement\ModelTest  $model
     * @return mixed
     */
    public function delete(User $user, ModelTest $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ModelTestManagement\ModelTest  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the modelTest can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ModelTestManagement\ModelTest  $model
     * @return mixed
     */
    public function restore(User $user, ModelTest $model)
    {
        return false;
    }

    /**
     * Determine whether the modelTest can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ModelTestManagement\ModelTest  $model
     * @return mixed
     */
    public function forceDelete(User $user, ModelTest $model)
    {
        return false;
    }
}
