<?php

namespace App\Http\Controllers\Backend\ModelTestManagement;

use App\Http\Controllers\Controller;
use App\Models\Backend\ModelTestManagement\ModelTest;
use App\Models\Backend\ModelTestManagement\ModelTestCategory;
use Illuminate\Http\Request;

class ModelTestController extends Controller
{
    protected $modelTest;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.model-test-management.model-test.index',[
            'modelTestCategories'   => ModelTestCategory::orderBy('name', 'asc')->where('status', 1)->get(),
            'modelTests'            => ModelTest::orderBy('id', 'desc')->get(),
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
        ModelTest::createOrUpdateModelTest($request);
        return back()->with('success', 'Model Test Created Successfully.');
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
        return view('backend.model-test-management.model-test.edit',[
            'modelTestCategories'   => ModelTestCategory::orderBy('name', 'asc')->where('status', 1)->get(),
            'modelTest'            => ModelTest::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        ModelTest::createOrUpdateModelTest($request, $id);
        return back()->with('success', 'Model Test Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->modelTest = ModelTest::find($id);
        if (file_exists($this->modelTest->image))
        {
            unlink($this->modelTest->image);
        }
        $this->modelTest->delete();
        return back()->with('success', 'Model Test Deleted Successfully.');
    }
}
