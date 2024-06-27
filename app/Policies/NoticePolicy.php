<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Backend\NoticeManagement\Notice;
use Illuminate\Auth\Access\HandlesAuthorization;

class NoticePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the notice can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the notice can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\NoticeManagement\Notice  $model
     * @return mixed
     */
    public function view(User $user, Notice $model)
    {
        return true;
    }

    /**
     * Determine whether the notice can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the notice can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\NoticeManagement\Notice  $model
     * @return mixed
     */
    public function update(User $user, Notice $model)
    {
        return true;
    }

    /**
     * Determine whether the notice can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\NoticeManagement\Notice  $model
     * @return mixed
     */
    public function delete(User $user, Notice $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\NoticeManagement\Notice  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the notice can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\NoticeManagement\Notice  $model
     * @return mixed
     */
    public function restore(User $user, Notice $model)
    {
        return false;
    }

    /**
     * Determine whether the notice can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\NoticeManagement\Notice  $model
     * @return mixed
     */
    public function forceDelete(User $user, Notice $model)
    {
        return false;
    }
}
