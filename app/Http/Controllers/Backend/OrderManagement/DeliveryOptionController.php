<?php

namespace App\Http\Controllers\Backend\OrderManagement;

use App\Http\Controllers\Controller;
use App\Models\Backend\ProductManagement\ProductAuthor;
use App\Models\Backend\ProductManagement\ProductDeliveryOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class DeliveryOptionController extends Controller
{
    //    permission seed done
    /**
     * Display a listing of the resource.
     */
    protected $deliveryOption;
    public function index()
    {
        abort_if(Gate::denies('manage-delivery-options'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.product-management.product-delivery-options.index', [
            'deliveryOptions'    => ProductDeliveryOption::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('create-delivery-options'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('store-delivery-options'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'name'  => 'required',
            'image' => 'image',
        ]);
        ProductDeliveryOption::saveOrUpdateProductDeliveryOptions($request);
        return back()->with('success', 'Product Authors Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(Gate::denies('show-delivery-options'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('edit-delivery-options'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return response()->json(ProductDeliveryOption::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('update-delivery-options'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'name'  => 'required',
            'image' => 'image',
        ]);
        ProductDeliveryOption::saveOrUpdateProductDeliveryOptions($request, $id);
        return back()->with('success', 'Product Authors Update Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('delete-delivery-options'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->deliveryOption = ProductDeliveryOption::find($id);
        if (file_exists($this->deliveryOption->image))
        {
            unlink($this->deliveryOption->image);
        }
        $this->deliveryOption->delete();
        return back()->with('success', 'product Author Deleted Successfully.');
    }
}
