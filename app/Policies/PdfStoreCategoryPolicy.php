<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Backend\PdfManagement\PdfStoreCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class PdfStoreCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the pdfStoreCategory can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the pdfStoreCategory can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\PdfManagement\PdfStoreCategory  $model
     * @return mixed
     */
    public function view(User $user, PdfStoreCategory $model)
    {
        return true;
    }

    /**
     * Determine whether the pdfStoreCategory can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the pdfStoreCategory can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\PdfManagement\PdfStoreCategory  $model
     * @return mixed
     */
    public function update(User $user, PdfStoreCategory $model)
    {
        return true;
    }

    /**
     * Determine whether the pdfStoreCategory can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\PdfManagement\PdfStoreCategory  $model
     * @return mixed
     */
    public function delete(User $user, PdfStoreCategory $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\PdfManagement\PdfStoreCategory  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the pdfStoreCategory can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\PdfManagement\PdfStoreCategory  $model
     * @return mixed
     */
    public function restore(User $user, PdfStoreCategory $model)
    {
        return false;
    }

    /**
     * Determine whether the pdfStoreCategory can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Backend\PdfManagement\PdfStoreCategory  $model
     * @return mixed
     */
    public function forceDelete(User $user, PdfStoreCategory $model)
    {
        return false;
    }
}
