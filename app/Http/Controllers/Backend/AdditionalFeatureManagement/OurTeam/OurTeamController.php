<?php

namespace App\Http\Controllers\Backend\AdditionalFeatureManagement\OurTeam;

use App\Http\Controllers\Controller;
use App\Models\Backend\AdditionalFeatureManagement\OurTeam\OurTeam;
use Illuminate\Http\Request;

class OurTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.additional-features-management.our-team.index',[
            'ourTeams' => OurTeam::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.additional-features-management.our-team.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'  => 'required',
            'designation'   => 'required',
            'image' => 'image',
            'content_show_type' => 'required',
        ]);
        OurTeam::updateOrCreateOurTeam($request);
        return redirect()->route('our-teams.index')->with('success', 'Our Team Created Successfully');
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
        return view('backend.additional-features-management.our-team.form',[
            'ourTeam' => OurTeam::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name'  => 'required',
            'designation'   => 'required',
//            'image' => 'image',
            'content_show_type' => 'required',
        ]);
        OurTeam::updateOrCreateOurTeam($request, $id);
        return redirect()->route('our-teams.index')->with('success', 'Our Team Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        OurTeam::deleteOurTeam($id);
        return back()->with('success', 'Our Team Deleted Successfully');
    }
}
