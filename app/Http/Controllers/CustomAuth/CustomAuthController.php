<?php

namespace App\Http\Controllers\CustomAuth;

use App\helper\ViewHelper;
use App\Http\Controllers\Controller;
use App\Models\Backend\UserManagement\Student;
use App\Http\Controllers\Frontend\Checkout\CheckoutController;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Xenon\LaravelBDSms\Facades\SMS;
use Xenon\LaravelBDSms\Provider\MimSms;
use Xenon\LaravelBDSms\Sender;
use App\Http\Requests\Auth\UserRegisterRequest;
use Hash;

class CustomAuthController extends Controller
{
    protected $email, $phone, $password, $user;
    public function login(Request $request)
    {

        // $this->validate($request, [
        //     'mobile'   => ['required','numeric|regex:/^(?:\+88|88)?(01[3-9]\d{8})$/']

        // ]);
        if (str()->contains(url()->current(), '/api/'))
        {
            $pass = rand(10000, 99999);

            if(isset($request->name)){

                $check = User::where('mobile',$request->mobile)->first();

                if ($check != null) {
                    # code...
                    $user = Auth::loginUsingId($check->id);
                } else {
                    # code...
                    $add = new User;
                    $add->name = $request->name;
                    $add->mobile = $request->mobile;
                    $add->password = Hash::make($pass);
                    $add->save();

                    $user = Auth::loginUsingId($add->id);
                }



                return response()->json([
                    'user'  => $user,
                    'auth_token' => $user->createToken('auth_token')->plainTextToken,
                    'status'    => 200
                ]);

            }

        }

        if (auth()->attempt($request->only(['mobile', 'password']), $request->remember_me))
        {
            $this->user = auth()->user();
            $this->user->device_token = session()->getId();
            $this->user->save();
            if (str()->contains(url()->current(), '/api/'))
            {
                return response()->json([
                    'user'  => $this->user,
                    'auth_token' => $this->user->createToken('auth_token')->plainTextToken,
                    'status'    => 200
                ]);
            } else {
                if (Session::has('course_redirect_url'))
                {
                    $redirectUrl = Session::get('course_redirect_url');

                    if ($request->ajax())
                    {
                        return response()->json(['status' => 'success','url' => $redirectUrl]);
                    } else {
                        return redirect($redirectUrl)->with('success', 'You are successfully logged in.');
                    }
                }
                return redirect('/')->with('success', 'You are successfully logged in.');
            }
        }
        if (str()->contains(url()->current(), '/api/')) {
            return response()->json(['error' => 'Phone no and Password does not match . Please try again.'],500);
        } else {
            if ($request->ajax())
            {
                return response()->json(['status' => 'error']);
            }
            return redirect()->route('login')->with('error', 'Phone no and Password does not match . Please try again.');
        }

//         if (auth()->attempt($request->only(['mobile', 'password']), $request->remember_me))
//         {

//             $this->user = auth()->user();
//             $this->user->device_token = session()->getId();
//             $this->user->save();
//             if (str()->contains(url()->current(), '/api/'))
//             {

//                 return response()->json([
//                     'user'  => $this->user,
//                     'auth_token' => $this->user->createToken('auth_token')->plainTextToken,
//                     'status'    => 200
//                 ]);
//             } else {

// //                 if (Session::has('course_redirect_url'))
// //                 {

// // //                    return Session::get('course_redirect_url');
// //                     $redirectUrl = Session::get('course_redirect_url');
// //                     // Session::forget('course_redirect_url');
// //                     return response()->json(['status' => 'success','url'=>$redirectUrl]);
// // //                    return redirect('/')->with('success', 'You are successfully logged in.');
// //                 }
//                 if ($request->ajax())
//                 {
//                     // return 'ajax';
//                     return response()->json(['status' => 'success', 'url' => url('/')]);
//                 }
//                 // return 'wrong';
//                 return redirect()->route('home')->with('success', 'You are successfully logged in.');
//             }
//         }
//         if (str()->contains(url()->current(), '/api/')) {
//             return response()->json(['error' => 'Email and Password does not match . Please try again.'],500);
//         } else {
//             if ($request->ajax())
//             {
//                 return response()->json(['status' => 'error']);
//             }
//             return redirect()->route('login')->with('error', 'Something went wrong. Please try again');
//         }
    }

