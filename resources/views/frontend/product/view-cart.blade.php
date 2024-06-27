@extends('frontend.master')

@section('body')
    <section class="cart-wraps-area pt-100 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <form>
                        <div class="cart-wraps">
                            <div class="cart-table table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Products</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Unit Price</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($cartContents as $cartContent)
                                        <tr>
                                            <td class="courses-thumbnail">
                                                <a href="javascript:void(0)">
                                                    <img src="{{ asset($cartContent->attributes->image ?? 'frontend/logo/biddabari-card-logo.jpg') }}" alt="Image" style="height: 100px;">
                                                </a>
                                            </td>
                                            <td class="courses-name">
                                                <a href="javascript:void(0)">{{ $cartContent->name }}</a>
                                            </td>
                                            <td class="courses-price">
                                                <span class="unit-amount">{{ $cartContent->price }}</span>
                                            </td>
                                            <td class="courses-subtotal">
                                                <span class="subtotal-amount">{{ $cartContent->quantity * $cartContent->price }}</span>
                                                <a href="{{ route('front.remove-from-cart', ['id' => $cartContent->id]) }}" class="remove">
                                                    <i class="ri-delete-bin-6-line"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4">
                                                    <p class="text-center f-s-22">No Items Ordered Yet.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="card card-body border-0">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="">
                                            <label for="">Shipping Address</label>
                                            <div>
                                                <textarea name="shipping_address" class="form-control" id="shippingInputField" cols="30" rows="5"></textarea>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <label for="">Notes</label>
                                            <div>
                                                <textarea name="notes" class="form-control" id="notesInputField" cols="30" rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cart-buttons">
                                <div class="row align-items-center">
                                    <div class="col-lg-7 col-md-7">
                                        <div class="continue-shopping-box">
                                            <a href="{{ route('front.all-products') }}" class="default-btn">
                                                Add More Products
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-5 text-end">
{{--                                        <a href="" class=" default-btn">--}}
{{--                                            Update Cart--}}
{{--                                        </a>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-5">
                    <div class="cart-totals" style="padding: 40px 15px">
                        <h3>Order Summary</h3>
                        <ul>
                            <li>Subtotal <span>৳ {{ $subTotal }}</span></li>
{{--                            <li>Coupon <span>$20.00</span></li>--}}
                            <li>Delivery Charge <span><b>৳ {{ $deliveryCharge->fee ?? 0 }}</b></span></li>
                            <li>Total <span><b>৳ {{ $total + $deliveryCharge->fee ?? 0 }}</b></span></li>
                        </ul>
                        <form action="{{ route('front.place-product-order') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="used_coupon" value="0">
                            <input type="hidden" name="coupon_code" value="">
                            <input type="hidden" name="coupon_amount" value="">
                            <input type="hidden" name="ordered_for" value="product">
                            <input type="hidden" name="delivery_charge" value="{{ $deliveryCharge->fee ?? 0 }}">
                            <textarea name="shipping_address" class="form-control d-none" id="shippingAddress" cols="30" rows="5"></textarea>
                            <textarea name="notes" class="form-control d-none" id="notes" cols="30" rows="5"></textarea>
                            <div class="payment-box" style="box-shadow: none; padding: 40px 5px">
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
                                        <p class="f-s-22 py-0 mb-0">ম্যানুয়াল পেমেন্ট করলে আমাদের <span>বিকাশ মার্চেন্ট</span> নাম্বারে টাকা পাঠাতে হবে। <br><span>01896 060888</span></p>
                                        <p class="f-s-22 py-0 mb-0">রকেট এ পাঠাতে চাইলে <span>রকেট মার্চেন্ট</span> পাঠাতে হবে। <br><span>01963 929208</span></p>
                                        <p class="f-s-22 py-0 mb-0">নগদ এ পাঠাতে চাইলে <span>নগদ মার্চেন্ট</span> নাম্বারে টাকা পাঠাতে হবে। <br><span>01896 060828</span></p>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="paidTo" class="f-s-20">Paid To</label>
                                                <input type="text" id="paidTo"  name="paid_to" class="form-control" placeholder="Paid To" />
                                                @error('paid_to')<span class="text-danger">{{ $errors->first('paid_to') }}</span>@enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="paidForm" class="f-s-20">Paid Form</label>
                                                <input type="text" id="paidForm"  name="paid_from" class="form-control" placeholder="Paid Form" />
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
                                                    <option value="" selected disabled>Select a payment method</option>
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
                                <button type="submit" class="default-btn">Place Order</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('js')

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

        $(document).on('keyup', '#shippingInputField', function () {
            var inputedValue = $(this).val();
            $('#shippingAddress').text(inputedValue);
        })
        $(document).on('keyup', '#notesInputField', function () {
            var inputedValue = $(this).val();
            $('#notes').text(inputedValue);
        })
    </script>
@endsection
