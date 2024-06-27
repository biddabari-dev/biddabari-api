@extends('frontend.master')

@section('body')

    {{\Illuminate\Support\Facades\Session::put('course_redirect_url',\Illuminate\Support\Facades\Request::url())}}

    <div class="terms-conditions-area pt-100 pb-70">
        <div class="container">
            <div class="section-title text-center">
                <h2>Terms & Conditions</h2>
                <hr class="w-25 mx-auto bg-danger"/>
            </div>
            <div class="row p-t-20">
                <div class="col-lg-12">
                    <div class="card ab-shadow">
                        <div class="single-content py-3 pb-5 px-3 ">
                            <h3>নীতিমালা ::</h3>
                            <p>Create a custom Terms & Conditions agreement to comply with the law and the requirements of third-parties. Use the Terms & Conditions agreement for: Websites, Apps (iOS, Android), E-commerce, SaaS, Facebook and many more.</p>
                            <p>Free hosting page. Download the Terms and Conditions as HTML, DOCX, Plain Text, Markdown. Edit as you wish. Update anytime.</p>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row p-t-20">
                <div class="col-lg-12">
                    <div class="card ab-shadow">
                        <div class="single-content py-3 pb-5 px-3 ">
                            <h3>রিফান্ড নীতিমালা ::</h3>
                            <p>Course fee is refundable if the course you purchased is not available to you or you bought this course by mistaken. Only then your request will be considered within 3 days of your purchase of the course, that Biddabari will credit/ refund your account. A refund request will be finalized valid only if made through an email to biddabari4bcs@gmail.com specifying your email address or phone number used during registration within 3 days from the time of purchase.</p>
                            <p>No refund request will be considered valid after 3 days of purchase. Refunds shall be made to the bank, mobile financial services account, or card with which the purchase was made within 10 working days of the refund request being successfully processed and approved by biddabari. This confirmation will be sent to the user by email.</p>
                            <p>We reserve the right to apply for a credit or a refund, at our discretion, depending on the capabilities of our payment processing partners or the platform from which you purchased your course (website or mobile app).</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
