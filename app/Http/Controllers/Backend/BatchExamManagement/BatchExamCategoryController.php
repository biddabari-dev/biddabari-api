<?php

namespace App\Http\Controllers\Backend\BatchExamManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\BatchExam\BatchExamCategoryFormRequest;
use App\Models\Backend\BatchExamManagement\BatchExamCategory;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class BatchExamCategoryController extends Controller
{
    //    permission seed done
    public $batchExamCategory;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('manage-batch-exam-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.batch-exam-management.batch-exam-category.index', [
            'categories'      => BatchExamCategory::where('parent_id', 0)->orderBy('order', 'ASC')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('create-batch-exam-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
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
                $category = BatchExamCategory::find($v['category_id']);
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
            return redirect(route('batch-exam-categories.index'));
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
    public function store(BatchExamCategoryFormRequest $request)
    {
        abort_if(Gate::denies('store-batch-exam-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        BatchExamCategory::createOrUpdateCourseCategory($request);
        if ($request->ajax())
        {
//            $request->session()->flash('success', "Course Category created successfully.");
            return response()->json('Batch Exam Category created successfully.');
        } else {
            return back()->with('success', 'Batch Exam Category Created Successfully');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(Gate::denies('show-batch-exam-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, Request $request)
    {
        abort_if(Gate::denies('edit-batch-exam-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->batchExamCategory = BatchExamCategory::find($id);
        if ($request->ajax())
        {
            return response()->json($this->batchExamCategory);
        }
        return 'only for ajax request';
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BatchExamCategoryFormRequest $request, string $id)
    {
        abort_if(Gate::denies('update-batch-exam-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        BatchExamCategory::createOrUpdateCourseCategory($request, $id);
        if ($request->ajax())
        {
            return response()->json('Batch Exam Category updated successfully.');
        } else {
            return back()->with('success', 'Batch Exam Category updated successfully.');
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
        abort_if(Gate::denies('delete-batch-exam-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->deleteNestedCategory(BatchExamCategory::find($id));
        return back()->with('success', 'Batch Exam Category deleted successfully');
    }

    protected function deleteNestedCategory ($category)
    {
        if (file_exists($category->image))
        {
            unlink($category->image);
        }
        if (!empty($category->batchExamCategories))
        {
            foreach ($category->batchExamCategories as $subCategory)
            {
                $this->deleteNestedCategory($subCategory);
            }
        }
        $category->delete();
    }
}