    public function register (UserRegisterRequest $request)
    {


        // $this->validate($request, [
        //     'mobile'   => ['required','numeric|regex:/^(?:\+88|88)?(01[3-9]\d{8})$/']

        // ]);

            $request['roles'] = 4;
        $request['request_form'] = 'student';
        DB::beginTransaction();
        try {
            $this->user = User::createOrUpdateUser($request);
            if ($request->roles == 4)
            {
                Student::createOrUpdateStudent($request, $this->user);
            }

            DB::commit();
            if (isset($this->user)) {
                Auth::login($this->user);
                $this->user->device_token = session()->getId();
                $this->user->save();
                if (str()->contains(url()->current(), '/api/')) {
                    return response()->json(['user' => $this->user, 'auth_token' => $this->user->createToken('auth_token')->plainTextToken]);
                } else {
                    if (\session()->has('course_redirect_url'))
                    {
                        if ($request->ajax())
                        {
                            return response()->json(['status' => 'success', 'url' => \session()->get('course_redirect_url')]);
                        } else {
                            return redirect(\session()->get('course_redirect_url'))->with('success', 'Your registration completed successfully.');
                        }
                    }
                    if ($request->roles == 4)
                    {
                        return redirect()->route('home')->with('success', 'Your registration completed successfully.');
                    }
                    return redirect()->route('home')->with('success', 'Your registration completed successfully.');
                }
            }
        } catch (\Exception $exception)
        {
            DB::rollBack();
            if (str()->contains(url()->current(), '/api/')) {
                return response()->json(['error' => $exception->getMessage()],500);
            } else {
                if ($request->ajax())
                {
                    return response()->json(['status' => 'error']);
                }
                return redirect('/register')->with('error', $exception->getMessage());
            }
        }



//         $request['roles'] = 4;
//         $request['request_form'] = 'student';
// //        return $request;
//         DB::beginTransaction();
//         try {
//             $this->user = User::createOrUpdateUser($request);
//             $this->user->device_token = session()->getId();
//             $this->user->save();
//             if ($request->roles == 4)
//             {
//                 Student::createOrUpdateStudent($request, $this->user);
//             }

//             DB::commit();
//             if (isset($this->user)) {
//                 Auth::login($this->user);
//                 if (str()->contains(url()->current(), '/api/')) {
//                     return response()->json(['user' => $this->user, 'auth_token' => $this->user->createToken('auth_token')->plainTextToken]);
//                 } else {
//                     if ($request->ajax())
//                     {
//                         // return $this->login($request);
//                         return response()->json(['status' => 'success']);
//                     }
//                     if ($request->roles == 4)
//                     {
//                         // return $this->login($request);
//                         return redirect()->route('home')->with('success', 'Your registration completed successfully.');
//                     }
//                     return redirect()->route('home')->with('success', 'Your registration completed successfully.');
//                 }
//             }
//         } catch (\Exception $exception)
//         {
//             DB::rollBack();
//             if (str()->contains(url()->current(), '/api/')) {
//                 return response()->json(['error' => $exception->getMessage()],500);
//             } else {
//                 if ($request->ajax())
//                 {
//                     return response()->json(['status' => 'error']);
//                 }
//                 return redirect('/register')->with('error', $exception->getMessage());
//             }
//         }


//        return 'register failed';
    }

    public function sendOtp (Request $request)
    {
//        return $request;
        $otpNumber = rand(1000, 9999);
        try {
            $existUser = User::whereMobile($request->mobile)->first();
//            return $existUser;
            if (!isset($existUser))
            {
                //            test two
                $client = new Client();
                //$body = $client->request('GET', 'http://sms.felnadma.com/api/v1/send?api_key=44516684285595991668428559&contacts=88'.$request->mobile.'&senderid=01844532630&msg=Biddabari+otp+is+'.$otpNumber);

                $body = $client->request('GET', 'https://msg.elitbuzz-bd.com/smsapi?api_key=C2008649660d0a04f3d0e9.72990969&type=text&contacts='.$request->mobile.'&senderid=8809601011181&msg=Biddabari+otp+is+'.$otpNumber);

                //echo '<pre>'; print_r( explode(':',$body->getBody()->getContents() )[1] ); die();
                //die($body->getBody()->getContents())[0])[1]);

                $responseCode = explode(':',$body->getBody()->getContents() )[1];

                //$responseCode = explode(':', explode(',', $body->getBody()->getContents())[0])[1];
//            return response()->json(gettype($responseCode));
//                return $responseCode;

                //if (isset($responseCode) && !empty($responseCode) && $responseCode === "\"445000\"")
                if (isset($responseCode) && !empty($responseCode))
                {
//                \session()->put('otp', $otpNumber);
                    session_start();
                    $_SESSION['otp'] = $otpNumber;
                    return response()->json(['otp' => $otpNumber, 'status' => 'success', 'user_status' => isset($existUser) ? 'exist' : 'not_exist']);
                } else {
                    return response()->json(['status' => 'false']);
                }
            } else {
                return response()->json([
                    'status' => 'success',
                    'user_status' => isset($existUser) ? 'exist' : 'not_exist',
                ]);
            }

        } catch (\Exception $exception)
        {
            return response()->json($exception->getMessage());
        }
    }

