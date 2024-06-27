<?php

namespace App\Http\Controllers\Backend\Service;

use App\Http\Controllers\Controller;
use App\Models\Backend\OrderManagement\ParentOrder;
use App\Models\Backend\UserManagement\Student;
use App\Models\ServiceComplain;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('admin-service-complain'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('backend.service.index',[
            'services' => ServiceComplain::latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function admin_status_update(Request $request, string $id)
    {
        abort_if(Gate::denies('admin-status-update'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $admin_status=ServiceComplain::find($id);
        $admin_status->admin_status=$request->admin_status;
        $admin_status->status=$request->status;
        $admin_status->save();
        return redirect()->back()->with('success','Service Admin Status Updated Successfully');
    }
    public function status_update(Request $request, string $id)
    {
        abort_if(Gate::denies('service-status-update'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $admin_status=ServiceComplain::find($id);
//        $admin_status->admin_status=$request->admin_status;
        $admin_status->status=$request->status;
        $admin_status->save();
        return redirect()->back()->with('success','Service Status Updated Successfully');
    }

    public function adminServiceedit(string $id)
    {
        abort_if(Gate::denies('admin-service-status-edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data=ServiceComplain::find($id);
        return response()->json($data);
    }

    public function servicestatus(string $id)
    {
        abort_if(Gate::denies('service-status-edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data=ServiceComplain::find($id);
        return response()->json($data);
    }

    public function myService(Request $request)
    {
        abort_if(Gate::denies('service-complain'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $orders=[];
        $services=[];
        if (isset($request->search)){
            $user=User::where('mobile',$request->search)->first();
            if (isset($user)){
                $orders=ParentOrder::where('user_id',$user->id)->latest()->get();
                $services=ServiceComplain::where('student_user_id',$user->id)->latest()->get();
            }else{
                return redirect()->back()->with('error','user not found');
            }

            return view('backend.service.service',[
                'user'=>$user,
                'orders'=>$orders,
                'services'=>$services,
            ]);
        }else{
            return view('backend.service.service',[
//                'user'=>$user,
                'orders'=>$orders,
                'services'=>$services,
            ]);
        }


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('service-complain'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        ServiceComplain::createorupdateservicecomplain($request);
        return redirect()->back()->with('success','Service Complain added successfully');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('delete-service-complain'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $service=ServiceComplain::find($id);
        $service->delete();
        return redirect()->back()->with('success','Service Complain deleted successfully');
    }
}
