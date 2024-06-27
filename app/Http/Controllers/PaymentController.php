<?php

namespace App\Http\Controllers;

use DGvai\SSLCommerz\SSLCommerz;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function order()
    {

        //  DO YOU ORDER SAVING PROCESS TO DB OR ANYTHING


        $sslc = new SSLCommerz();
        $sslc->amount(20)
            ->trxid('DEMOTRX123')
            ->product('Demo Product Name')
            ->customer('Customer Name','custemail@email.com');
        return $sslc->make_payment();

        /**
         *
         *  USE:  $sslc->make_payment(true) FOR CHECKOUT INTEGRATION
         *
         * */
    }

    public function success(Request $request)
    {
        $validate = SSLCommerz::validate_payment($request);
        if($validate)
        {
            return $request;
            return $bankID = $request->bank_tran_id;   //  KEEP THIS bank_tran_id FOR REFUNDING ISSUE

            //  Do the rest database saving works
            //  take a look at dd($request->all()) to see what you need

        }
    }

    public function failure(Request $request)
    {

        //  do the database works
        //  also same goes for cancel()
        //  for IPN() you can leave it untouched or can follow
        //  official documentation about IPN from SSLCommerz Panel

    }

    public function form()
    {
        return view('terms');
    }
}
