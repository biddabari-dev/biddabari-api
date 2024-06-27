<?php

namespace App\Http\Controllers\Backend\UserManagement\RegularUser;

use  App\DataTables\UserDataTables\Users;
use App\helper\ViewHelper;
use App\Http\Controllers\Controller;
use App\Models\Backend\RoleManagement\Role;
use App\Models\Backend\UserManagement\Student;
use App\Models\Backend\UserManagement\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    protected $user, $users = [];
    /**
     * Display a listing of the resource.
     */
    public function index(Users $dateTable,Request $request)
    {
        abort_if(Gate::denies('manage-user'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return $dateTable->render('backend.role-management.user.index');

        if (isset($request->user_type))
        {
            $this->users    = User::paginate(100);
        } else {
            $this->users = User::latest()->select('id', 'mobile', 'name', 'status', 'profile_photo_path')->paginate(100);
        }

        return view('backend.role-management.user.index',[
            'users'   => $this->users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('create-user'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.role-management.user.create',[
            'roles'   => Role::whereStatus(1)->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'mobile' => 'required|unique:users',
        ]);

        abort_if(Gate::denies('store-user'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->user = User::createOrUpdateUser($request);
        foreach ($request->roles as $role)
        {
            if ($role == '3')
            {
//                teacher
                Teacher::createOrUpdateTeacher($request, $this->user);
            } elseif ($role == '4')
            {
//                student
                Student::createOrUpdateStudent($request, $this->user);
            }
        }
        return back()->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(Gate::denies('show-user'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('edit-user'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.role-management.user.create',[
            'roles'   => Role::whereStatus(1)->get(),
            'user'      => User::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('update-user'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->user = User::createOrUpdateUser($request, $id);

        foreach ($this->user->roles as $role)
        {
            if ($role->id == 3)
            {
//                teacher
                Teacher::createOrUpdateTeacher($request, $this->user, $request->teacher_id);
            } elseif ($role->id == 4)
            {
//                student
                Student::createOrUpdateStudent($request, $this->user, $request->student_id);
            }
        }
        if (empty($request->user_try_update) && $request->user_try_update != 1)
        {
            return redirect()->route('users.index')->with('success', 'User updated successfully.');
        } else {
            return back()->with('success', 'User updated successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
//        abort_if(Gate::denies('delete-user'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($id != 1)
        {
            User::find($id)->delete();
            return ViewHelper::returnSuccessMessage('User deleted successfully.');
//            return back()->with('success', 'User deleted successfully.');
        } else {
            return ViewHelper::returEexceptionError('Please Contact your developer for deleting default user');
//            return back()->with('error', 'Please Contact your developer for deleting default user');
        }
    }

    public function viewProfile()
    {
        abort_if(Gate::denies('view-user-profile'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $user = User::find(auth()->id());
        $userDetails = '';
        $userType = '';
        foreach ($user->roles as $role)
        {
            if ($role->id == 3)
            {
                $userDetails = Teacher::where('user_id', $user->id)->first();
                $userType = 'teacher';
                break;
            } elseif ($role->id == 4)
            {
                $userDetails = Student::where('user_id', $user->id)->first();
                $userType = 'student';
                break;
            }
        }
        return view('backend.role-management.user.profile',[
            'user'  => $user,
            'userDetails'  => $userDetails,
            'userType'  => $userType,
        ]);
    }

    public function studentChangePassword(Request $request, $id)
    {
        abort_if(Gate::denies('admin-form-user-change-password'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->user = User::find($id);
        if (password_verify($request->old_password, $this->user->password))
        {
            if ($request->new_password == $request->confirm_password)
            {
                $this->user->update(['password' => Hash::make($request->new_password)]);
                return back()->with('success', 'Password Changed successfully.');
            } else {
                return back()->with('error', 'Password Mismatch. Please Try again.');
            }
        } else {
            return back()->with('error', 'Invalid Password. Please Try again.');
        }
    }

    public function allUsersPage(Request $request)
    {
        abort_if(Gate::denies('all-users-page'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (isset($request->user_type) && $request->user_type == 'student')
        {
            $this->users    = Student::latest()->get();
        } elseif (isset($request->user_type) && $request->user_type == 'teacher')
        {
            $this->users    = Teacher::latest()->get();
        } else {
            $this->users    = User::latest()->get();
        }
        return view('backend.role-management.user.all-users', [
            'users' => $this->users
        ]);
    }
}
