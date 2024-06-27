@extends('frontend.master')

@section('body')

    {{\Illuminate\Support\Facades\Session::put('course_redirect_url',\Illuminate\Support\Facades\Request::url())}}
    <div class="privacy-policy-area py-5">
        <div class="container">
            <div class="section-title text-center">
                <h2> প্রাইভেসি পলিসি </h2>
                <hr class="w-25 mx-auto bg-danger"/>
            </div>
            <div class="row p-t-20">
                <div class="col-lg-12">

                  <div class="card ab-shadow">
                      <div class="single-content py-3 pb-5 px-3 ">
                          <h3>প্রাইভেসি পলিসি ::</h3>
                          <p>At biddabari.com, accessible from <a href="https://biddabari.com">biddabari.com</a>, one of our main priorities is the privacy of our visitors. This Privacy Policy document contains types of information that is collected and recorded by biddabari.com and how we use it.</p>
                          <p>If you have additional questions or require more information about our Privacy Policy, do not hesitate to contact us.</p>
                          <p>This Privacy Policy applies only to our online activities and is valid for visitors to our website with regards to the information that they shared and/or collect in biddabari.com. This policy is not applicable to any information collected offline or via channels other than this website.</p>
                          <p>The personal information that you are asked to provide, and the reasons why you are asked to provide it, will be made clear to you at the point we ask you to provide your personal information.</p>
                          <p>If you contact us directly, we may receive additional information about you such as your name, email address, phone number, the contents of the message and/or attachments you may send us, and any other information you may choose to provide.</p>
                          <p>When you register for an Account, we may ask for your contact information, including items such as name, company name, address, email address, and telephone number.</p>
                      </div>
                  </div>

                </div>
            </div>
        </div>
    </div>

@endsection
