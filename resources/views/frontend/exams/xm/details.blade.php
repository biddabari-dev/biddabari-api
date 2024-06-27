@extends('frontend.master')

@section('body')
    <div class="courses-details-area pt-100 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <div class="card card-body">
                        <div class="text-center">
                            <img style="max-height: 400px" src="{{ !empty($exam->image) ? asset($exam->image) : 'https://i.ibb.co/vjLMjf4/302781896-3331421830467947-4650783196296068552-n.jpg' }}" alt="exam-image-{{ $exam->title }}" class="img-fluid" />
                        </div>
                        <div class="mt-3">
                            <h2>{{ $exam->title }}</h2>
                            <div class="row mt-2 xm-details-row">
                                <div class="col-md-6">
                                    <p>Exam Type: {{ $exam->xm_type }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p>Exam Date: {{ $exam->xm_date }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p>Exam Start Time: {{ $exam->xm_start_time }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p>Exam End Time: {{ $exam->xm_end_time }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p>Exam Duration: {{ $exam->xm_duration }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p>Exam Payment Type: {{ $exam->is_paid == 1 ? 'Paid' : 'Free' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p>Exam Total Mark: {{ $exam->total_mark }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p>Exam Pass Mark: {{ $exam->xm_pass_mark }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card card-body">
                        @if($enrollStatus == 'false')
                            <form action="{{ route('front.student.order-exam', ['xm_id' => $exam->id]) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="total_amount" value="{{ $exam->price }}" />
                                <div class="payment-box">
                                    <div class="payment-method">
                                        <h3>Payment Method</h3>
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
                                        <div class="payment-cod d-none xm-payment-div">
                                            <p>ম্যানুয়াল পেমেন্ট করলে আমাদের <span>বিকাশ মার্চেন্ট</span> নাম্বারে টাকা পাঠাতে হবে। <br><span>01896 060888</span></p>
                                            <p>রকেট এ পাঠাতে চাইলে <span>রকেট মার্চেন্ট</span> পাঠাতে হবে। <br><span>01963 929208</span></p>
                                            <p>নগদ এ পাঠাতে চাইলে <span>নগদ মার্চেন্ট</span> নাম্বারে টাকা পাঠাতে হবে। <br><span>01896 060828</span></p>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="paidTo">Paid To</label>
                                                    <input type="number" id="paidTo" required name="paid_to" class="form-control" placeholder="Paid To" />
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="paidForm">Paid Form</label>
                                                    <input type="number" id="paidForm" required name="paid_form" class="form-control" placeholder="Paid Form" />
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="transactionId">Transaction Id</label>
                                                    <input type="text" id="transactionId" required name="txt_id" class="form-control" placeholder="Transaction Id" />
                                                </div>
                                                <div class="col-md-6 select2-div">
                                                    <label for="vendor">Vendor</label>
                                                    <select name="vendor" required id="vendor" class="form-control">
                                                        <option value="" selected disabled>Select a Vendor</option>
                                                        <option value="bkash">Bkash</option>
                                                        <option value="nagad">Nagad</option>
                                                        <option value="rocket">Rocket</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="default-btn">Place Order</button>
                                </div>
                            </form>
                        @else
                            <div class="rating ">
                                <a href="{{ route('front.student.start-exam', ['xm_id' => $exam->id, 'slug' => $exam->slug]) }}" class="btn btn-outline-primary w-100 f-s-20">পরীক্ষা দিন</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .xm-details-row p{
            font-size: 25px!important;
        }
        .xm-payment-div p{
            font-size: 20px!important;
        }
    </style>
@endpush

@section('js')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(function () {
            $('.select2').select2();
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
