<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Backend\ExamManagement\ExamOrder;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExamOrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the examOrder can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the examOrder can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ExamManagement\ExamOrder  $model
     * @return mixed
     */
    public function view(User $user, ExamOrder $model)
    {
        return true;
    }

    /**
     * Determine whether the examOrder can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the examOrder can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ExamManagement\ExamOrder  $model
     * @return mixed
     */
    public function update(User $user, ExamOrder $model)
    {
        return true;
    }

    /**
     * Determine whether the examOrder can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ExamManagement\ExamOrder  $model
     * @return mixed
     */
    public function delete(User $user, ExamOrder $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ExamManagement\ExamOrder  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the examOrder can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ExamManagement\ExamOrder  $model
     * @return mixed
     */
    public function restore(User $user, ExamOrder $model)
    {
        return false;
    }

    /**
     * Determine whether the examOrder can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ExamManagement\ExamOrder  $model
     * @return mixed
     */
    public function forceDelete(User $user, ExamOrder $model)
    {
        return false;
    }
}
