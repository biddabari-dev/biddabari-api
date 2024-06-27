<?php

namespace App\Http\Controllers\Backend\ProductManagement;

use App\Http\Controllers\Controller;
use App\Models\Backend\ProductManagement\ProductAuthor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class ProductAuthorsController extends Controller
{
    //    permission seed done
    /**
     * Display a listing of the resource.
     */
    protected $productAuthor;
    public function index()
    {
        abort_if(Gate::denies('manage-product-authors'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.product-management.product-authors.index', [
            'productAuthors'    => ProductAuthor::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('create-product-authors'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('store-product-authors'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'name'  => 'required',
            'image' => 'image',
        ]);
        ProductAuthor::saveOrUpdateProductAuthors($request);
        return back()->with('success', 'Product Authors Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(Gate::denies('show-product-authors'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('edit-product-authors'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return response()->json(ProductAuthor::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('update-product-authors'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'name'  => 'required',
            'image' => 'image',
        ]);
        ProductAuthor::saveOrUpdateProductAuthors($request, $id);
        return back()->with('success', 'Product Authors Update Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('delete-product-authors'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->productAuthor = ProductAuthor::find($id);
        if (file_exists($this->productAuthor->image))
        {
            unlink($this->productAuthor->image);
        }
        $this->productAuthor->delete();
        return back()->with('success', 'product Author Deleted Successfully.');
    }
}
