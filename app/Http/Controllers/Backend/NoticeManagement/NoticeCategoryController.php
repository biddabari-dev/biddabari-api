<?php

namespace App\Http\Controllers\Backend\NoticeManagement;

use App\Http\Controllers\Controller;
use App\Models\Backend\NoticeManagement\NoticeCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class NoticeCategoryController extends Controller
{
    //    permission seed done
    protected $noticeCategory, $noticeSubCategories;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('manage-notice-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.notice-management.notice-category.index', ['noticeCategories' => NoticeCategory::orderBy('name', 'asc')->whereNoticeCategoryId(0)->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('create-notice-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('store-notice-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'name' => 'required',
            'image' => 'image'
        ]);
        NoticeCategory::createOrUpdateNoticeCategory($request);
        return back()->with('success', 'Notice Category Created Successfully.');
    }

    public function addSubCategory($id)
    {
        return view('backend.notice-management.notice-category.child-category', ['noticeCategory' => NoticeCategory::find($id)]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(Gate::denies('show-notice-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('edit-notice-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.notice-management.notice-category.edit', ['noticeCategory' => NoticeCategory::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('update-notice-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'name' => 'required',
            'image' => 'image'
        ]);
        NoticeCategory::createOrUpdateNoticeCategory($request, $id);
        return back()->with('success', 'Notice Category Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('delete-notice-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->noticeCategory       = NoticeCategory::find($id)->delete();
        return back()->with('success', 'Notice Category Deleted Successfully.');
    }
}
