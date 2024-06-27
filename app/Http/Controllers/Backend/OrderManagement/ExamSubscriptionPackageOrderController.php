<?php

namespace App\Http\Controllers\Backend\OrderManagement;

use App\Http\Controllers\Controller;
use App\Models\Backend\ExamManagement\ExamSubscriptionPackage;
use App\Models\Backend\ExamManagement\SubscriptionOrder;
use Illuminate\Http\Request;

class ExamSubscriptionPackageOrderController extends Controller
{
    protected $subscriptionOrders;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!empty($request->subscription_id))
        {
            $this->subscriptionOrders = SubscriptionOrder::where('exam_subscription_package_id',$request->subscription_id)->get();
        }
        return view('backend.order-management.subscription-order.index', [
            'subscriptions'   => ExamSubscriptionPackage::whereStatus(1)->get(),
            'subscriptionOrders'  => !empty($this->subscriptionOrders) ? $this->subscriptionOrders : '',
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
        return response()->json(SubscriptionOrder::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        SubscriptionOrder::updateExamOrderStatus($request, $id);
        return back()->with('success', 'Order Status Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        SubscriptionOrder::find($id)->delete();
        return back()->with('success', 'Order Deleted Successfully');
    }

    public function changeContactStatus(Request $request, string $id)
    {
        $courseOrder = SubscriptionOrder:: find($id)->update(['contact_status' => $request->contact_status, 'checked_by' => auth()->id()]);
        return back()->with('success', 'Order Contact Status Updated Successfully');
    }
}
