<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Backend\AdditionalFeatureManagement\Advertisement;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdvertisementPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the advertisement can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the advertisement can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\AdditionalFeatureManagement\Advertisement  $model
     * @return mixed
     */
    public function view(User $user, Advertisement $model)
    {
        return true;
    }

    /**
     * Determine whether the advertisement can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the advertisement can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\AdditionalFeatureManagement\Advertisement  $model
     * @return mixed
     */
    public function update(User $user, Advertisement $model)
    {
        return true;
    }

    /**
     * Determine whether the advertisement can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\AdditionalFeatureManagement\Advertisement  $model
     * @return mixed
     */
    public function delete(User $user, Advertisement $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\AdditionalFeatureManagement\Advertisement  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the advertisement can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\AdditionalFeatureManagement\Advertisement  $model
     * @return mixed
     */
    public function restore(User $user, Advertisement $model)
    {
        return false;
    }

    /**
     * Determine whether the advertisement can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\AdditionalFeatureManagement\Advertisement  $model
     * @return mixed
     */
    public function forceDelete(User $user, Advertisement $model)
    {
        return false;
    }
}
