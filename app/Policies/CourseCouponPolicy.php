<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Backend\Course\CourseCoupon;
use Illuminate\Auth\Access\HandlesAuthorization;

class CourseCouponPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the courseCoupon can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the courseCoupon can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\Course\CourseCoupon  $model
     * @return mixed
     */
    public function view(User $user, CourseCoupon $model)
    {
        return true;
    }

    /**
     * Determine whether the courseCoupon can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the courseCoupon can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\Course\CourseCoupon  $model
     * @return mixed
     */
    public function update(User $user, CourseCoupon $model)
    {
        return true;
    }

    /**
     * Determine whether the courseCoupon can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\Course\CourseCoupon  $model
     * @return mixed
     */
    public function delete(User $user, CourseCoupon $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\Course\CourseCoupon  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the courseCoupon can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\Course\CourseCoupon  $model
     * @return mixed
     */
    public function restore(User $user, CourseCoupon $model)
    {
        return false;
    }

    /**
     * Determine whether the courseCoupon can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\Course\CourseCoupon  $model
     * @return mixed
     */
    public function forceDelete(User $user, CourseCoupon $model)
    {
        return false;
    }
}
