<?php

namespace App\helper;

class BkashPayment
{

    public $baseUrl;
    public function requestPayment($data)
    {
        $tokendata=$this->gettoken();

        $successdata=$this->createPayment($data);

        return $successdata;
    }

    public function executePayment($payment_id)
    {
        $pay= $this->checkExecute($payment_id);

        return $pay;
    }
    public function queryPayment($payment_id)
    {
        $result= $this->checkquery($payment_id);
        return $result;
    }

    public function searchPayment($trxid)
    {
        return $this->findpayment($trxid);

    }

    private function findpayment($trxid)
    {
        $token=session()->get('bkash_token');
//        return $token;
        if (!isset($token)){
            $this->gettoken();
            $token=session()->get('bkash_token');
        }
        $requestbody = array(
            'trxID' => $trxid
        );

        $requestbody_json = json_encode($requestbody);

        $url=curl_init($this->getbaseUrl().'/checkout/general/searchTransaction');
        $app_key=config('bkashpay.bkash_app_key');
        $header=array(
            'Content-Type:application/json',
            'authorization:'.$token,
            'x-app-key:'.$app_key
        );

        curl_setopt($url,CURLOPT_HTTPHEADER, $header);
        curl_setopt($url,CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $requestbody_json);
        curl_setopt($url,CURLOPT_FOLLOWLOCATION, 1);
        $resultdatax=curl_exec($url);
        curl_close($url);

        $response = json_decode($resultdatax);

        return $response;
    }
    private function checkquery($payment)
    {
        $token=session()->get('bkash_token');
        $post_token = array(
            'paymentID' => $payment
        );

        $post_token_json=json_encode($post_token);

        $url=curl_init($this->getbaseUrl().'/checkout/payment/status');
        $app_key=config('bkashpay.bkash_app_key');
        $header=array(
            'Content-Type:application/json',
            'authorization:'.$token,
            'x-app-key:'.$app_key
        );

        curl_setopt($url,CURLOPT_HTTPHEADER, $header);
        curl_setopt($url,CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $post_token_json);
        curl_setopt($url,CURLOPT_FOLLOWLOCATION, 1);
        $resultdata=curl_exec($url);
        curl_close($url);
//        echo $resultdata;
        $response = json_decode($resultdata,true);

        return $response;
    }

    private function checkExecute($payment)
    {
        $token=session()->get('bkash_token');
        if (!isset($token)){
            $this->gettoken();
            $token=session()->get('bkash_token');
        }

        $post_token = array(
            'paymentID' => $payment
        );

        $url = curl_init($this->getbaseUrl().'/checkout/execute');
        $posttoken_json = json_encode($post_token);

        $app_key=config('bkashpay.bkash_app_key');
        $header = array(
            'Content-Type:application/json',
            'Authorization:' . $token,
            'X-APP-Key:'.$app_key
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $posttoken_json);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $resultdata = curl_exec($url);

        curl_close($url);

        $response = json_decode($resultdata,true);

        return $response;
    }

    public function getbaseUrl()
    {
        if (config('bkashpay.sandbox') == true){
            return $this->baseUrl='https://tokenized.sandbox.bka.sh/v1.2.0-beta/tokenized';
        }else{
            return  $this->baseUrl='https://tokenized.pay.bka.sh/v1.2.0-beta/tokenized';
        }

    }

    public function gettoken()
    {
        session()->forget('bkash_token');
        session()->forget('bkash_token_type');
        session()->forget('bkash_refresh_token');

        $post_token = array(
            'app_key' => config("bkashpay.bkash_app_key"),
            'app_secret' => config("bkashpay.bkash_app_secret"),
            'refresh_token' => null,
        );

        $url =curl_init($this->getbaseUrl().'/checkout/token/grant');

        $post_token_json = json_encode($post_token);
        $username = config("bkashpay.bkash_username");
        $password = config("bkashpay.bkash_password");

        $header = array(
            'Content-Type:application/json',
            "username: $username",
            "password:$password"
        );
        curl_setopt($url,CURLOPT_HTTPHEADER, $header);
        curl_setopt($url,CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url,CURLOPT_POSTFIELDS, $post_token_json);
        curl_setopt($url,CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $resultdata = curl_exec($url);
        curl_close($url);

        $response=json_decode($resultdata,true);

        if (isset($response['id_token']) && isset($response['token_type']) && isset($response['refresh_token'])){
            session()->put('bkash_token', $response['id_token']);
            session()->put('bkash_token_type', $response['token_type']);
            session()->put('bkash_refresh_token', $response['refresh_token']);
        }
        return $response;
    }

    public function createPayment($data_json)
    {
        $token=session()->get('bkash_token');
        $calbackurl=config('bkashpay.callbackURL');

        $url = curl_init($this->getbaseUrl().'/checkout/create');

        $app_key=config('bkashpay.bkash_app_key');

        $header = array(
            'Content-Type:application/json',
            'Authorization:' . $token,
            'X-APP-Key:'.$app_key
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $resultdata = curl_exec($url);
        curl_close($url);
        $response=json_decode($resultdata,true);


        return $response;
    }
}
