<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Backend\Course\CourseSection;
use Illuminate\Auth\Access\HandlesAuthorization;

class CourseSectionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the courseSection can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the courseSection can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CourseSection  $model
     * @return mixed
     */
    public function view(User $user, CourseSection $model)
    {
        return true;
    }

    /**
     * Determine whether the courseSection can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the courseSection can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CourseSection  $model
     * @return mixed
     */
    public function update(User $user, CourseSection $model)
    {
        return true;
    }

    /**
     * Determine whether the courseSection can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CourseSection  $model
     * @return mixed
     */
    public function delete(User $user, CourseSection $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CourseSection  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the courseSection can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CourseSection  $model
     * @return mixed
     */
    public function restore(User $user, CourseSection $model)
    {
        return false;
    }

    /**
     * Determine whether the courseSection can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CourseSection  $model
     * @return mixed
     */
    public function forceDelete(User $user, CourseSection $model)
    {
        return false;
    }
}
