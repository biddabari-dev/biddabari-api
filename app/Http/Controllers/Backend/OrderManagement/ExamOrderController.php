<?php

namespace App\Http\Controllers\Backend\OrderManagement;

use App\Http\Controllers\Controller;
use App\Models\Backend\BatchExamManagement\BatchExamCategory;
use App\Models\Backend\ExamManagement\Exam;
use App\Models\Backend\ExamManagement\ExamCategory;
use App\Models\Backend\ExamManagement\ExamOrder;
use App\Models\Backend\OrderManagement\ParentOrder;
use App\Models\Backend\UserManagement\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class ExamOrderController extends Controller
{
    //    permission seed done
    protected $examOrders;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('manage-batch-exam-order'), Response::HTTP_FORBIDDEN, '403 Forbidden');
//        if (!empty($request->category_id))
//        {
//            $this->examOrders = ExamOrder::whereExamCategoryId($request->category_id)->get();
//        } else {
//            $this->examOrders = ExamOrder::whereStatus('pending')->take(10)->get();
//        }
        $this->examOrders = ParentOrder::whereOrderedFor('batch_exam')->latest()->take(1000)->get();
        return view('backend.order-management.exam-order.index', [
//            'exams'   => Exam::whereStatus(1)->get(),
            'examOrders'  => !empty($this->examOrders) ? $this->examOrders : '',
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
        abort_if(Gate::denies('update-batch-exam-order'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $parentOrder = ParentOrder::updateExamOrderStatus($request, $id);
            if ($request->status == 'approved')
            {
                $student = Student::whereUserId($parentOrder->user_id)->first();
                $parentOrder->batchExam->students()->attach($student->id);
            }
        return redirect()->back()->with('success', 'Order Status Updated Successfully');

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
        abort_if(Gate::denies('delete-batch-exam-order'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $parentOrder = ParentOrder::find($id);
//        return $parentOrder;
        ParentOrder::detachStudent('batch_exam', $parentOrder->parent_model_id, $parentOrder->user_id);
        $parentOrder->delete();
        return back()->with('success', 'Order Deleted Successfully');
    }

    public function changeContactStatus(Request $request, string $id)
    {
        abort_if(Gate::denies('change-batch-exam-contact-status'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $courseOrder = ParentOrder:: find($id)->update(['contact_status' => $request->contact_status, 'checked_by' => auth()->id()]);
        return back()->with('success', 'Order Contact Status Updated Successfully');
    }


}
