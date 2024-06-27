<?php

namespace App\Http\Controllers\Backend\ModelTestManagement;

use App\Http\Controllers\Controller;
use App\Models\Backend\ModelTestManagement\ModelTestCategory;
use Illuminate\Http\Request;

class ModelTestCategoryController extends Controller
{
    protected $modelTestCategory, $modelTestSubCategories;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.model-test-management.model-test-category.index', ['modelTestCategories' => ModelTestCategory::orderBy('name', 'asc')->get()]);
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
        ModelTestCategory::createOrUpdateModelTestCategory($request);
        return back()->with('success', 'Model Test Category Created Successfully.');
    }

    public function addSubCategory($id)
    {
        return view('backend.model-test-management.model-test-category.child-category', ['modelTestCategory' => ModelTestCategory::find($id)]);
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
        return view('backend.model-test-management.model-test-category.edit', ['modelTestCategory' => ModelTestCategory::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        ModelTestCategory::createOrUpdateModelTestCategory($request, $id);
        return back()->with('success', 'Model Test Category Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        ModelTestCategory::find($id)->delete();
        return back()->with('success', 'Model Test Category Deleted Successfully.');
    }
}
