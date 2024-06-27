<?php

namespace App\Http\Controllers\Backend\CourseManagement\Course;

use App\Http\Controllers\Controller;
use App\Models\Backend\Course\Course;
use App\Models\Backend\Course\CourseRoutine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CourseRoutineController extends Controller
{
    //    permission seed done
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('manage-course-routine'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (!empty(request()->input('course_id')))
        {
            return view('backend.course-management.course.course-routines.index', [
                'courseRoutines'   => CourseRoutine::where('course_id', request()->input('course_id'))->get(),
            ]);
        }
        return 'Please select a course to get Course Routine';
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('create-course-routine'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('store-course-routine'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate(['date_time' => 'required','day' => 'required']);
        CourseRoutine::createOrUpdateCourseRoutines($request);
        return back()->with('success', 'Course Routine Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(Gate::denies('show-course-routine'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('edit-course-routine'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.course-management.course.course-routines.edit', [
            'courseRoutine'   => CourseRoutine::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('update-course-routine'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        CourseRoutine::createOrUpdateCourseRoutines($request, $id);
        return back()->with('success', 'Course Routine Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('delete-course-routine'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        CourseRoutine::find($id)->delete();
        return back()->with('success', 'Course Routine deleted Successfully');
    }
}
