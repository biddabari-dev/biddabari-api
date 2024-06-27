@extends('frontend.master')

@section('body')

    <div class="courses-area-two section-bg p-t-50" style="">
        <div class="container">
            <!--        <div class="section-title text-center mb-45">-->
            <!--            &lt;!&ndash;   <span>কোর্স সমূহ</span>&ndash;&gt;-->
            <!--&lt;!&ndash;            <h2> সকল নোটিশ  সমূহ</h2>&ndash;&gt;-->
            <!--            <hr class="w-25 mx-auto bg-danger"/>-->
            <!--        </div>-->
            <div class="row">
                <div class="col-lg-7 col-md-12">
                    <div class="courses-item content-shadow rounded-0">
                        <div class="content ">
                            <h3 class="p-t-20 text-center"><a href="{{ route('front.course-details', ['slug' => $course->slug, 'id' => $course->id]) }}">{{ $course->title }}</a></h3>
                            <ul class="course-list">
                                <li><i class="ri-time-fill"></i> {{ $course->total_hours ?? 0 }} hr</li>
                                <li><i class="ri-vidicon-fill"></i> {{ $course->total_class ?? 0 }} lectures</li>
                                <li><i class="ri-file-pdf-line"></i> {{ $course->total_pdf ?? 0 }} PDF</li>
                                <li><i class="ri-a-b"></i> {{ $course->total_exam ?? 0 }} Exam</li>
                                <li><i class="ri-store-3-line"></i>{{ $course->total_live ?? 0 }} live class</li>
                            </ul>
{{--                            <div class="courses-details-into">--}}
{{--                                <h3>Description</h3>--}}
{{--                                <p>{!! $course->description !!}</p>--}}
{{--                            </div>--}}
                        </div>
                    </div>


                </div>
                <div class="col-lg-5 col-md-6">
                    <div class="billing-sildbar pl-20 content-shadow rounded-0">
                        <div class="billing-totals">
                            <h3>Checkout Summary</h3>
                            <ul>
                                <li>Total <span>BDT {{ $course->price ?? 0 }}</span></li>
                                <li id="couponLi" class="d-none">Coupon <span>BDT <b id="couponAmount"></b></span></li>
                                <li>Discount <span>BDT <b>{{ $discountAmount = $discountStatus == 'valid' ? (($course->discount_type == 1 ? $course->discount_amount : ($course->price * $course->discount_amount)/100)) : 0 }}</b></span></li>
                                <li>Payable Total <span>BDT <b id="finalPrice">{{ $totalAmount = $course->price - (isset($discountAmount) ? $discountAmount : 0) }}</b></span></li>
                                <li>
                                    <div class="input-group">
                                        <input type="text" placeholder="Coupon Code" id="couponCode" class="form-control" />
                                        <label for="couponCode" class="input-group-text" id="checkBtn" style="cursor: pointer">Apply</label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <form action="{{ route('front.place-course-order', ['course_id' => $course->id]) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                            <input type="hidden" name="total_amount" value="{{ $totalAmount }}">
                            <input type="hidden" name="used_coupon" value="0">
                            <input type="hidden" name="coupon_code" value="">
                            <input type="hidden" name="coupon_amount" value="">
                            <input type="hidden" name="ordered_for" value="course">
                            <input type="hidden" name="rc" value="{{ $_GET['rc'] ?? '' }}">
                            <div class="payment-box">
                                <div class="payment-method">
                                    <h3 class="f-s-26">Payment Method</h3>
                                    <p>
                                        <input type="radio" id="paypal" name="payment_method" value="ssl">
                                        <label for="paypal">SSLCommerz</label>
                                    </p>
                                    <p>
                                        <input type="radio" id="direct-bank-transfer" value="cod" name="payment_method" checked>
                                        <label for="direct-bank-transfer">Manual Payment</label>
                                    </p>
                                </div>
                                <div class="payment-des-parent-div">
                                    <div class="payment-cod d-none">
                                        <p class="f-s-22 py-0 mb-0">ম্যানুয়াল পেমেন্ট করলে আমাদের <span>বিকাশ মার্চেন্ট</span> নাম্বারে টাকা পাঠাতে হবে। <br><span>01896 060888 </span></p>
                                        <p class="f-s-22 py-0 mb-0">রকেট এ পাঠাতে চাইলে <span>রকেট মার্চেন্ট</span> পাঠাতে হবে। <br><span>01963 929208</span></p>
                                        <p class="f-s-22 py-0 mb-0">নগদ এ পাঠাতে চাইলে <span>নগদ মার্চেন্ট</span> নাম্বারে টাকা পাঠাতে হবে। <br><span>01896 060828</span></p>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="paidTo" class="f-s-20">Paid To</label>
                                                <input type="number" id="paidTo"  name="paid_to" class="form-control" placeholder="Paid To" />
                                                @error('paid_to')<span class="text-danger">{{ $errors->first('paid_to') }}</span>@enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="paidForm" class="f-s-20">Paid Form</label>
                                                <input type="number" id="paidForm"  name="paid_from" class="form-control" placeholder="Paid Form" />
                                                @error('paid_from')<span class="text-danger">{{ $errors->first('paid_from') }}</span>@enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="transactionId" class="f-s-20">Transaction Id</label>
                                                <input type="text" id="transactionId"  name="txt_id" class="form-control" placeholder="Transaction Id" />
                                                @error('txt_id')<span class="text-danger">{{ $errors->first('txt_id') }}</span>@enderror
                                            </div>
                                            <div class="col-md-6 select2-div">
                                                <label for="vendor" class="f-s-20">Payment Method</label>
                                                <select name="vendor"  id="vendor" class="form-control">
                                                    <option value="" selected disabled>Select payment method</option>
                                                    <option value="bkash">Bkash</option>
                                                    <option value="nagad">Nagad</option>
                                                    <option value="rocket">Rocket</option>
                                                </select>
                                                @error('vendor')<span class="text-danger">{{ $errors->first('vendor') }}</span>@enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
{{--                                <a href="cart.html" class="default-btn">--}}
{{--                                    Place to Order--}}
{{--                                </a>--}}
                                <button type="submit" class="default-btn">Place to Order</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(function () {
            $('.select2').select2();
        })
        $(document).on('click', '#checkBtn', function () {
            var couponCode = $('#couponCode').val();
            var courseId = $('input[name="course_id"]').val();
            var currentTotal = $('input[name="total_amount"]').val();
            $.ajax({
                url: "{{ route('front.check-coupon') }}",
                method: "GET",
                data: {coupon_code:couponCode, course_id: courseId, current_total:currentTotal},
                success: function (data) {
                    console.log(data);
                    if (data.status == 'true')
                    {
                        toastr.success(data.message);
                        // $('input[name="total_amount"]').val(data.currentTotal);
                        // $('input[name="used_coupon"]').val(1);
                        $('input[name="coupon_code"]').val(couponCode);
                        $('input[name="coupon_amount"]').val(data.coupon.discount_amount);
                        $('#finalPrice').text(data.currentTotal);
                        $('#couponAmount').text(data.coupon.discount_amount);
                        $('#couponLi').removeClass('d-none');
                    } else if (data.status == 'false')
                    {
                        toastr.error(data.message);
                    }
                }
            })
        })
    </script>
    <script>
        $(function () {
            showHidePaymentMethod();
        })
        $(document).on('click', 'input[name="payment_method"]', function () {
            showHidePaymentMethod();
        });
        function showHidePaymentMethod() {
            var paymentMethod = $('input[name="payment_method"]:checked').val();
            if (paymentMethod == 'cod')
            {
                if ($('.payment-cod').hasClass('d-none'))
                {
                    $('.payment-cod').removeClass('d-none');
                }

            } else if (paymentMethod == 'ssl')
            {
                $('.payment-cod').addClass('d-none');
            }
        }
    </script>
@endsection
