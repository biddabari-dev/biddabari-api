<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Course\Course;
use App\Models\Backend\OrderManagement\ParentOrder;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $totalamount=0;
//        return $request;
             if (!empty($request->course_id))
             {
//                 return 'sarowar';
//            $this->courseOrders = CourseOrder::whereCourseId($request->course_id)->get();
                 $this->courseOrders = ParentOrder::where('ordered_for', 'course')->whereParentModelId($request->course_id)->get();
                 $totalamount=$this->courseOrders->sum('total_amount');
                 $totalpaidamount=$this->courseOrders->sum('paid_amount');
//            $this->courseOrders = ParentOrder::where('status', 'approved')->whereParentModelId($request->course_id)->latest()->paginate(20);
//            return $this->courseOrders;
             } else {
//            $this->courseOrders = CourseOrder::latest()->take(30)->get();
                 $this->courseOrders = ParentOrder::where('ordered_for', 'course')->latest()->paginate(1000);
//                 $this->courseOrders = 'sakib';
//            $this->courseOrders = ParentOrder::where('status','approved')->latest()->paginate(20);
//            dd($this->courseOrders) ;
             }
//        $this->courseOrders=$this->courseOrders->where('status','pending')->get();
//        return $this->courseOrders;
        return view('backend.account_info.index', [
//            'courses'   => Course::whereStatus(1)->get(),
//            'courseCategories'   => CourseCategory::whereStatus(1)->whereParentId(0)->get(),
            'courseOrders'  => !empty($this->courseOrders) ? $this->courseOrders : '',
            'courses'       => Course::where(['status' => 1])->latest()->get(),
            'totalamount'   => $totalamount,
            'totalpaidamount'   => $totalpaidamount,

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
        //
    }
}
