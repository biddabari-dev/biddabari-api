<?php

namespace App\Http\Controllers\Backend\CourseManagement\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CourseManagement\CourseCouponFormRequest;
use App\Models\Backend\Course\CourseCoupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CourseCouponController extends Controller
{
    //    permission seed done
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('manage-course-coupon'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (!empty(request()->input('course_id')))
        {
            return view('backend.course-management.course.course-coupons.index', [
                'courseCoupons'   => CourseCoupon::where('course_id', request()->input('course_id'))->get(),
            ]);
        }
        return 'Please select a course to get Course Routine';
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('create-course-coupon'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseCouponFormRequest $request)
    {
        abort_if(Gate::denies('store-course-coupon'), Response::HTTP_FORBIDDEN, '403 Forbidden');
//        $validator = $request->validate([
//            'code'  => 'required',
//            'type'  => 'required',
//            'expire_date_time'  => 'required',
//            'available_from'    => 'required',
//            'avaliable_to'  => 'required',
//        ]);
        CourseCoupon::createOrUpdateCourseCoupons($request);
        if ($request->ajax())
        {
            return response()->json('Course Coupon Created Successfully');
        }
        return back()->with('success', 'Course Coupon Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(Gate::denies('show-course-coupon'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('edit-course-coupon'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.course-management.course.course-coupons.edit', [
            'courseCoupon'   => CourseCoupon::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseCouponFormRequest $request, string $id)
    {
        abort_if(Gate::denies('update-course-coupon'), Response::HTTP_FORBIDDEN, '403 Forbidden');
//        $request->validate([
//            'code'  => 'required',
//            'type'  => 'required',
//            'expire_date_time'  => 'required',
//            'available_from'    => 'required',
//            'avaliable_to'  => 'required',
//        ]);
        CourseCoupon::createOrUpdateCourseCoupons($request, $id);
        if ($request->ajax())
        {
            return response()->json('Course Coupon Updated Successfully');
        }
        return back()->with('success', 'Course Coupon Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('delete-course-coupon'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        CourseCoupon::find($id)->delete();
        return back()->with('success', 'Course Coupon Updated Successfully');
    }
}
