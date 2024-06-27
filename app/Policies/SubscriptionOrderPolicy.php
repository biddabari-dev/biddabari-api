<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Backend\ExamManagement\SubscriptionOrder;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubscriptionOrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the subscriptionOrder can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the subscriptionOrder can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ExamManagement\SubscriptionOrder  $model
     * @return mixed
     */
    public function view(User $user, SubscriptionOrder $model)
    {
        return true;
    }

    /**
     * Determine whether the subscriptionOrder can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the subscriptionOrder can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ExamManagement\SubscriptionOrder  $model
     * @return mixed
     */
    public function update(User $user, SubscriptionOrder $model)
    {
        return true;
    }

    /**
     * Determine whether the subscriptionOrder can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ExamManagement\SubscriptionOrder  $model
     * @return mixed
     */
    public function delete(User $user, SubscriptionOrder $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ExamManagement\SubscriptionOrder  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the subscriptionOrder can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ExamManagement\SubscriptionOrder  $model
     * @return mixed
     */
    public function restore(User $user, SubscriptionOrder $model)
    {
        return false;
    }

    /**
     * Determine whether the subscriptionOrder can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ExamManagement\SubscriptionOrder  $model
     * @return mixed
     */
    public function forceDelete(User $user, SubscriptionOrder $model)
    {
        return false;
    }
}
