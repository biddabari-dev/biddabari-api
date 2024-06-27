<?php

namespace App\Http\Controllers\Backend\RolePermissionManagement\Permission;

use App\Http\Controllers\Controller;
use App\Models\Backend\RoleManagement\Permission;
use App\Models\Backend\RoleManagement\PermissionCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class PermissionController extends Controller
{
    //    permission seed done
    private $permissionRoles, $permission, $permissions;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('manage-permission'), Response::HTTP_FORBIDDEN, '403 Forbidden');
//        return Permission::all();
        return view('backend.role-management.permissions.index', [
            'permissions'   => Permission::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('create-permission'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.role-management.permissions.create', [
            'permissionCategories'    => PermissionCategory::where('status', 1)->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('store-permission'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        Permission::updateOrCreatePermission($request);
        return back()->with('success', 'Permission created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(Gate::denies('show-permission'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('edit-permission'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.role-management.permissions.create', [
            'permissionCategories'    => PermissionCategory::where('status', 1)->get(),
            'permission'              => Permission::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('update-permission'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $permission = Permission::find($id);
        if ($permission->is_default == 1)
        {
            return back()->with('error', 'You can\'t delete a default permission.');
        }
        Permission::updateOrCreatePermission($request, $id);
        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('delete-permission'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->permission = Permission::find($id);
//        if (!empty($this->permission->roles))
//        {
//            echo 'has permission';
//        }
        if ($this->permission->is_default == 1)
        {
            return back()->with('customError', 'Default Role can not be deleted. Please contact your developer for help');
        }
        $this->permission->delete();
        return back()->with('success', 'Permission deleted successfully.');
    }
}
