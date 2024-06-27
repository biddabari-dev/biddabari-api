@extends('frontend.master')

@section('body')

{{--<div class="courses-area-two section-bg p-t-50" style="">--}}
{{--    <div class="container">--}}
{{--        <div class="row">--}}
{{--            <div class="col-lg-2">--}}
{{--            </div>--}}
{{--            <div class="col-lg-8 col-md-12">--}}
{{--                <div class="billing-sildbar pl-20  rounded-0">--}}
{{--                    <div class="billing-totals">--}}
{{--                        <h3 class="text-center py-3">Checkout Summary</h3>--}}
{{--                        <ul>--}}
{{--                            <li>Course Name : <span>{{ $course->title }}</span></li>--}}
{{--                            <li>Course Price <span>BDT {{ $reqFor == 'course' ? ($course->price ?? 0) : 0 }}</span></li>--}}
{{--                            <li id="couponLi" class="d-none">Coupon <span>BDT <b id="couponAmount"></b></span></li>--}}

{{--                            <form action="{{ route('front.place-course-order', ['course_id' => $course->id]) }}"--}}
{{--                                method="post" enctype="multipart/form-data">--}}
{{--                                @csrf--}}

{{--                                <input type="hidden" name="course_id" value="{{ $course->id }}">--}}
{{--                                <input type="hidden" name="total_amount" value="{{ $course->total_amount_after_discount ?? $course->price }}">--}}
{{--                                <input type="hidden" name="used_coupon" value="0">--}}
{{--                                <input type="hidden" name="coupon_code" value="">--}}
{{--                                <input type="hidden" name="coupon_amount" value="">--}}
{{--                                <input type="hidden" name="ordered_for" value="{{ $reqFor ?? 'course' }}">--}}
{{--                                <input type="hidden" name="rc" value="{{ $_GET['rc'] ?? '' }}">--}}

