<?php

namespace App\Policies;

use App\Models\Backend\ExamManagement\Exam;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExamPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the exam can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the exam can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ExamManagement\Exam  $model
     * @return mixed
     */
    public function view(User $user, Exam $model)
    {
        return true;
    }

    /**
     * Determine whether the exam can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the exam can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ExamManagement\Exam  $model
     * @return mixed
     */
    public function update(User $user, Exam $model)
    {
        return true;
    }

    /**
     * Determine whether the exam can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ExamManagement\Exam  $model
     * @return mixed
     */
    public function delete(User $user, Exam $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ExamManagement\Exam  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the exam can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ExamManagement\Exam  $model
     * @return mixed
     */
    public function restore(User $user, Exam $model)
    {
        return false;
    }

    /**
     * Determine whether the exam can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ExamManagement\Exam  $model
     * @return mixed
     */
    public function forceDelete(User $user, Exam $model)
    {
        return false;
    }
}
