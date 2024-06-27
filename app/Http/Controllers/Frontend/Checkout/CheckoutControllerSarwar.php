<?php

namespace App\Http\Controllers\Frontend\Checkout;

use App\helper\ViewHelper;
use App\Http\Controllers\Backend\BkashController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Order\OrderSubmitRequest;
use App\Models\Backend\AdditionalFeatureManagement\Affiliation\AffiliationHistory;
use App\Models\Backend\AdditionalFeatureManagement\Affiliation\AffiliationRegistration;
use App\Models\Backend\BatchExamManagement\BatchExam;
use App\Models\Backend\Course\Course;
use App\Models\Backend\Course\CourseCoupon;
use App\Models\Backend\OrderManagement\ParentOrder;
use App\Models\Backend\UserManagement\Student;
use App\Models\Frontend\CourseOrder\CourseOrder;
use DGvai\SSLCommerz\SSLCommerz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckoutControllerSarwar extends Controller
{
//    public function placeCourseOrder (OrderSubmitRequest $request)
    public function placeCourseOrder (Request $request, $modelId = null)
    {
//        return $request;

        try {

            if (auth()->check())
            {
                if (isset($request->rc))
                {
                    $existAffiliateUser = AffiliationRegistration::where('user_id', ViewHelper::loggedUser()->id)->first();
                    if (isset($existAffiliateUser) && $existAffiliateUser->affiliate_code == $request->rc)
                    {
                        return ViewHelper::returEexceptionError('You can not use your own referral code.');
                    }
                }
                $existUser = ParentOrder::where(['user_id' => ViewHelper::loggedUser()->id, 'ordered_for' => 'course', 'parent_model_id' => $request->course_id])->first();
                if (!empty($existUser))
                {
                    if (str()->contains(url()->current(), '/api/'))
                    {
                        return response()->json(['message' => 'Sorry. You already enrolled this course.'], 400);
                    }
                    return back()->with('error', 'Sorry. You already enrolled this course.');
                }
                if (isset($request->coupon_code))
                {
                    $courseCoupon = CourseCoupon::where(['code' => $request->coupon_code, 'course_id' => $request->course_id])->first();
                    if (!empty($courseCoupon))
                    {

                        $request['total_amount']  = $request->total_amount - $courseCoupon->discount_amount;
                    }
                }
//                return $request;
//                CourseOrder::saveOrUpdateCourseOrder($request);
                if ($request->payment_method == 'ssl')
                {
                    if (str()->contains(url()->current(), '/api/'))
                    {
                        $request['parent_model_id'] = $modelId;
                        ParentOrder::createOrderAfterSsl($request);
                        return response()->json(['success' => 'Payment completed successfully.']);
                    }
                    $request['details_url'] = url()->previous();
                    $request['model_name'] = 'course';
                    $request['model_id'] = $request->course_id;
                    $request['affiliate_amount'] = Course::find($request->course_id)->affiliate_amount;
                    \session()->put('requestData', $request->all());
                    return self::sendOrderRequestToSSLZ($request->total_amount, Course::find($request->course_id)->title);
                }
                elseif ($request->payment_method == 'bkash'){
//                    if (str()->contains(url()->current(), '/api/'))
//                    {
//                        $request['parent_model_id'] = $modelId;
//                        ParentOrder::createOrderAfterSsl($request);
//                        return response()->json(['success' => 'Payment completed successfully.']);
//                    }
                    $request['details_url'] = url()->previous();
                    $request['model_name'] = 'course';
                    $request['model_id'] = $request->course_id;
                    $request['affiliate_amount'] = Course::find($request->course_id)->affiliate_amount;
                    \session()->put('requestData', $request->all());
                    $bkash=new BkashController();
                    return $bkash->createPayment($request);

                }
                elseif ($request->payment_method == 'cod')
                {
                    $this->validate($request, [
                        'vendor'    => 'required',
                        'paid_to'   => ['required', 'regex:/^(?:\+88|88)?(01[3-9]\d{8})$/'],
                        'paid_from' => ['required', 'regex:/^(?:\+88|88)?(01[3-9]\d{8})$/'],
                        'txt_id'    => 'required',
                    ]);
                    $order = ParentOrder::storeXmOrderInfo($request, $request->course_id);
                    if (isset($request->rc))
                    {
                        AffiliationHistory::createNewHistory($request, 'course', $request->course_id, Course::find($request->course_id)->affiliate_amount, 'insert');
                    }
                    if (str()->contains(url()->current(), '/api/'))
                    {
                        return response()->json(['message' => 'You Ordered the course successfully.'], 200);
                    }
                    return redirect()->route('front.student.dashboard')->with('success', 'You Ordered the course successfully.');
                }


            } else {
                Session::put('course_redirect_url', url()->current());
                if (str()->contains(url()->current(), '/api/'))
                {
                    return response()->json(['message' => 'Please Login First.'], 401);
                }
                return redirect()->route('login')->with('error', 'Please Login First');
            }
        } catch (\Exception $exception)
        {
            return ViewHelper::returEexceptionError($exception->getMessage());
        }

    }

    public function placeFreeCourseOrder(Request $request, $courseId)
    {
        $existOrder = ParentOrder::where(['user_id' => ViewHelper::loggedUser()->id, 'parent_model_id' => $courseId, 'ordered_for' => $request->ordered_for])->first();
        if (empty($existOrder)) {
            $student = Student::where('user_id', ViewHelper::loggedUser()->id)->first();
            if (isset($student))
            {
                ParentOrder::create([
                    'user_id' => ViewHelper::loggedUser()->id,
                    'parent_model_id' => $courseId,
                    'ordered_for' => $request->ordered_for,
                    'paid_amount' => 0,
                    'total_amount' => 0,
                    'status' => 'approved',
                    'payment_status' => 'complete',
                    'is_free_course' => 1,
                ]);
                if ($request->ordered_for == 'course')
                {
                    Course::find($courseId)->students()->attach($student->id);
                } elseif ($request->ordered_for == 'batch_exam')
                {
                    BatchExam::find($courseId)->students()->attach($student->id);
                }
                if (str_contains(url()->current(), '/api/'))
                {
                    return ViewHelper::returnSuccessMessage('You ordered this course successfully.');
                }
            } else {
                return ViewHelper::returEexceptionError('Please enroll with a student id.');
            }

        }
        if ($request->ordered_for == 'course')
        {
            return redirect()->route('front.student.course-contents', ['course_id' => $courseId])->with('success', 'You ordered this course successfully.');
        } else {
            return redirect()->route('front.student.batch-exam-contents', ['xm_id' => $courseId])->with('success', 'You ordered this Exam successfully.');
        }
    }

    public static function sendOrderRequestToSSLZ($totalAmount, $contentName)
    {
        $sslc = new SSLCommerz();
        $sslc->amount($totalAmount)
            ->trxid(ParentOrder::generateOrderNumber())
            ->product($contentName)
            ->customer(ViewHelper::loggedUser()->name, ViewHelper::loggedUser()->email ?? 'user@demo.com', ViewHelper::loggedUser()->mobile);
        return $sslc->make_payment();
    }

    public function paymentSuccess(Request $request)
    {
        try {
            $validate = SSLCommerz::validate_payment($request);
            if($validate)
            {
                $requestData = (object) \session()->get('requestData');
                if ($requestData->ordered_for == 'product')
                {

                    ParentOrder::orderProductThroughSSL($requestData, $request);
                } else {
                    ParentOrder::placeOrderAfterGatewayPayment($request, $requestData);
                    if ($requestData->ordered_for == 'course')
                    {
                        Course::find($requestData->model_id)->students()->attach(Student::whereUserId(ViewHelper::loggedUser()->id)->first()->id);
                    } elseif ($requestData->ordered_for == 'batch_exam')
                    {
                        BatchExam::find($requestData->model_id)->students()->attach(Student::whereUserId(ViewHelper::loggedUser()->id)->first()->id);
                    }
                    //  Do the rest database saving works
                    //  take a look at dd($request->all()) to see what you need
                    if (isset($requestData->rc))
                    {
                        AffiliationHistory::createNewHistory($requestData, $requestData->model_name, $requestData->model_id, $requestData->affiliate_amount, 'insert');
                    }
                }

                if (str()->contains(url()->current(), '/api/'))
                {
                    return response()->json(['message' => 'You Ordered the course successfully.'], 200);
                }
                return redirect()->route('front.student.dashboard')->with('success', 'You Ordered the '.$requestData->model_name.' successfully.');
            }
        } catch (\Exception $exception)
        {
            return ViewHelper::returEexceptionError($exception->getMessage());
        }
    }

    public function paymentFailure (Request $request)
    {
        $requestData = \session()->get('requestData');
        return redirect($requestData['details_url'])->with('error', 'Something went wrong with your payment. Please try again.');
    }
    public function paymentCancel (Request $request)
    {
        $requestData = \session()->get('requestData');
        return redirect($requestData['details_url'])->with('error', 'The request was canceled by the user. Payment not completed.');
    }
    public function ipn (Request $request)
    {

    }
}
