<?php

namespace App\Http\Controllers\Backend\CourseManagement\Course;

use App\helper\ViewHelper;
use App\Http\Controllers\Controller;
use App\Models\Backend\Course\Course;
use App\Models\Backend\Course\CourseSection;
use App\Models\Backend\PdfManagement\PdfStoreCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CourseSectionController extends Controller
{
    //    permission seed done
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('manage-course-section'), Response::HTTP_FORBIDDEN, '403 Forbidden');
//        return view('backend.course-management.course.course-sections.index', [
        return view('backend.course-management.course.course-sections.nested.index', [
            'courseSections'   => CourseSection::whereCourseId(\request()->input('course_id'))->select('id', 'course_id', 'title')->with('courseSectionContentsManagePage')->orderBy('order', 'ASC')->get(),
            'pdfStoreCategories'   => PdfStoreCategory::whereStatus(1)->where('parent_id', 0)->select('id', 'title')->get(),
            'course'        => Course::where('id', \request()->input('course_id'))->select('id', 'title')->first(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('create-course-section'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('store-course-section'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate(['title' => 'required', 'available_at' => 'required',]);
        CourseSection::createOrUpdateCourseSection($request);
        return back()->with('success', 'Course Section Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(Gate::denies('show-course-section'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('edit-course-section'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return response()->json(CourseSection::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('update-course-section'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate(['title' => 'required', 'available_at' => 'required',]);
        CourseSection::createOrUpdateCourseSection($request, $id);
        return back()->with('success', 'Course Section Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('delete-course-section'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $courseSection = CourseSection::find($id);
//        $courseId = $courseSection->course_id;
        $courseSection->delete();
//        ViewHelper::reorderSerials('course_section', $courseId);
        return back()->with('success', 'Course Section deleted Successfully.');
    }

}
