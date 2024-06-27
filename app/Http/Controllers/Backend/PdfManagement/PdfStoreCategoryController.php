<?php

namespace App\Http\Controllers\Backend\PdfManagement;

use App\Http\Controllers\Controller;
use App\Models\Backend\PdfManagement\PdfStore;
use App\Models\Backend\PdfManagement\PdfStoreCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class PdfStoreCategoryController extends Controller
{
    //    permission seed done
    protected $pdfCategory;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('manage-pdf-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.pdf-management.pdf-store-category.index', [
            'categories'      => PdfStoreCategory::where('parent_id', 0)->orderBy('order', 'ASC')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('create-pdf-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
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
    public function store(Request $request)
    {
        abort_if(Gate::denies('store-pdf-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'title' => 'required',
            'image' => 'image'
        ]);
        PdfStoreCategory::createOrUpdatePdfCategory($request);
        if ($request->ajax())
        {
//            $request->session()->flash('success', "Course Category created successfully.");
            return response()->json('PDF Store Category created successfully.');
        } else {
            return back()->with('success', 'PDF Store ategory Created Successfully');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(Gate::denies('show-pdf-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, Request $request)
    {
        abort_if(Gate::denies('edit-pdf-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->pdfCategory = PdfStoreCategory::find($id);
        if ($request->ajax())
        {
            return response()->json($this->pdfCategory);
        }
        return 'only for ajax request';
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('update-pdf-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'title' => 'required',
            'image' => 'image'
        ]);
        PdfStoreCategory::createOrUpdatePdfCategory($request, $id);
        if ($request->ajax())
        {
            return response()->json('PDF Store Category updated successfully.');
        } else {
            return back()->with('success', 'PDF Store Category updated successfully.');
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
        abort_if(Gate::denies('delete-pdf-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->deleteNestedCategory(PdfStoreCategory::find($id));
        return back()->with('success', 'PDF Store Category deleted successfully');
    }

    protected function deleteNestedCategory ($category)
    {
        if (file_exists($category->image))
        {
            unlink($category->image);
        }

        if (!empty($category->pdfStoreCategories))
        {
            foreach ($category->pdfStoreCategories as $subCategory)
            {
                $this->deleteNestedCategory($subCategory);
            }
        }
        $category->delete();
    }

    public function getCatWisePdf ($id)
    {
        return response()->json(PdfStore::wherePdfStoreCategoryId($id)->select('id', 'title', 'file_url')->get());
    }
}
