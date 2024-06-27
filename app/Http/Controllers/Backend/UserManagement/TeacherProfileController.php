<?php

namespace App\Http\Controllers\Backend\UserManagement;

use App\Models\Backend\UserManagement\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;

class TeacherProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('teacher-profile'), Response::HTTP_FORBIDDEN, '403 Forbidden');
      return view('backend.role-management.user.teacher.teacher_profile',[
          'teachers' => Teacher::latest()->get()
      ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('teacher-profile-edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.role-management.user.teacher.teacher_edit',[
            'teacher'=>Teacher::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('teacher-profile-update'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->user = User::createOrUpdateUser($request,$request->user_id );
        Teacher::createOrUpdateTeacher($request, $this->user, $id);
        return redirect()->route('teachers_profile.index')->with('success','Teacher Profile Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
