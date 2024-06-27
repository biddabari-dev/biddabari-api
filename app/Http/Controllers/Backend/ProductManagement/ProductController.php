<?php

namespace App\Http\Controllers\Backend\ProductManagement;

use App\Http\Controllers\Controller;
use App\Models\Backend\ProductManagement\Product;
use App\Models\Backend\ProductManagement\ProductAuthor;
use App\Models\Backend\ProductManagement\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public $product;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('manage-product'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.product-management.product.index', [
            'products'    => Product::all(),
            'productCategories'  => ProductCategory::whereStatus(1)->get(),
            'productAuthors'  => ProductAuthor::whereStatus(1)->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('create-product'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('store-product'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'product_category_id' => 'required',
            'product_author_id' => 'required',
            'title' => 'required',
            'image' => 'nullable|image',
            'featured_pdf'  => 'nullable|mimes:pdf',
            'price' => 'required',
            'stock_amount'  => 'required',
        ]);
        try {
            $this->product = Product::saveOrUpdateProduct($request);
            $this->product->productCategories()->sync($request->product_category_id);
            return back()->with('success', 'Product Created Successfully.');
        } catch (\Exception $exception)
        {
            return back()->with('error', $exception->getMessage());
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(Gate::denies('show-product'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('edit-product'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return response()->json(Product::whereId($id)->with('productCategories:id,name,status')->first());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('update-product'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'product_category_id' => 'required',
            'product_author_id' => 'required',
            'title' => 'required',
            'image' => 'nullable|image',
            'featured_pdf'  => 'nullable|mimes:pdf',
            'price' => 'required',
            'stock_amount'  => 'required',
        ]);
        try {
            $this->product = Product::saveOrUpdateProduct($request,$id);
            $this->product->productCategories()->sync($request->product_category_id);
            return back()->with('success', 'Product Update Successfully.');
        } catch (\Exception $exception)
        {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('delete-product'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->product = Product::find($id);
        if (file_exists($this->product->image))
        {
            unlink($this->product->image);
        }
        if (file_exists($this->product->featured_pdf))
        {
            unlink($this->product->featured_pdf);
        }
        $this->product->delete();
        return back()->with('success', 'product Deleted Successfully.');
    }
}
