<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Backend\ProductManagement\ProductAuthor;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductAuthorPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the productAuthor can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the productAuthor can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ProductManagement\ProductAuthor  $model
     * @return mixed
     */
    public function view(User $user, ProductAuthor $model)
    {
        return true;
    }

    /**
     * Determine whether the productAuthor can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the productAuthor can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ProductManagement\ProductAuthor  $model
     * @return mixed
     */
    public function update(User $user, ProductAuthor $model)
    {
        return true;
    }

    /**
     * Determine whether the productAuthor can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ProductManagement\ProductAuthor  $model
     * @return mixed
     */
    public function delete(User $user, ProductAuthor $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ProductManagement\ProductAuthor  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the productAuthor can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ProductManagement\ProductAuthor  $model
     * @return mixed
     */
    public function restore(User $user, ProductAuthor $model)
    {
        return false;
    }

    /**
     * Determine whether the productAuthor can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ProductManagement\ProductAuthor  $model
     * @return mixed
     */
    public function forceDelete(User $user, ProductAuthor $model)
    {
        return false;
    }
}
