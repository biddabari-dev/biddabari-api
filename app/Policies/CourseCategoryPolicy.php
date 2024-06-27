<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Backend\Course\CourseCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class CourseCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the courseCategory can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the courseCategory can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\Course\CourseCategory  $model
     * @return mixed
     */
    public function view(User $user, CourseCategory $model)
    {
        return true;
    }

    /**
     * Determine whether the courseCategory can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the courseCategory can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\Course\CourseCategory  $model
     * @return mixed
     */
    public function update(User $user, CourseCategory $model)
    {
        return true;
    }

    /**
     * Determine whether the courseCategory can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\Course\CourseCategory  $model
     * @return mixed
     */
    public function delete(User $user, CourseCategory $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\Course\CourseCategory  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the courseCategory can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\Course\CourseCategory  $model
     * @return mixed
     */
    public function restore(User $user, CourseCategory $model)
    {
        return false;
    }

    /**
     * Determine whether the courseCategory can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\Course\CourseCategory  $model
     * @return mixed
     */
    public function forceDelete(User $user, CourseCategory $model)
    {
        return false;
    }
}
