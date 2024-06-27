<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Backend\QuestionManagement\QuestionTopic;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestionTopicPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the questionTopic can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the questionTopic can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\QuestionManagement\QuestionTopic  $model
     * @return mixed
     */
    public function view(User $user, QuestionTopic $model)
    {
        return true;
    }

    /**
     * Determine whether the questionTopic can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the questionTopic can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\QuestionManagement\QuestionTopic  $model
     * @return mixed
     */
    public function update(User $user, QuestionTopic $model)
    {
        return true;
    }

    /**
     * Determine whether the questionTopic can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\QuestionManagement\QuestionTopic  $model
     * @return mixed
     */
    public function delete(User $user, QuestionTopic $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\QuestionManagement\QuestionTopic  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the questionTopic can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\QuestionManagement\QuestionTopic  $model
     * @return mixed
     */
    public function restore(User $user, QuestionTopic $model)
    {
        return false;
    }

    /**
     * Determine whether the questionTopic can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\QuestionManagement\QuestionTopic  $model
     * @return mixed
     */
    public function forceDelete(User $user, QuestionTopic $model)
    {
        return false;
    }
}
