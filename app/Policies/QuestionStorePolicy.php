<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Backend\QuestionManagement\QuestionStore;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestionStorePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the questionStore can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the questionStore can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\QuestionManagement\QuestionStore  $model
     * @return mixed
     */
    public function view(User $user, QuestionStore $model)
    {
        return true;
    }

    /**
     * Determine whether the questionStore can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the questionStore can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\QuestionManagement\QuestionStore  $model
     * @return mixed
     */
    public function update(User $user, QuestionStore $model)
    {
        return true;
    }

    /**
     * Determine whether the questionStore can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\QuestionManagement\QuestionStore  $model
     * @return mixed
     */
    public function delete(User $user, QuestionStore $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\QuestionManagement\QuestionStore  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the questionStore can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\QuestionManagement\QuestionStore  $model
     * @return mixed
     */
    public function restore(User $user, QuestionStore $model)
    {
        return false;
    }

    /**
     * Determine whether the questionStore can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\QuestionManagement\QuestionStore  $model
     * @return mixed
     */
    public function forceDelete(User $user, QuestionStore $model)
    {
        return false;
    }
}
