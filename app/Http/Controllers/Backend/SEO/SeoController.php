<?php

namespace App\Http\Controllers\Backend\SEO;

use App\Http\Controllers\Controller;
use App\Models\Backend\BatchExamManagement\BatchExam;
use App\Models\Backend\BatchExamManagement\BatchExamCategory;
use App\Models\Backend\BlogManagement\Blog;
use App\Models\Backend\BlogManagement\BlogCategory;
use App\Models\Backend\Course\Course;
use App\Models\Backend\Course\CourseCategory;
use App\Models\Backend\ProductManagement\Product;
use App\Models\Backend\ProductManagement\ProductCategory;
use App\Models\Seo;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.seo.index',[
            'seos'=>Seo::all()
        ]);
    }

    public function select_seofor(string $seofor)
    {
        $data=[];
        if ($seofor == 'course'){
            $data = Course::select('id','title')->get();
        }elseif ($seofor == 'batch_exam'){
            $data = BatchExam::select('id','title')->get();
        }elseif ($seofor == 'product'){
            $data = Product::select('id','title')->get();
        }elseif ($seofor == 'blog'){
            $data = Blog::select('id','title')->get();
        }elseif ($seofor == 'course_category'){
            $data = CourseCategory::select('id','name')->get();
        }elseif ($seofor == 'blog_category'){
            $data = BlogCategory::select('id','name')->get();
        }elseif ($seofor == 'batch_exam_category'){
            $data = BatchExamCategory::select('id','name')->get();
        }elseif ($seofor == 'product_category'){
            $data = ProductCategory::select('id','name')->get();
        }
        return response()->json(['data'=>$data,'old_seofor'=>$seofor]);
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
//        return $request;
        Seo::saveOrUpdateProduct($request);
        return back()->with('success', 'SEO Created Successfully.');
        return $request;
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
        $seos=Seo::find($id);
        return view('backend.seo.edit',[
            'seo'=>Seo::find($id)
        ]);
        return response()->json(['data'=>$seos]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Seo::saveOrUpdateProduct($request,$id);
        return redirect()->route('seos.index')->with('success', 'SEO update Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $seo=Seo::find($id);
        $seo->delete();
        return back()->with('success', 'SEO delete Successfully.');
    }
}
