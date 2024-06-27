<?php

namespace App\Http\Controllers\Backend\JobCircularManagement;

use App\Http\Controllers\Controller;
use App\Models\Backend\CircularManagement\Circular;
use App\Models\Backend\CircularManagement\CircularCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class JobCircularController extends Controller
{
    //    permission seed done
    protected $circular;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('manage-job-circular'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.circular-management.circulars.index', [
            'circularCategories'    => CircularCategory::whereStatus(1)->where('parent_id', 0)->get(),
            'circulars'             => Circular::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('create-job-circular'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('store-job-circular'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        Circular::saveOrUpdateCircular($request);
        return back()->with('success', 'Circular Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(Gate::denies('show-job-circular'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.circular-management.circulars.show', [
            'circularCategories'    => CircularCategory::whereStatus(1)->get(),
            'circular'             => Circular::find($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('edit-job-circular'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.circular-management.circulars.edit', [
            'circularCategories'    => CircularCategory::whereStatus(1)->where('parent_id', 0)->get(),
            'circular'             => Circular::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('update-job-circular'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        Circular::saveOrUpdateCircular($request, $id);
        return back()->with('success', 'Circular Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('delete-job-circular'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->circular = Circular::find($id);
        if (file_exists($this->circular->image))
        {
            unlink($this->circular->image);
        }
        $this->circular->delete();
        return back()->with('success', 'Circular Deleted Successfully.');
    }
}
