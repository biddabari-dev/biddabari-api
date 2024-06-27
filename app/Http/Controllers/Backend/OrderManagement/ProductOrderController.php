<?php

namespace App\Http\Controllers\Backend\OrderManagement;

use App\Http\Controllers\Controller;
use App\Models\Backend\OrderManagement\ParentOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class ProductOrderController extends Controller
{
    //    permission seed done
    protected $productOrders;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('manage-product-order'), Response::HTTP_FORBIDDEN, '403 Forbidden');
//        if (!empty($request->category_id))
//        {
//            $this->examOrders = ExamOrder::whereExamCategoryId($request->category_id)->get();
//        } else {
//            $this->examOrders = ExamOrder::whereStatus('pending')->take(10)->get();
//        }
        $this->productOrders = ParentOrder::whereOrderedFor('product')->latest()->take(1000)->get();
        return view('backend.order-management.product-order.index', [
//            'exams'   => Exam::whereStatus(1)->get(),
            'productOrders'  => !empty($this->productOrders) ? $this->productOrders : '',
//            'examCategories'    => BatchExamCategory::whereStatus(1)->get(),
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
        return response()->json(ParentOrder::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('update-product-order'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        ParentOrder::updateExamOrderStatus($request, $id);
        return back()->with('success', 'Order Status Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('delete-product-order'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        ParentOrder::find($id)->delete();
        return back()->with('success', 'Order Deleted Successfully');
    }

    public function changeContactStatus(Request $request, string $id)
    {
        abort_if(Gate::denies('change-product-order-contact-status'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $courseOrder = ParentOrder:: find($id)->update(['contact_status' => $request->contact_status, 'checked_by' => auth()->id()]);
        return back()->with('success', 'Order Contact Status Updated Successfully');
    }
}
