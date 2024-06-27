<?php

namespace App\Http\Controllers\Backend\OrderManagement;

use App\helper\ViewHelper;
use App\Http\Controllers\Controller;
use App\Models\Backend\Course\Course;
use App\Models\Backend\Course\CourseCategory;
use App\Models\Backend\OrderManagement\ParentOrder;
use App\Models\Backend\UserManagement\Student;
use App\Models\Frontend\CourseOrder\CourseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CourseOrderController extends Controller
{
    //    permission seed done
    protected $courseOrders;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('manage-course-order'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (!empty($request->course_id))
        {
//            $this->courseOrders = CourseOrder::whereCourseId($request->course_id)->get();
            $this->courseOrders = ParentOrder::where('ordered_for', 'course')->whereParentModelId($request->course_id)->get();
//            $this->courseOrders = ParentOrder::where('status', 'approved')->whereParentModelId($request->course_id)->latest()->paginate(20);
//            return $this->courseOrders;
        } else {
//            $this->courseOrders = CourseOrder::latest()->take(30)->get();
            $this->courseOrders = ParentOrder::where('ordered_for', 'course')->latest()->paginate(100);
//            $this->courseOrders = ParentOrder::where('status','approved')->latest()->paginate(20);
//            dd($this->courseOrders) ;
        }
//        $this->courseOrders=$this->courseOrders->where('status','pending')->get();
        return view('backend.order-management.course-order.index', [
//            'courses'   => Course::whereStatus(1)->get(),
//            'courseCategories'   => CourseCategory::whereStatus(1)->whereParentId(0)->get(),
            'courseOrders'  => !empty($this->courseOrders) ? $this->courseOrders : '',
            'courses'       => Course::where(['status' => 1])->latest()->get()
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
        return response()->json(ParentOrder::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('update-course-order'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            if ($request->status == 'canceled')
            {
                ParentOrder::find($id)->delete();
                return ViewHelper::returnSuccessMessage('Order deleted successfully.');
            }
            $parentOrder = ParentOrder::updateExamOrderStatus($request, $id);
            if ($request->status == 'approved')
            {
                $student = Student::whereUserId($parentOrder->user_id)->first();
                $parentOrder->course->students()->attach($student->id);
            }
            return back()->with('success', 'Order Status Updated Successfully');
        } catch (\Exception $exception)
        {
            return back()->with('error', $exception->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
//        return $id;
        abort_if(Gate::denies('delete-course-order'), Response::HTTP_FORBIDDEN, '403 Forbidden');
//        CourseOrder::find($id)->delete();
//        ParentOrder::find($id)->delete();
        $parentOrder = ParentOrder::find($id);
        ParentOrder::detachStudent('course', $parentOrder->parent_model_id, $parentOrder->user_id);
        $parentOrder->delete();
        return back()->with('success', 'Order Deleted Successfully');
    }

    public function changeContactStatus(Request $request, string $id)
    {
        abort_if(Gate::denies('change-course-order-contact-status'), Response::HTTP_FORBIDDEN, '403 Forbidden');
//        $courseOrder =CourseOrder::find($id)->update(['contact_status' => $request->contact_status, 'checked_by' => auth()->id()]);
        $courseOrder = ParentOrder::find($id)->update(['contact_status' => $request->contact_status, 'checked_by' => auth()->id()]);
        return back()->with('success', 'Order Contact Status Updated Successfully');
    }

    public function getCourseOrderDetails($id)
    {
        abort_if(Gate::denies('course-order-details'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.order-management.course-order.course-order-details', [
//            'courseOrder'   => CourseOrder::find($id),
            'courseOrder'   => ParentOrder::find($id),
        ]);
//        return response()->json(CourseOrder::find($id));
    }
}
