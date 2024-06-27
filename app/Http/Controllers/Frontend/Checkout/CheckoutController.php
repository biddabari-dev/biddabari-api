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
use App\Models\User;
use DGvai\SSLCommerz\SSLCommerz;
use GuzzleHttp\Client;
use Illuminate\Bus\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    public static $user;
//    public function placeCourseOrder (OrderSubmitRequest $request)
    public function placeCourseOrder (Request $request, $modelId = null)
    {
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
                    \cookie('requestData', json_encode($request->all()), 20);

                    return self::sendOrderRequestToSSLZ($request->total_amount, Course::find($request->course_id)->title, $request);
                }
                elseif ($request->payment_method == 'bkash'){
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

    public function commonOrder (Request $request, $modelId = null)
    {
        try {

            Validator::make($request->all(), [
                'name'  => 'required',
                'mobile'  => ['required','confirmPhone', 'regex:/^(?:\+88|88)?(01[3-9]\d{8})$/'],
                'payment_method'  => 'required',
            ]);
            if (!empty($request->mobile))
            {
                $checkExistUser = User::where('mobile', $request->mobile)->first();
                if (!empty($checkExistUser))
                {
                    $checkExistOrder = ParentOrder::where(['user_id' => $checkExistUser->id, 'parent_model_id' => $request->model_id, 'ordered_for' => $request->ordered_for])->first();
                    if (!empty($checkExistOrder))
                    {
                        return ViewHelper::returEexceptionError('You already ordered this. Please check your dashboard');
                    }
                }
            }
            if ($request->mobile != $request->confirm_mobile)
            {
                return ViewHelper::returEexceptionError('Phone number didn\'t match. Please try again.');
    //            return back()->with('error', 'Phone number didn\'t match. Please try again.');
            }
            if (isset($request->rc) && auth()->check())
            {
                $existAffiliateUser = AffiliationRegistration::where('user_id', ViewHelper::loggedUser()->id)->first();
                if (isset($existAffiliateUser) && $existAffiliateUser->affiliate_code == $request->rc)
                {
                    return ViewHelper::returEexceptionError('You can not use your own referral code.');
                }
            }
//            $userExistStatus = User::where('mobile', $request->mobile)->first();
//            if (!empty($userExistStatus))
//            {
//                $existUser = ParentOrder::where(['user_id' => $userExistStatus->id, 'ordered_for' => $request->ordered_for, 'parent_model_id' => $request->model_id])->first();
//                if (!empty($existUser))
//                {
//                    if (str()->contains(url()->current(), '/api/'))
//                    {
//                        return response()->json(['message' => 'Sorry. You already enrolled this course.'], 400);
//                    }
//                    return back()->with('error', 'Sorry. You already enrolled this course.');
//                }
//            }

            if ($request->ordered_for == 'course')
            {
                if (isset($request->coupon_code))
                {
                    $courseCoupon = CourseCoupon::where(['code' => $request->coupon_code, 'course_id' => $request->model_id])->first();
                    if (!empty($courseCoupon))
                    {

                        $request['total_amount']  = $request->total_amount - $courseCoupon->discount_amount;
                    }
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
                $request['model_name'] = $request->ordered_for;
    //                $request['model_id'] = $request->model_id;
                $request['affiliate_amount'] = $request->ordered_for == 'course' ? Course::find($request->model_id)->affiliate_amount : BatchExam::find($request->model_id)->affiliate_amount;
                \session()->put('requestData', $request->all());

                return self::sendOrderRequestToSSLZ($request->total_amount, $request->ordered_for == 'course' ? Course::find($request->model_id)->title : BatchExam::find($request->model_id)->title, $request);
            }
            elseif ($request->payment_method == 'bkash'){
    //                return $request;
    //            return back()->with('Wr are not accepting payments from this gateway. Please use Other payment gateway to complete your payment');
                $request['details_url'] = url()->previous();
                $request['model_name'] = $request->ordered_for;
    //                $request['model_id'] = $request->course_id;
                $request['affiliate_amount'] = $request->ordered_for == 'course' ? Course::find($request->model_id)->affiliate_amount : BatchExam::find($request->model_id)->affiliate_amount;
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
        } catch (\Exception $exception)
        {
            return ViewHelper::returEexceptionError($exception->getMessage());
        }

    }

    public static function sendOrderRequestToSSLZ($totalAmount, $contentName, $formRequestData = null)
    {
        $sslc = new SSLCommerz();
        $sslc->amount($totalAmount)
            ->trxid(ParentOrder::generateOrderNumber())
            ->product($contentName)
            ->customer(
                \auth()->check() ? ViewHelper::loggedUser()->name : ($formRequestData->name ?? 'Unknown' ),
                ViewHelper::loggedUser()->email ?? 'user@demo.com',
                \auth()->check() ? ViewHelper::loggedUser()->mobile : ($formRequestData->mobile ?? 'Unknown' ),
            );
        return $sslc->make_payment();
    }

    public function paymentSuccess(Request $request)
    {
        try {
        $validate = SSLCommerz::validate_payment($request);
        if($validate)
        {
            $requestData = (object) \session()->get('requestData');
            if (!empty($requestData))
            {
                $userCreateAuth = CheckoutController::createUserAfterOrder($requestData);


                if ($userCreateAuth['processStatus'] == 'success')
                {
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
                        if (isset($requestData->rc))
                        {
                            AffiliationHistory::createNewHistory($requestData, $requestData->model_name, $requestData->model_id, $requestData->affiliate_amount, 'insert');
                        }
                    }

                    if (!$userCreateAuth['userStatus'])
                    {   ViewHelper::returEexceptionError('We got your payment but we faced problem during creating your account in our system. Please try again.');
//                        return redirect()->back()->with('error', 'We got your payment but we faced problem during creating your account in our system. Please try again.');
                    }
                        if ($userCreateAuth['smsStatus'] == 'failed')
                        {   ViewHelper::returEexceptionError('Your successfully enrolled in the course but something went wrong during sending sms to your number. Please Contact with our support.');
//                            return redirect()->route('front.student.dashboard')->with('error', 'Your successfully enrolled in the course but something went wrong during sending sms to your number. Please Contact with our support.');
                        }

                    if (str()->contains(url()->current(), '/api/'))
                    {   ViewHelper::returEexceptionError('You Ordered the course successfully.');
//                        return response()->json(['message' => 'You Ordered the course successfully.'], 200);
                    }
                    return redirect()->route('front.student.dashboard')->with('success', 'You Ordered the '.$requestData->model_name.' successfully.');
                } elseif ($userCreateAuth['processStatus'] == 'failed')
                {   ViewHelper::returEexceptionError('Something went wrong during payment. Please try again.');
//                    return redirect()->back()->with('error', 'Something went wrong during payment. Please try again.');
                }



//                    return self::createOrderAndAssignStudent($requestData, $request);
            } else {
                return 'Data is missing from session';
            }


        }
        } catch (\Exception $exception)
        {
            return ViewHelper::returEexceptionError($exception->getMessage());
        }
    }

    public static function createOrderAndAssignStudent($requestData, $request)
    {

        $userCreateAuth = CheckoutController::createUserAfterOrder($requestData);
        if ($userCreateAuth['processStatus'] == 'success')
        {
            if (!$userCreateAuth['userStatus'])
            {
                return redirect()->back()->with('error', 'We faced problem during creating your account in our system. Please try again.');
            }
            if ($userCreateAuth['smsStatus'] == 'failed')
            {
                return redirect()->route('front.student.dashboard')->with('error', 'Something went wrong during sending sms to your number. Please Contact with our support.');
            }
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
        } elseif ($userCreateAuth['processStatus'] == 'failed')
        {
            return redirect()->back()->with('error', 'Something went wrong during payment. Please try again.');
        }
    }

    public static function createUserAfterOrder($requestData)
    {
        $smsStatus = 'failed';
        $userStatus = false;
        try {
        if (!empty($requestData->name) && !empty($requestData->mobile))
        {

            self::$user = User::where('mobile', $requestData->mobile)->first();
            $pass = rand(10000, 99999);
            if ($requestData->ordered_for == 'course')
            {
                $model = Course::find($requestData->model_id);
            } elseif ($requestData->ordered_for == 'batch_exam')
            {
                $model = BatchExam::find($requestData->model_id);
            }
            if (!empty(self::$user))
            {
                if (!\auth()->check())
                {
                    Auth::login(self::$user);
                }
                $message = "Congratulations!+You+are+successfully+enrolled+in+".strip_tags($model->title).".+Your+Registered+Number+is+$requestData->mobile.Stay+connected with Biddabari.+For+more+queries+call-01896060800-15.";
            } else {

                self::$user = User::createOrUpdateUserAfterPayment($requestData, $pass);
                $newStudent = Student::createStudentAfterPayment($requestData, self::$user);
                Auth::login(self::$user);
                $message = "Congratulations!+You+are+successfully+enrolled+in+".strip_tags($model->title).".+Your+Registered+Number+is+$requestData->mobile+and+Your+Password+is+$pass.+For+more+queries-01896060800-15.";
            }
            if (!empty(self::$user))
            {
                $userStatus = true;
            }

            $client = new Client();
                $body = $client->request('GET', 'https://msg.elitbuzz-bd.com/smsapi?api_key=C2008649660d0a04f3d0e9.72990969&type=text&contacts='.$requestData->mobile.'&senderid=8809601011181&msg='.$message);
                $responseCode = explode(':',$body->getBody()->getContents() )[1];
                if (isset($responseCode) && !empty($responseCode))
                {
                    $smsStatus   = 'success';
                }
            return [
                'smsStatus' => $smsStatus,
                'user'      => self::$user,
                'userStatus'    => $userStatus,
                'processStatus' => 'success',
            ];

        } else {
//                return 'user not exist in db';
            return [
                'smsStatus' => 'failed',
                'user'      => self::$user,
                'userStatus'    => false,
                'processStatus' => 'failed',
            ];
//                return redirect('/')->with('error', 'We didn\'t find your name and mobile. Please contact with our service center.');
        }


        } catch (\Exception $exception)
        {
            return [
                'smsStatus' => 'failed',
                'user'      => self::$user,
                'userStatus'    => false,
                'processStatus' => 'failed',
            ];
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
        return redirect('/');
    }
}
