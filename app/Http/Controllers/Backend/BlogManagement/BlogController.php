<?php

namespace App\Http\Controllers\Backend\BlogManagement;

use App\Http\Controllers\Controller;
use App\Models\Backend\BlogManagement\Blog;
use App\Models\Backend\BlogManagement\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends Controller
{
    //    permission seed done
    protected $blog;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('manage-blog'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.blog-management.blogs.index', [
            'blogCategories'    => BlogCategory::whereStatus(1)->get(),
            'blogs'             => Blog::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('create-blog'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('store-blog'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'blog_category_id' => 'required',
            'title' => 'required',
            'image' => 'image',
            'body'  => 'required',
        ]);
        Blog::saveOrUpdateBlog($request);
        return back()->with('success', 'Blog Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(Gate::denies('show-blog'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.blog-management.blogs.show', [
            'blogCategories'    => BlogCategory::whereStatus(1)->get(),
            'blog'             => Blog::find($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('edit-blog'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.blog-management.blogs.edit', [
            'blogCategories'    => BlogCategory::whereStatus(1)->get(),
            'blog'             => Blog::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('update-blog'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'blog_category_id' => 'required',
            'title' => 'required',
            'image' => 'image',
            'body'  => 'required',
        ]);
        Blog::saveOrUpdateBlog($request, $id);
        return back()->with('success', 'Blog Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('delete-blog'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->blog = Blog::find($id);
        if (file_exists($this->blog->image))
        {
            unlink($this->blog->image);
        }
        $this->blog->delete();
        return back()->with('success', 'Blog Deleted Successfully.');
    }
}
