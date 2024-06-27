<?php

namespace App\Http\Controllers\Backend\NoticeManagement;

use App\Http\Controllers\Controller;
use App\Models\Backend\NoticeManagement\NoticeCategory;
use App\Models\Backend\NoticeManagement\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class NoticeController extends Controller
{
    //    permission seed done
    protected $notice;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('manage-notice'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.notice-management.notice.index', [
            'noticeCategories'  => NoticeCategory::orderBy('name', 'asc')->where('status', 1)->get(),
            'notices'           => Notice::orderBy('id', 'desc')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('create-notice'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('store-notice'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'notice_category_id'    => 'required',
            'type'                  => 'required',
            'title'                 => 'required',
            'image'                 => 'image'
        ]);
        Notice::createOrUpdateNotice($request);
        return back()->with('success', 'Notice Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(Gate::denies('show-notice'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.notice-management.notice.show', [
            'noticeCategories'  => NoticeCategory::orderBy('name', 'asc')->where('status', 1)->get(),
            'notice'            => Notice::find($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('edit-notice'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.notice-management.notice.edit', [
            'noticeCategories'  => NoticeCategory::orderBy('name', 'asc')->where('status', 1)->get(),
            'notice'            => Notice::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('update-notice'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'notice_category_id'    => 'required',
            'type'                  => 'required',
            'title'                 => 'required',
            'image'                 => 'image'
        ]);
        Notice::createOrUpdateNotice($request, $id);
        return back()->with('success', 'Notice Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('delete-notice'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->notice = Notice::find($id);
        if (file_exists($this->notice->image))
        {
            unlink($this->notice->image);
        }
        $this->notice->delete();
        return back()->with('success', 'Notice Deleted Successfully');
    }
}
