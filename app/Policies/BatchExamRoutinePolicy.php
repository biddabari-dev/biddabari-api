<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Backend\BatchExamManagement\BatchExamRoutine;
use Illuminate\Auth\Access\HandlesAuthorization;

class BatchExamRoutinePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the batchExamRoutine can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the batchExamRoutine can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BatchExamRoutine  $model
     * @return mixed
     */
    public function view(User $user, BatchExamRoutine $model)
    {
        return true;
    }

    /**
     * Determine whether the batchExamRoutine can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the batchExamRoutine can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BatchExamRoutine  $model
     * @return mixed
     */
    public function update(User $user, BatchExamRoutine $model)
    {
        return true;
    }

    /**
     * Determine whether the batchExamRoutine can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BatchExamRoutine  $model
     * @return mixed
     */
    public function delete(User $user, BatchExamRoutine $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BatchExamRoutine  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the batchExamRoutine can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BatchExamRoutine  $model
     * @return mixed
     */
    public function restore(User $user, BatchExamRoutine $model)
    {
        return false;
    }

    /**
     * Determine whether the batchExamRoutine can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BatchExamRoutine  $model
     * @return mixed
     */
    public function forceDelete(User $user, BatchExamRoutine $model)
    {
        return false;
    }
}
