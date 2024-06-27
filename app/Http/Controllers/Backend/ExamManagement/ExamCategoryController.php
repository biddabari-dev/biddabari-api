<?php

namespace App\Http\Controllers\Backend\ExamManagement;

use App\Http\Controllers\Controller;
use App\Models\Backend\ExamManagement\ExamCategory;
use App\Models\Backend\QuestionManagement\QuestionTopic;
use Illuminate\Http\Request;
use DB;

class ExamCategoryController extends Controller
{
    public $examCategory,$examCategories = [];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (isset($_GET['q-c-id']))
        {
            $this->examCategories = ExamCategory::whereExamCategoryId($_GET['q-c-id'])->latest()->get();
        } else {
            $this->examCategories = ExamCategory::where('exam_category_id', 0)->latest()->orderBy('order', 'ASC')->get();
        }
        return view('backend.exam-management.exam-category.index', [
            'questionTopics'    => QuestionTopic::whereStatus(1)->get(),
            'categories'      => $this->examCategories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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
                $category = ExamCategory::find($v['category_id']);
                $category->fill([
                    "exam_category_id" => $v['parent_id'],
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
            return redirect(route('exam-categories.index'));
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
    public function store(Request $request)
    {
        ExamCategory::createOrUpdateExamCategory($request);
        if ($request->ajax())
        {
            return response()->json('Exam Category created successfully.');
        } else {
            return back()->with('success', 'Exam Category Created Successfully');
        }
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
    public function edit(string $id, Request $request)
    {
        $this->examCategory = ExamCategory::find($id);
        if ($request->ajax())
        {
            return response()->json($this->examCategory);
        }
        return 'only for ajax request';
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        ExamCategory::createOrUpdateExamCategory($request, $id);
        if ($request->ajax())
        {
            return response()->json('Exam Category updated successfully.');
        } else {
            return back()->with('success', 'Exam Category updated successfully.');
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
        $this->deleteNestedCategory(ExamCategory::find($id));
        return back()->with('success', 'Exam Category deleted successfully');
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
        if (!empty($category->examCategories))
        {
            foreach ($category->examCategories as $subCategory)
            {
                $this->deleteNestedCategory($subCategory);
            }
        }
        $category->delete();
    }
}
