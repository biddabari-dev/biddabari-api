<?php

namespace App\Http\Controllers\Backend\AdditionalFeatureManagement\SiteSettings;

use App\Http\Controllers\Controller;
use App\Models\Backend\AdditionalFeatureManagement\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.additional-features-management.site-settings.index', [
            'siteSettings'    => SiteSetting::first(),
        ]);
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
        SiteSetting::saveOrUpdateSiteSetting($request);
        return back()->with('success', 'Site Settings Created Successfully.');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        SiteSetting::saveOrUpdateSiteSetting($request, $id);
        return back()->with('success', 'Site Settings Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