{{--                                <li>--}}
{{--                                    <div class="row checkout_log">--}}
{{--                                        <div class="col-md-6">--}}
{{--                                            <label for="paidTo">Student Name</label>--}}
{{--                                            <input type="text" id="paidTo" name="name" class="form-control"--}}
{{--                                                placeholder="Enter your name" />--}}
{{--                                            @error('paid_to')<span class="text-danger"></span>@enderror--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-6">--}}
{{--                                            <label for="paidForm" >Phone No</label>--}}
{{--                                            <input type="number" id="paidForm" name="mobile_no" class="form-control"--}}
{{--                                                placeholder="Enter your phone no" />--}}
{{--                                            @error('paid_from')<span class="text-danger"></span>@enderror--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </li>--}}


{{--                                <li>--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-md-6 checkout_coupon">--}}
{{--                                        <label for="couponCode" >Coupon Code</label>--}}

{{--                                            <div class="input-group">--}}
{{--                                                <input type="text" placeholder="Coupon Code" id="couponCode" class="form-control" />--}}
{{--                                                <label for="couponCode" class="input-group-text" id="checkBtn" style="cursor: pointer">Apply</label>--}}

{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-6 checkout_contact">--}}
{{--                                            <div class="contact-info-card">--}}
{{--                                                <i class="ri-phone-fill"></i>--}}
{{--                                                <h5>এজেন্ট এর সাথে কথা বলুন</h5>--}}
{{--                                                <p><a href="tel:+8801896060809">+8801896060809</a></p>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </li>--}}
{{--                                <li>--}}
{{--                                    <div class="bkash_payment d-flex justify-content-between">--}}

{{--                                        <div class="d-flex">--}}
{{--                                            <input type="radio" id="direct-bank-transfer" class="me-2" value="bkash"--}}
{{--                                                name="payment_method" checked>--}}
{{--                                            <label for="direct-bank-transfer">বিকাশ পেমেন্ট মেথড</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="pay_method_icon ">--}}
{{--                                            <img src="{{asset('frontend')}}/assets/images/bkash_logo.webp">--}}
{{--                                        </div>--}}

{{--                                    </div>--}}
{{--                                </li>--}}
{{--                                <li>--}}
{{--                                    <div class="others_payment d-flex justify-content-between">--}}
{{--                                        <div class="d-flex">--}}
{{--                                            <input type="radio" id="paypal" name="payment_method" class="me-2" value="ssl">--}}
{{--                                            <label for="paypal">অন্যান্য পেমেন্ট মেথড</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="pay_method_icon text-align-end">--}}
{{--                                            <img src="{{asset('frontend')}}/assets/images/others_logo.jpg">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </li>--}}

{{--                                <button type="submit" class="default-btn">পেমেন্ট করুন</button>--}}
{{--                            </form>--}}
{{--                        </ul>--}}
{{--                    </div>--}}

{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}



<div class="courses-area-two section-bg p-t-50" style="">
    <div class="container">
        <div class="row">
            <div class="col-lg-2">
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="billing-sildbar pl-20  rounded-0">
                    <div class="billing-totals">
                        <h3 class="text-center py-3">Checkout Summary</h3>
                        <ul>
                            <li>Course Name : <span>{{ $course->title }}</span></li>
                            <li>Course Price <span>BDT {{ $reqFor == 'course' ? ($course->total_amount_after_discount ?? $course->price) : 0 }}</span></li>
                            <li id="couponLi" class="d-none">Coupon <span>BDT <b id="couponAmount"></b></span></li>

                            <form action="{{ route('front.common-order', ['model_id' => $course->id]) }}"
                                  method="post" enctype="multipart/form-data" >
                                @csrf

                                <input type="hidden" name="model_id" value="{{ $course->id }}">
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                <input type="hidden" name="total_amount" value="{{ $course->total_amount_after_discount ?? $course->price }}">
                                <input type="hidden" name="used_coupon" value="0">
                                <input type="hidden" name="coupon_code" value="">
                                <input type="hidden" name="coupon_amount" value="">
                                <input type="hidden" name="ordered_for" value="{{ $reqFor ?? 'course' }}">
                                @if(!empty($batch_exam_subscription_id))
                                    <input type="hidden" name="batch_exam_subscription_id" value="{{ $batch_exam_subscription_id ?? '' }}">
                                @endif
                                <input type="hidden" name="rc" value="{{ $_GET['rc'] ?? '' }}">

                                <li>
                                    <div class="row checkout_log">
                                        <div class="col-md-12 ">
                                            <label for="paidTo">Your Name</label>
                                            <input type="text" id="paidTo" onkeydown="return /[a-zA-Z ]/i.test(event.key)" required name="name" class="form-control"
                                                   placeholder="Enter your name" value="{{ auth()->check() ? auth()->user()->name : '' }}" {{--{{ auth()->check() && !empty(auth()->user()->name) ? 'readonly' : '' }}--}}  />
                                            @if(!auth()->check()) <span class="text-danger f-s-18 float-start">আপনার এই নাম এ কোর্সটি রেজিস্টার করা হবে।</span> @endif
                                            @error('paid_to')<span class="text-danger"></span>@enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="phone" >Phone No</label>
                                            <input type="text" pattern="^01[3-9]\d{8}$" title="Please enter a valid phone number"  onkeypress="return isNumberKey(event)" id="phone" name="mobile" required class="form-control"
                                                   placeholder="Enter your phone no" value="{{ auth()->check() ? auth()->user()->mobile : '' }}" {{--{{ auth()->check() && !empty(auth()->user()->mobile) ? 'readonly' : '' }}--}} />
                                            @if(!auth()->check()) <span class="text-danger f-s-18 float-start">এই নাম্বারটি হবে আপনার রেজিস্ট্রেশন নম্বর ।</span> @endif
                                            @error('mobile')<span class="text-danger"></span>@enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="confirmPhone" >Confirm Phone No</label>
                                            <input type="text" format="" onkeypress="return isNumberKey(event)" id="confirmPhone" name="confirm_mobile" required class="form-control"
                                                   placeholder="Enter your phone no" value="{{ auth()->check() ? auth()->user()->mobile : '' }}" {{--{{ auth()->check() && !empty(auth()->user()->mobile) ? 'readonly' : '' }}--}} />
                                                   @if(Session::has('error'))
                                                   <span class="text-danger f-s-18 float-start">{{ Session::get('error') }}</span>
                                                    @endif
                                        </div>
                                    </div>
                                </li>


                                <li>
                                    <div class="row">
{{--                                        <div class="col-md-6 checkout_coupon">--}}
{{--                                            <label for="couponCode" >Coupon Code</label>--}}

{{--                                            <div class="input-group">--}}
{{--                                                <input type="text" placeholder="Coupon Code" id="couponCode" class="form-control" />--}}
{{--                                                <label for="couponCode" class="input-group-text" id="checkBtn" style="cursor: pointer">Apply</label>--}}

{{--                                            </div>--}}
{{--                                        </div>--}}
                                        <div class="col-md-6 checkout_contact">
                                            <div class="contact-info-card">
                                                <i class="ri-phone-fill"></i>
                                                <h5>প্রয়োজনে এজেন্ট এর সাথে কথা বলুন</h5>
                                                <p><a href="tel:+8801896060800">+8801896060800</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="bkash_payment d-flex justify-content-between">

                                        <div class="d-flex">
                                            <input type="radio" id="direct-bank-transfer" class="me-2" value="bkash"
                                                   name="payment_method" checked>
                                            <label for="direct-bank-transfer">বিকাশ পেমেন্ট মেথড</label>
                                        </div>
                                        <div class="pay_method_icon ">
                                            <img src="{{asset('frontend')}}/assets/images/bkash_logo.webp" style="height: 45px; width: 120px">
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="others_payment d-flex justify-content-between">
                                        <div class="d-flex">
                                            <input type="radio" id="paypal" name="payment_method" class="me-2" value="ssl"  />
                                            <label for="paypal">অন্যান্য পেমেন্ট মেথড</label>
                                        </div>
                                        <div class="pay_method_icon text-align-end">
                                            <img src="{{asset('frontend')}}/assets/images/others_logo.jpg" style="height: 45px; width: 120px">
                                        </div>
                                    </div>
                                </li>

                                <button type="submit" class="default-btn w-100 bg-danger">পেমেন্ট করুন</button>
                            </form>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>




@endsection

@section('js')
{{--<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />--}}
{{--<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>--}}
<script>
    // $(function () {
    //     $('.select2').select2();
    // })
    $(document).on('click', '#checkBtn', function () {
        var couponCode = $('#couponCode').val();
        var courseId = $('input[name="course_id"]').val();
        var currentTotal = $('input[name="total_amount"]').val();
        $.ajax({
            url: "{{ route('front.check-coupon') }}",
            method: "GET",
            data: { coupon_code: couponCode, course_id: courseId, current_total: currentTotal },
            success: function (data) {
                console.log(data);
                if (data.status == 'true') {
                    toastr.success(data.message);
                    // $('input[name="total_amount"]').val(data.currentTotal);
                    // $('input[name="used_coupon"]').val(1);
                    $('input[name="coupon_code"]').val(couponCode);
                    $('input[name="coupon_amount"]').val(data.coupon.discount_amount);
                    $('#finalPrice').text(data.currentTotal);
                    $('#couponAmount').text(data.coupon.discount_amount);
                    $('#couponLi').removeClass('d-none');
                } else if (data.status == 'false') {
                    toastr.error(data.message);
                }
            }
        })
    })
</script>
{{--<script>--}}
{{--    $(function () {--}}
{{--        showHidePaymentMethod();--}}
{{--    })--}}
{{--    $(document).on('click', 'input[name="payment_method"]', function () {--}}
{{--        // showHidePaymentMethod();--}}
{{--    });--}}
{{--    function showHidePaymentMethod() {--}}
{{--        var paymentMethod = $('input[name="payment_method"]:checked').val();--}}
{{--        if (paymentMethod == 'cod') {--}}
{{--            if ($('.payment-cod').hasClass('d-none')) {--}}
{{--                $('.payment-cod').removeClass('d-none');--}}
{{--            }--}}

{{--        } else if (paymentMethod == 'ssl') {--}}
{{--            $('.payment-cod').addClass('d-none');--}}
{{--        }--}}
{{--    }--}}
{{--</script>--}}

<script>

</script>

<script>
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
        }
</script>


<script>
    window.onload = () => {
        const myInput = document.getElementById('confirmPhone');
        myInput.onpaste = e => e.preventDefault();
    }
</script>
@endsection
