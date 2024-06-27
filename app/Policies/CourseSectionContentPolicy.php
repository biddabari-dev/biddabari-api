<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Backend\Course\CourseSectionContent;
use Illuminate\Auth\Access\HandlesAuthorization;

class CourseSectionContentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the courseSectionContent can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the courseSectionContent can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\Course\CourseSectionContent  $model
     * @return mixed
     */
    public function view(User $user, CourseSectionContent $model)
    {
        return true;
    }

    /**
     * Determine whether the courseSectionContent can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the courseSectionContent can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\Course\CourseSectionContent  $model
     * @return mixed
     */
    public function update(User $user, CourseSectionContent $model)
    {
        return true;
    }

    /**
     * Determine whether the courseSectionContent can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\Course\CourseSectionContent  $model
     * @return mixed
     */
    public function delete(User $user, CourseSectionContent $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\Course\CourseSectionContent  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the courseSectionContent can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\Course\CourseSectionContent  $model
     * @return mixed
     */
    public function restore(User $user, CourseSectionContent $model)
    {
        return false;
    }

    /**
     * Determine whether the courseSectionContent can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\Course\CourseSectionContent  $model
     * @return mixed
     */
    public function forceDelete(User $user, CourseSectionContent $model)
    {
        return false;
    }
}
