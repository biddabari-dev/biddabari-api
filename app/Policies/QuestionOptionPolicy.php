<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Backend\QuestionManagement\QuestionOption;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestionOptionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the questionOption can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the questionOption can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\QuestionManagement\QuestionOption  $model
     * @return mixed
     */
    public function view(User $user, QuestionOption $model)
    {
        return true;
    }

    /**
     * Determine whether the questionOption can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the questionOption can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\QuestionManagement\QuestionOption  $model
     * @return mixed
     */
    public function update(User $user, QuestionOption $model)
    {
        return true;
    }

    /**
     * Determine whether the questionOption can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\QuestionManagement\QuestionOption  $model
     * @return mixed
     */
    public function delete(User $user, QuestionOption $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\QuestionManagement\QuestionOption  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the questionOption can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\QuestionManagement\QuestionOption  $model
     * @return mixed
     */
    public function restore(User $user, QuestionOption $model)
    {
        return false;
    }

    /**
     * Determine whether the questionOption can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\QuestionManagement\QuestionOption  $model
     * @return mixed
     */
    public function forceDelete(User $user, QuestionOption $model)
    {
        return false;
    }
}
