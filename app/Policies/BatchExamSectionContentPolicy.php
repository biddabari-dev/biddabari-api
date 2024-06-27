<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Backend\BatchExamManagement\BatchExamSectionContent;
use Illuminate\Auth\Access\HandlesAuthorization;

class BatchExamSectionContentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the batchExamSectionContent can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the batchExamSectionContent can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BatchExamSectionContent  $model
     * @return mixed
     */
    public function view(User $user, BatchExamSectionContent $model)
    {
        return true;
    }

    /**
     * Determine whether the batchExamSectionContent can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the batchExamSectionContent can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BatchExamSectionContent  $model
     * @return mixed
     */
    public function update(User $user, BatchExamSectionContent $model)
    {
        return true;
    }

    /**
     * Determine whether the batchExamSectionContent can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BatchExamSectionContent  $model
     * @return mixed
     */
    public function delete(User $user, BatchExamSectionContent $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BatchExamSectionContent  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the batchExamSectionContent can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BatchExamSectionContent  $model
     * @return mixed
     */
    public function restore(User $user, BatchExamSectionContent $model)
    {
        return false;
    }

    /**
     * Determine whether the batchExamSectionContent can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BatchExamSectionContent  $model
     * @return mixed
     */
    public function forceDelete(User $user, BatchExamSectionContent $model)
    {
        return false;
    }
}
