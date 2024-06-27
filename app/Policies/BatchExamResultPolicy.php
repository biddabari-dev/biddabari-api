<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Backend\BatchExamManagement\BatchExamResult;
use Illuminate\Auth\Access\HandlesAuthorization;

class BatchExamResultPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the batchExamResult can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the batchExamResult can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BatchExamResult  $model
     * @return mixed
     */
    public function view(User $user, BatchExamResult $model)
    {
        return true;
    }

    /**
     * Determine whether the batchExamResult can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the batchExamResult can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BatchExamResult  $model
     * @return mixed
     */
    public function update(User $user, BatchExamResult $model)
    {
        return true;
    }

    /**
     * Determine whether the batchExamResult can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BatchExamResult  $model
     * @return mixed
     */
    public function delete(User $user, BatchExamResult $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BatchExamResult  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the batchExamResult can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BatchExamResult  $model
     * @return mixed
     */
    public function restore(User $user, BatchExamResult $model)
    {
        return false;
    }

    /**
     * Determine whether the batchExamResult can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BatchExamResult  $model
     * @return mixed
     */
    public function forceDelete(User $user, BatchExamResult $model)
    {
        return false;
    }
}
