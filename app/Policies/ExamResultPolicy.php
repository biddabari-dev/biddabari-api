<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Backend\ExamManagement\ExamResult;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExamResultPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the examResult can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the examResult can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ExamManagement\ExamResult  $model
     * @return mixed
     */
    public function view(User $user, ExamResult $model)
    {
        return true;
    }

    /**
     * Determine whether the examResult can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the examResult can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ExamManagement\ExamResult  $model
     * @return mixed
     */
    public function update(User $user, ExamResult $model)
    {
        return true;
    }

    /**
     * Determine whether the examResult can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ExamManagement\ExamResult  $model
     * @return mixed
     */
    public function delete(User $user, ExamResult $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ExamManagement\ExamResult  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the examResult can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ExamManagement\ExamResult  $model
     * @return mixed
     */
    public function restore(User $user, ExamResult $model)
    {
        return false;
    }

    /**
     * Determine whether the examResult can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ExamManagement\ExamResult  $model
     * @return mixed
     */
    public function forceDelete(User $user, ExamResult $model)
    {
        return false;
    }
}
