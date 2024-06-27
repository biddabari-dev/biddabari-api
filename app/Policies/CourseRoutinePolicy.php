<?php

namespace App\Policies;

use App\Models\User;
use App\Policies\CoursePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;

class CourseRoutinePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the courseRoutine can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the courseRoutine can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CourseRoutine  $model
     * @return mixed
     */
    public function view(User $user, CourseRoutine $model)
    {
        return true;
    }

    /**
     * Determine whether the courseRoutine can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the courseRoutine can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CourseRoutine  $model
     * @return mixed
     */
    public function update(User $user, CourseRoutine $model)
    {
        return true;
    }

    /**
     * Determine whether the courseRoutine can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CourseRoutine  $model
     * @return mixed
     */
    public function delete(User $user, CourseRoutine $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CourseRoutine  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the courseRoutine can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CourseRoutine  $model
     * @return mixed
     */
    public function restore(User $user, CourseRoutine $model)
    {
        return false;
    }

    /**
     * Determine whether the courseRoutine can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CourseRoutine  $model
     * @return mixed
     */
    public function forceDelete(User $user, CourseRoutine $model)
    {
        return false;
    }
}
