<?php

namespace App\Http\Controllers\Backend\ProductManagement;

use App\Http\Controllers\Controller;
use App\Models\Backend\ProductManagement\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class ProductCategoryController extends Controller
{
    //    permission seed done
    /**
     * Display a listing of the resource.
     */
    protected $productCategory;
    public function index()
    {
        abort_if(Gate::denies('manage-product-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.product-management.product-category.index', [
            'productCategories'    => ProductCategory::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('create-product-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('store-product-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
//        return $request;
        $request->validate([
            'name'  => 'required',
            'image' => 'image',
        ]);
        ProductCategory::saveOrUpdateProductCategory($request);
        return back()->with('success', 'Product Category Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(Gate::denies('show-product-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('edit-product-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return response()->json(ProductCategory::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('update-product-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'name'  => 'required',
            'image' => 'image',
        ]);
        ProductCategory::saveOrUpdateProductCategory($request, $id);
        return back()->with('success', 'Product Category Update Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('delete-product-category'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->productCategory = ProductCategory::find($id);
        if (file_exists($this->productCategory->image))
        {
            unlink($this->productCategory->image);
        }
        $this->productCategory->delete();
        return back()->with('success', 'product Category Deleted Successfully.');
    }
}
