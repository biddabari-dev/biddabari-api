<?php

namespace App\Http\Controllers\Backend\CourseManagement\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CourseManagement\CourseCategoryFormRequest;
use App\Http\Requests\Backend\CourseManagement\CourseCreateFormRequest;
use App\Models\Backend\Course\CourseCategory;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CourseCategoryController extends Controller
{
    //    permission seed done
    public $courseCategory;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('manage-course-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.course-management.course.course-category.index', [
            'categories'      => CourseCategory::where('parent_id', 0)->orderBy('order', 'ASC')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('create-course-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    public function saveNestedCategories (Request $request)
    {
        $json = $request->nested_category_array;
        $decoded_json = json_decode($json, TRUE);

        $simplified_list = [];
         $this->recur1($decoded_json, $simplified_list);

        DB::beginTransaction();
        try {
            $info = [
                "success" => FALSE,
            ];

            foreach($simplified_list as $k => $v){
                $category = CourseCategory::find($v['category_id']);
                $category->fill([
                    "parent_id" => $v['parent_id'],
                    "order" => $v['sort_order'],
                ]);

                $category->save();
            }

            DB::commit();
            $info['success'] = TRUE;
        } catch (\Exception $e) {
            DB::rollback();
            $info['success'] = FALSE;
        }

        if($info['success']){
            $request->session()->flash('success', "All Categories updated.");
        }else{
            $request->session()->flash('error', "Something went wrong while updating...");
        }
        if ($request->ajax())
        {
            return response()->json('Order Updated');
        } else {
            return redirect(route('course-categories.index'));
        }
    }

    public function recur1($nested_array=[], &$simplified_list=[]){

        static $counter = 0;

        foreach($nested_array as $k => $v){

            $sort_order = $k+1;
            $simplified_list[] = [
                "category_id" => $v['id'],
                "parent_id" => 0,
                "sort_order" => $sort_order
            ];

            if(!empty($v["children"])){
                $counter+=1;
                $this->recur2($v['children'], $simplified_list, $v['id']);
            }

        }
    }

    public function recur2($sub_nested_array=[], &$simplified_list=[], $parent_id = NULL){

        static $counter = 0;

        foreach($sub_nested_array as $k => $v){

            $sort_order = $k+1;
            $simplified_list[] = [
                "category_id" => $v['id'],
                "parent_id" => $parent_id,
                "sort_order" => $sort_order
            ];

            if(!empty($v["children"])){
                $counter+=1;
                return $this->recur2($v['children'], $simplified_list, $v['id']);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseCategoryFormRequest $request)
    {
        abort_if(Gate::denies('store-course-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        CourseCategory::createOrUpdateCourseCategory($request);
        if ($request->ajax())
        {
//            $request->session()->flash('success', "Course Category created successfully.");
            return response()->json('Course Category created successfully.');
        } else {
            return back()->with('success', 'Course Category Created Successfully');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(Gate::denies('show-course-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, Request $request)
    {
        abort_if(Gate::denies('edit-course-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->courseCategory = CourseCategory::find($id);
        if ($request->ajax())
        {
            return response()->json($this->courseCategory);
        }
        return 'only for ajax request';
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseCategoryFormRequest $request, string $id)
    {
        abort_if(Gate::denies('update-course-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        CourseCategory::createOrUpdateCourseCategory($request, $id);
        if ($request->ajax())
        {
            return response()->json('Course Category updated successfully.');
        } else {
            return back()->with('success', 'Course Category updated successfully.');
        }
    }
    public function test (Request $request)
    {
        return response()->json($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('delete-course-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->deleteNestedCategory(CourseCategory::find($id));
        return back()->with('success', 'Course Category deleted successfully');
    }

    protected function deleteNestedCategory ($category)
    {
        if (file_exists($category->image))
        {
            unlink($category->image);
        }
        if (file_exists($category->icon))
        {
            unlink($category->icon);
        }
        if (!empty($category->courseCategories))
        {
            foreach ($category->courseCategories as $subCategory)
            {
                $this->deleteNestedCategory($subCategory);
            }
        }
        $category->delete();
    }
}
