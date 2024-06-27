<?php

namespace App\Http\Controllers\Backend\RolePermissionManagement\Permission;

use App\Http\Controllers\Controller;
use App\Models\Backend\RoleManagement\PermissionCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class PermissionCategoryController extends Controller
{
//    permission seed done
    protected $permissionCategory;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('manage-permission-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.role-management.permission-category.index', ['permissionCategories' => PermissionCategory::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('create-permission-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.role-management.permission-category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('store-permission-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        PermissionCategory::createOrUpdatePermissionCategory($request);
        return back()->with('success', 'Permission Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(Gate::denies('show-permission-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('edit-permission-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.role-management.permission-category.create', [
            'permissionCategory'    => PermissionCategory::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('update-permission-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        PermissionCategory::createOrUpdatePermissionCategory($request, $id);
        return redirect()->route('permission-categories.index')->with('success', 'Permission Category created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('delete-permission-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->permissionCategory = PermissionCategory::find($id);
        if ($this->permissionCategory->is_default == 0)
        {
            $this->permissionCategory->delete();
            return back()->with('success', 'Permission Category deleted successfully.');
        } else {
            return back()->with('error', 'You can\'t delete a default Permission Category. Please contact your developer for help.');
        }
    }
}
