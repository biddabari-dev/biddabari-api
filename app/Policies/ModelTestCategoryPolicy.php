<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Backend\ModelTestManagement\ModelTestCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class ModelTestCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the modelTestCategory can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the modelTestCategory can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ModelTestManagement\ModelTestCategory  $model
     * @return mixed
     */
    public function view(User $user, ModelTestCategory $model)
    {
        return true;
    }

    /**
     * Determine whether the modelTestCategory can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the modelTestCategory can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ModelTestManagement\ModelTestCategory  $model
     * @return mixed
     */
    public function update(User $user, ModelTestCategory $model)
    {
        return true;
    }

    /**
     * Determine whether the modelTestCategory can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ModelTestManagement\ModelTestCategory  $model
     * @return mixed
     */
    public function delete(User $user, ModelTestCategory $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ModelTestManagement\ModelTestCategory  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the modelTestCategory can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ModelTestManagement\ModelTestCategory  $model
     * @return mixed
     */
    public function restore(User $user, ModelTestCategory $model)
    {
        return false;
    }

    /**
     * Determine whether the modelTestCategory can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ModelTestManagement\ModelTestCategory  $model
     * @return mixed
     */
    public function forceDelete(User $user, ModelTestCategory $model)
    {
        return false;
    }
}
