<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Backend\ExamManagement\ExamSubscriptionPackage;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExamSubscriptionPackagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the examSubscriptionPackage can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the examSubscriptionPackage can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ExamManagement\ExamSubscriptionPackage  $model
     * @return mixed
     */
    public function view(User $user, ExamSubscriptionPackage $model)
    {
        return true;
    }

    /**
     * Determine whether the examSubscriptionPackage can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the examSubscriptionPackage can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ExamManagement\ExamSubscriptionPackage  $model
     * @return mixed
     */
    public function update(User $user, ExamSubscriptionPackage $model)
    {
        return true;
    }

    /**
     * Determine whether the examSubscriptionPackage can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ExamManagement\ExamSubscriptionPackage  $model
     * @return mixed
     */
    public function delete(User $user, ExamSubscriptionPackage $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ExamManagement\ExamSubscriptionPackage  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the examSubscriptionPackage can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ExamManagement\ExamSubscriptionPackage  $model
     * @return mixed
     */
    public function restore(User $user, ExamSubscriptionPackage $model)
    {
        return false;
    }

    /**
     * Determine whether the examSubscriptionPackage can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ExamManagement\ExamSubscriptionPackage  $model
     * @return mixed
     */
    public function forceDelete(User $user, ExamSubscriptionPackage $model)
    {
        return false;
    }
}
