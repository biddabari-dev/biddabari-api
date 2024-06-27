<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Backend\BatchExamManagement\BatchExam;
use Illuminate\Auth\Access\HandlesAuthorization;

class BatchExamPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the batchExam can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the batchExam can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BatchExam  $model
     * @return mixed
     */
    public function view(User $user, BatchExam $model)
    {
        return true;
    }

    /**
     * Determine whether the batchExam can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the batchExam can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BatchExam  $model
     * @return mixed
     */
    public function update(User $user, BatchExam $model)
    {
        return true;
    }

    /**
     * Determine whether the batchExam can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BatchExam  $model
     * @return mixed
     */
    public function delete(User $user, BatchExam $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BatchExam  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the batchExam can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BatchExam  $model
     * @return mixed
     */
    public function restore(User $user, BatchExam $model)
    {
        return false;
    }

    /**
     * Determine whether the batchExam can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BatchExam  $model
     * @return mixed
     */
    public function forceDelete(User $user, BatchExam $model)
    {
        return false;
    }
}
