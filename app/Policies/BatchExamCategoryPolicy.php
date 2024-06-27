<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Backend\BatchExamManagement\BatchExamCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class BatchExamCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the batchExamCategory can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the batchExamCategory can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BatchExamCategory  $model
     * @return mixed
     */
    public function view(User $user, BatchExamCategory $model)
    {
        return true;
    }

    /**
     * Determine whether the batchExamCategory can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the batchExamCategory can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BatchExamCategory  $model
     * @return mixed
     */
    public function update(User $user, BatchExamCategory $model)
    {
        return true;
    }

    /**
     * Determine whether the batchExamCategory can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BatchExamCategory  $model
     * @return mixed
     */
    public function delete(User $user, BatchExamCategory $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BatchExamCategory  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the batchExamCategory can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BatchExamCategory  $model
     * @return mixed
     */
    public function restore(User $user, BatchExamCategory $model)
    {
        return false;
    }

    /**
     * Determine whether the batchExamCategory can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BatchExamCategory  $model
     * @return mixed
     */
    public function forceDelete(User $user, BatchExamCategory $model)
    {
        return false;
    }
}
