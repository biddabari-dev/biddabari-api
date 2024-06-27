<?php

namespace App\Http\Controllers\Backend\AdditionalFeatureManagement\StudentOpinion;

use App\Http\Controllers\Controller;
use App\Models\Backend\AdditionalFeatureManagement\StudentOpinion\StudentOpinion;
use Illuminate\Http\Request;

class StudentOpinionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.additional-features-management.student-opinion.index', [
            'opinions'    => StudentOpinion::latest()->get(),
        ]);
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.additional-features-management.student-opinion.form');

        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        StudentOpinion::updateOrCreateStudentOpinion($request);
        return redirect()->route('student-opinions.index')->with('success', 'Student opinion Created Successfully');

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
        return view('backend.additional-features-management.student-opinion.form',[
            'opinion'    => StudentOpinion::find($id),
        ]);

        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        StudentOpinion::updateOrCreateStudentOpinion($request, $id);
        return redirect()->route('student-opinions.index')->with('success', 'Student opinion Updated Successfully');
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        StudentOpinion::deleteStudentOpinion($id);
        return back()->with('success','Student opinion deleted successfully');
    }
}
