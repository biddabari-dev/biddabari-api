<?php

namespace App\Http\Controllers\Backend\AdditionalFeatureManagement\OurServices;

use App\Http\Controllers\Controller;
use App\Models\Backend\AdditionalFeatureManagement\OurService\OurService;
use Illuminate\Http\Request;

class OurServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.additional-features-management.our-services.index', [
            'services'    => OurService::latest()->get(),
        ]);
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.additional-features-management.our-services.form');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        OurService::updateOrCreateService($request);
        return redirect()->route('our-services.index')->with('success', 'Service Created Successfully');
        //
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
        return view('backend.additional-features-management.our-services.form',[
            'service'    => OurService::find($id),
        ]);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        OurService::updateOrCreateService($request, $id);
        return redirect()->route('our-services.index')->with('success', 'Service Updated Successfully');
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       OurService::deleteService($id);
        return back()->with('success','Service deleted successfully');
        //
    }
}
