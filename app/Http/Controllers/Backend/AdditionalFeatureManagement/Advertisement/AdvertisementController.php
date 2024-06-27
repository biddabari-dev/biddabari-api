<?php

namespace App\Http\Controllers\Backend\AdditionalFeatureManagement\Advertisement;

use App\Http\Controllers\Controller;
use App\Models\Backend\AdditionalFeatureManagement\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class AdvertisementController extends Controller
{
    //    permission seed done
    protected $advertisement;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('manage-advertisement'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.additional-features-management.advertisement.index', ['advertisements' => Advertisement::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('create-advertisement'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('store-advertisement'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'title' => 'required',
            'content_type'  => 'required',
            'link'  => 'required',
            'image' => 'image',
        ]);
        Advertisement::createOrUpdateAdvertisement($request);
        if ($request->ajax())
        {
            return response()->json('Advertisement Created Successfully.');
        }else{
            return back()->with('success', 'Advertisement Created Successfully.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(Gate::denies('show-advertisement'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('edit-advertisement'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.additional-features-management.advertisement.edit', ['advertisement' => Advertisement::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('update-advertisement'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'title' => 'required',
            'content_type'  => 'required',
            'link'  => 'required',
            'image' => 'image',
        ]);
        Advertisement::createOrUpdateAdvertisement($request, $id);
        return back()->with('success', 'Advertisement Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('delete-advertisement'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->advertisement = Advertisement::find($id);
        if (file_exists($this->advertisement->image))
        {
            unlink($this->advertisement->image);
        }
        $this->advertisement->delete();
        return back()->with('success', 'Advertisement Deleted Successfully.');
    }
}
