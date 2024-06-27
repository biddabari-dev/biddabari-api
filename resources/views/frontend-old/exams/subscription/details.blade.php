@extends('frontend.master')

@section('body')

    <div class="courses-details-area pt-100 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-sm-7">
                    <div class="card card-body">
                        <div class="text-center">
                            <img style="max-height: 300px" src="{{ !empty($subscription->banner) ? asset($subscription->banner) : 'https://i.ibb.co/vjLMjf4/302781896-3331421830467947-4650783196296068552-n.jpg' }}" alt="exam-image-{{ $subscription->title }}" class="img-fluid" />
                        </div>
                        <div class="mt-3">
                            <h2>{{ $subscription->name }}</h2>
                            <div class=" mt-2 xm-details-row">
                                <div class="">
                                    <p>Price: {{ $subscription->price }}</p>
                                </div>
                                <div class="">
                                    <p>Valid From: {{ \Illuminate\Support\Carbon::parse($subscription->valid_form)->format('d-M-Y') }}</p>
                                </div>
                                <div class="">
                                    <p>Valid To: {{ \Illuminate\Support\Carbon::parse($subscription->valid_to)->format('d-M-Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="card card-body">
                        @if($subscriptionStatus == 'false')
                        <form action="{{ route('front.student.order-subscription', ['id' => $subscription->id]) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="total_amount" value="{{ $subscription->price }}" />
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
                                                @error('paid_to')<span class="text-danger">{{ $errors->first('paid_to') }}</span>@enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="paidForm">Paid Form</label>
                                                <input type="number" id="paidForm" required name="paid_form" class="form-control" placeholder="Paid Form" />
                                                @error('paid_form')<span class="text-danger">{{ $errors->first('paid_form') }}</span>@enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="transactionId">Transaction Id</label>
                                                <input type="text" id="transactionId" required name="txt_id" class="form-control" placeholder="Transaction Id" />
                                                @error('txt_id')<span class="text-danger">{{ $errors->first('txt_id') }}</span>@enderror
                                            </div>
                                            <div class="col-md-6 select2-div">
                                                <label for="vendor">Vendor</label>
                                                <select name="vendor" required id="vendor" class="form-control">
                                                    <option value="" selected disabled>Select a Vendor</option>
                                                    <option value="bkash">Bkash</option>
                                                    <option value="nagad">Nagad</option>
                                                    <option value="rocket">Rocket</option>
                                                </select>
                                                @error('vendor')<span class="text-danger">{{ $errors->first('vendor') }}</span>@enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="default-btn">Place Order</button>
                            </div>
                        </form>
                        @else
                        <div>
                            <p class="f-s-20 text-success">You already Purchased this Subscription Package.</p>
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
