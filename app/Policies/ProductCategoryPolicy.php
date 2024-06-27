<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Backend\ProductManagement\ProductCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the productCategory can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the productCategory can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ProductManagement\ProductCategory  $model
     * @return mixed
     */
    public function view(User $user, ProductCategory $model)
    {
        return true;
    }

    /**
     * Determine whether the productCategory can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the productCategory can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ProductManagement\ProductCategory  $model
     * @return mixed
     */
    public function update(User $user, ProductCategory $model)
    {
        return true;
    }

    /**
     * Determine whether the productCategory can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ProductManagement\ProductCategory  $model
     * @return mixed
     */
    public function delete(User $user, ProductCategory $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ProductManagement\ProductCategory  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the productCategory can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ProductManagement\ProductCategory  $model
     * @return mixed
     */
    public function restore(User $user, ProductCategory $model)
    {
        return false;
    }

    /**
     * Determine whether the productCategory can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\ProductManagement\ProductCategory  $model
     * @return mixed
     */
    public function forceDelete(User $user, ProductCategory $model)
    {
        return false;
    }
}
