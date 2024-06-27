<?php

namespace App\Http\Controllers\Backend\AdditionalFeatureManagement\NumberCounter;

use App\Http\Controllers\Controller;
use App\Models\Backend\AdditionalFeatureManagement\NumberCounter\NumberCounter;
use Illuminate\Http\Request;

class NumberCounterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.additional-features-management.number-counter.index',[
            'numberCounters' => NumberCounter::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.additional-features-management.number-counter.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'label' => 'required',
            'total_number' => 'required',
            'image' => 'image',
        ]);
        NumberCounter::updateOrCreateNumberCounter($request);
        return redirect()->route('number-counters.index')->with('success', 'Number Counter Created Successfully');
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
        return view('backend.additional-features-management.number-counter.form',[
            'numberCounter' => NumberCounter::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'label' => 'required',
            'total_number' => 'required',
            'image' => 'image',
        ]);
        NumberCounter::updateOrCreateNumberCounter($request, $id);
        return redirect()->route('number-counters.index')->with('success', 'Number Counter Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        NumberCounter::deleteNumberCounter($id);
        return back()->with('success', 'Number Counter Deleted Successfully');
    }
}
