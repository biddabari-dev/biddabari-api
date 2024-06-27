<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Backend\AdditionalFeatureManagement\PopupNotification;
use Illuminate\Auth\Access\HandlesAuthorization;

class PopupNotificationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the popupNotification can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the popupNotification can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\AdditionalFeatureManagement\PopupNotification  $model
     * @return mixed
     */
    public function view(User $user, PopupNotification $model)
    {
        return true;
    }

    /**
     * Determine whether the popupNotification can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the popupNotification can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\AdditionalFeatureManagement\PopupNotification  $model
     * @return mixed
     */
    public function update(User $user, PopupNotification $model)
    {
        return true;
    }

    /**
     * Determine whether the popupNotification can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\AdditionalFeatureManagement\PopupNotification  $model
     * @return mixed
     */
    public function delete(User $user, PopupNotification $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\AdditionalFeatureManagement\PopupNotification  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the popupNotification can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\AdditionalFeatureManagement\PopupNotification  $model
     * @return mixed
     */
    public function restore(User $user, PopupNotification $model)
    {
        return false;
    }

    /**
     * Determine whether the popupNotification can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\AdditionalFeatureManagement\PopupNotification  $model
     * @return mixed
     */
    public function forceDelete(User $user, PopupNotification $model)
    {
        return false;
    }
}