    public function verifyOtp (Request $request)
    {
//        $existUser = User::whereMobile($request->mobile_number)->first();
//        return $existUser;
        session_start();
        try {
//            if (Session::get('otp') == $request->otp)
            if ($_SESSION['otp'] == $request->otp)
            {
                \session()->forget('otp');
                $existUser = User::whereMobile($request->mobile_number)->first();
//                return $existUser;
                return response()->json([
                    'status' => 'success',
                    'user_status' => isset($existUser) ? 'exist' : 'not_exist',
                ]);
            } else {
                return response()->json(['error'=> 'OTP mismatch. Please Try again.']);
            }
        } catch (\Exception $exception)
        {
            return response()->json($exception->getMessage());
        }
    }
    public function checkUserForApp (Request $request)
    {

        try {
            $existUser = User::whereMobile($request->mobile_number)->first();
            return response()->json([
                'status' => 'success',
                'user_status' => isset($existUser) ? 'exist' : 'not_exist',
            ]);
        } catch (\Exception $exception)
        {
            return response()->json($exception->getMessage());
        }
    }

    public function forgotPassword ()
    {
        return view('backend.auth.forgot-password');
    }

    public function passResetOtp (Request $request)
    {
        $otpNumber = rand(100000, 999999);
        try {
            $client = new Client();
            //$body = $client->request('GET', 'http://sms.felnadma.com/api/v1/send?api_key=44516684285595991668428559&contacts=88'.$request->mobile.'&senderid=01844532630&msg=Biddabari+otp+is+'.$otpNumber);
            $body = $client->request('GET', 'https://msg.elitbuzz-bd.com/smsapi?api_key=C2008649660d0a04f3d0e9.72990969&type=text&contacts='.$request->mobile.'&senderid=8809601011181&msg=Biddabari+otp+is+'.$otpNumber);


            //$responseCode = explode(':', explode(',', $body->getBody()->getContents())[0])[1];
            $responseCode = explode(':',$body->getBody()->getContents() )[1];

            //if (isset($responseCode) && !empty($responseCode) && $responseCode === "\"445000\"")
            if (isset($responseCode) && !empty($responseCode))
            {
                session_start();
                $_SESSION['otp'] = $otpNumber;
                if (str()->contains(url()->current(), '/api/'))
                {
                    return response()->json([
                        'otp'       => $otpNumber,
                        'encoded_otp'       => base64_encode($otpNumber),
                        'mobile'    => $request->mobile,
                        'message'   => 'OTP send successfully',
                    ]);
                }
                return redirect(url('/password-reset-otp?mn='.$request->mobile.'&oc='.base64_encode($otpNumber)))->with('success', 'OTP send successfully');
            } else {
                return ViewHelper::returEexceptionError('Invalid Mobile Number or Format. Please Try again.');
//                return back()->with('error', 'Invalid Mobile Number or Format. Please Try again.');
            }
        } catch (\Exception $exception)
        {
            return ViewHelper::returEexceptionError('Something went wrong. Please try again');
//            return redirect()->back()->with('error', 'Something went wrong. Please try again');
        }
    }

    public function passwordResetOtp()
    {
        return view('backend.auth.password-reset-otp');
    }

    public function verifyPassResetOtp(Request $request)
    {
        if (isset($request->enc_otp))
        {
            if ($request->otp == base64_decode($request->enc_otp))
            {
                $user = User::where(['mobile' => $request->mobile])->first();
                $user->password = bcrypt($request->password);
                $user->save();
                if (str()->contains(url()->current(), '/api/'))
                {
                    return response()->json([
                        'status'    => 'success',
                        'message' => 'Password changed successfully.'
                    ]);
                }
                return redirect('/login')->with('success', 'Password Changed successfully.');
            } else {
                return ViewHelper::returEexceptionError('OTP mismatch. Please try again.');
//                return back()->with('error', 'OTP mismatch. Please try again.');
            }
        } else
        {
            return ViewHelper::returEexceptionError('Invalid Otp. Please try again.');
//            return back()->with('error', 'Invalid Otp. Please try again.');
        }
    }
}
