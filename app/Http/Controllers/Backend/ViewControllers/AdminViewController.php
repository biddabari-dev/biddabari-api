<?php

namespace App\Http\Controllers\Backend\ViewControllers;

use App\Http\Controllers\Controller;
use App\Models\Backend\Course\Course;
use App\Models\Backend\OrderManagement\ParentOrder;
use App\Models\Backend\UserManagement\Student;
use App\Models\Backend\UserManagement\Teacher;
use Illuminate\Http\Request;

use App\Models\Backend\Course\CourseSection;
use App\Models\Backend\Course\CourseExamResult;
use App\Models\Backend\Course\CourseSectionContent;
use Illuminate\Support\Facades\DB;

class AdminViewController extends Controller
{
    protected $data = [];
    public function dashboard ()
    {
        $user = auth()->user();
        foreach ($user->roles as $role)
        {
            if (count($user->roles) < 2)
            {
                if ($role->id == 4)
                {
                    return redirect()->route('front.student.dashboard');
                }
            }
        }

        $allOrders = ParentOrder::where('status', 'approved')->get(['id', 'ordered_for', 'paid_amount', 'total_amount', 'status']);
        $courseOrderAmount = 0;
        $coursePaidOrderAmount = 0;
        $batchExamOrderAmount = 0;
        $batchExamPaidOrderAmount = 0;
        $productOrderAmount = 0;
        $productPaidOrderAmount = 0;
        foreach ($allOrders as $order)
        {
            if ($order->ordered_for == 'course')
            {
                $courseOrderAmount  += $order->total_amount;
                $coursePaidOrderAmount  += $order->paid_amount;
            } elseif ($order->ordered_for == 'batch_exam')
            {
                $batchExamOrderAmount  += $order->total_amount;
                $batchExamPaidOrderAmount  += $order->paid_amount;
            } elseif ($order->ordered_for == 'product')
            {
                $productOrderAmount  += $order->total_amount;
                $productPaidOrderAmount  += $order->paid_amount;
            }
        }

        $this->data = [
            'totalStudents'     => Student::count(),
            'totalTeachers'     => Teacher::count(),
            'totalCourses'     => Course::count(),
            'totalIncome'       => $allOrders->sum('total_amount'),
            'totalOrder'        => $allOrders->count(),
            'courseOrderAmount'    => $courseOrderAmount,
            'coursePaidOrderAmount'    => $coursePaidOrderAmount,
            'batchExamOrderAmount'    => $batchExamOrderAmount,
            'batchExamPaidOrderAmount'    => $batchExamPaidOrderAmount,
            'productOrderAmount'    => $productOrderAmount,
            'productPaidOrderAmount'    => $productPaidOrderAmount,
        ];
        return view('backend.single-view.dashboard.dashboard', $this->data);
    }

    public function changeStatus(Request $request, $id = null)
    {
        $status = '';
        try {
            $object = DB::table($request->model_name)->where('id', $request->id)->first();
            if ($object->status == 1)
            {
                $object = DB::table($request->model_name)->where('id', $request->id)->update(['status' => 0]);
                $status = 'Unpublished';
            } elseif ($object->status == 0)
            {
                $object = DB::table($request->model_name)->where('id', $request->id)->update(['status' => 1]);
                $status = 'Published';
            }
            return response()->json(['status' => 'success', 'message' => $status]);
        } catch (\Exception $exception)
        {
            return response()->json($exception->getMessage());
        }
    }
}
