<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Backend\NoticeManagement\NoticeCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class NoticeCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the noticeCategory can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the noticeCategory can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\NoticeManagement\NoticeCategory  $model
     * @return mixed
     */
    public function view(User $user, NoticeCategory $model)
    {
        return true;
    }

    /**
     * Determine whether the noticeCategory can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the noticeCategory can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\NoticeManagement\NoticeCategory  $model
     * @return mixed
     */
    public function update(User $user, NoticeCategory $model)
    {
        return true;
    }

    /**
     * Determine whether the noticeCategory can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\NoticeManagement\NoticeCategory  $model
     * @return mixed
     */
    public function delete(User $user, NoticeCategory $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\NoticeManagement\NoticeCategory  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the noticeCategory can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\NoticeManagement\NoticeCategory  $model
     * @return mixed
     */
    public function restore(User $user, NoticeCategory $model)
    {
        return false;
    }

    /**
     * Determine whether the noticeCategory can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\NoticeManagement\NoticeCategory  $model
     * @return mixed
     */
    public function forceDelete(User $user, NoticeCategory $model)
    {
        return false;
    }
}
