<?php

namespace App\Http\Controllers\Backend\ExamManagement;

use App\helper\ViewHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Order\OrderSubmitRequest;
use App\Models\Backend\ExamManagement\ExamSubscriptionPackage;
use App\Models\Backend\ExamManagement\SubscriptionOrder;
use Illuminate\Http\Request;

class ExamSubscriptionPackageController extends Controller
{
    protected $subscriptionPackage;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.exam-management.exam-subscriptions.index', [
            'subscriptions'      => ExamSubscriptionPackage::latest()->get()
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
        try {
            ExamSubscriptionPackage::updateOrCreateXmSubscriptionPackage($request);
            if ($request->ajax())
            {
                return response()->json('Exam Subscription Package created successfully.');
            } else {
                return back()->with('success', 'Exam Subscription Package Created Successfully');
            }
        } catch (\Exception $exception)
        {
            if ($request->ajax())
            {
                return response()->json($exception->getMessage());
            } else {
                return back()->with('error', $exception->getMessage());
            }
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
//        change status function goes here
        $status = '';
        $this->subscriptionPackage = ExamSubscriptionPackage::find($id);
        if ($this->subscriptionPackage->status == 0)
        {
            $this->subscriptionPackage->status = 1;
            $status = 'pub';
        }else if ($this->subscriptionPackage->status == 1)
        {
            $this->subscriptionPackage->status = 0;
            $status = 'unPub';
        }
        $this->subscriptionPackage->save();
        return response()->json($status);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return response()->json(ExamSubscriptionPackage::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        ExamSubscriptionPackage::updateOrCreateXmSubscriptionPackage($request, $id);
        if ($request->ajax())
        {
            return response()->json('Exam Subscription Package created successfully.');
        } else {
            return back()->with('success', 'Exam Subscription Package Created Successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        ExamSubscriptionPackage::find($id)->delete();
        return back()->with('success', 'Exam Subscription Package deleted Successfully');
    }

    protected $data = [], $examSubscriptionPackage;
    public function details ($id, $slug = null)
    {
        $this->examSubscriptionPackage = ExamSubscriptionPackage::find($id);
        $this->data = [
            'subscription'  => $this->examSubscriptionPackage,
            'subscriptionStatus'    => ViewHelper::checkIfSubscriptionIsPurchased($this->examSubscriptionPackage),
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.exams.subscription.details');
    }

    public function orderSubscription (Request $request, $id)
    {
        if (auth()->check())
        {
            $request->validate([
                'vendor'    => 'required',
                'paid_to'   => ['required', 'regex:/^(?:\+88|88)?(01[3-9]\d{8})$/'],
                'paid_form' => ['required', 'regex:/^(?:\+88|88)?(01[3-9]\d{8})$/'],
                'txt_id'    => 'required',
            ]);
            SubscriptionOrder::createSubscriptionOrder($request, $id);
            return back()->with('success', 'Congratulations, You Successfully Purchase this package.');
        } else {
            return back()->with('error', 'Please Login First.');
        }
    }
}
