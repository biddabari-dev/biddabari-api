<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Frontend\CourseOrder\CourseOrder;
use Illuminate\Auth\Access\HandlesAuthorization;

class CourseOrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the courseOrder can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the courseOrder can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Frontend\CourseOrder\CourseOrder  $model
     * @return mixed
     */
    public function view(User $user, CourseOrder $model)
    {
        return true;
    }

    /**
     * Determine whether the courseOrder can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the courseOrder can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Frontend\CourseOrder\CourseOrder  $model
     * @return mixed
     */
    public function update(User $user, CourseOrder $model)
    {
        return true;
    }

    /**
     * Determine whether the courseOrder can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Frontend\CourseOrder\CourseOrder  $model
     * @return mixed
     */
    public function delete(User $user, CourseOrder $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Frontend\CourseOrder\CourseOrder  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the courseOrder can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Frontend\CourseOrder\CourseOrder  $model
     * @return mixed
     */
    public function restore(User $user, CourseOrder $model)
    {
        return false;
    }

    /**
     * Determine whether the courseOrder can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Frontend\CourseOrder\CourseOrder  $model
     * @return mixed
     */
    public function forceDelete(User $user, CourseOrder $model)
    {
        return false;
    }
}
