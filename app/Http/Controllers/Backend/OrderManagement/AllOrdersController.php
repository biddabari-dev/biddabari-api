<?php

namespace App\Http\Controllers\Backend\OrderManagement;

use App\DataTables\ParentOrderDataTable\AllOrders;
use App\Http\Controllers\Controller;
use App\Models\Backend\OrderManagement\ParentOrder;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class AllOrdersController extends Controller
{
    //    permission seed done
    protected $allOrders;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, AllOrders $dataTable)
   {
//        return $request;
        abort_if(Gate::denies('manage-all-order'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->allOrders=ParentOrder::orderBy('id','DESC');
        if($request->date== null && $request->status== null && $request->type == null && $request->payment == null && $request->search == null){
            $this->allOrders = ParentOrder::latest();
        }else{
            if (isset($request->date))
            {
                $this->allOrders=$this->allOrders->whereBetween('created_at',[$request->date.' 00:00:00',$request->date.' 23:59:59']);
            }
            if (isset($request->status)){
                $this->allOrders=$this->allOrders->where('status',$request->status);
            }
            if (isset($request->type)){
                $this->allOrders = $this->allOrders->where('ordered_for',$request->type);
            }
            if (isset($request->payment)){
                $this->allOrders = $this->allOrders->where('payment_status',$request->payment);
            }
             if (isset($request->search)){
                $user=User::where('mobile',$request->search)->first();
               if (isset($user)){
                   $this->allOrders = $this->allOrders->where('paid_from',$request->search)->orWhere('paid_to',$request->search)->orWhere('user_id',$user->id);

               }else{
                   $this->allOrders = $this->allOrders->where('paid_from',$request->search)->orWhere('paid_to',$request->search);

               }
            }
        }
//        return $dataTable->render('backend.order-management.all-order.index');
//        if (!empty($request->order_type) && $request->order_type != 'all')

//        $this->allOrders = $this->allOrders->latest()->paginate(1000);
        $this->allOrders = $this->allOrders->where('total_amount','>', '0')->paginate(25);
        return view('backend.order-management.all-order.index', [
            'allOrders'  => !empty($this->allOrders) ? $this->allOrders : '',
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getCourseOrderDetails ($id)
    {
        return view('backend.order-management.all-order.course-order-details', [
//            'courseOrder'   => CourseOrder::find($id),
            'order'   => ParentOrder::find($id),
        ]);
    }
}
