<div>
    <div class="row">
        <div class="col-md-12">
            <div class="float-end">
                <a href="" class="btn btn-outline-warning print-btn"><i class="fa-solid fa-print"></i></a>
            </div>
        </div>
    </div>
    <div class="" id="print-div">
        <div class="row mt-3">
            <div class="col-4">
                <span class="text-uppercase">Biling To:</span><br>
                <span><b> {{ $order->user->name }}</b></span><br>
                <span><b> {{ $order->mobile }}</b></span><br>
            </div>
            <div class="col-4 text-center">
                <img src="{{ asset('frontend/logo/biddabari-card-logo.jpg') }}" alt="" style="max-height: 80px" />
            </div>
            <div class="col-4 ">
                <div class="float-end">
                    <span class="text-uppercase text-primary f-s-20">Invoice</span><br>
                    <span class=""><b> Invoice No: {{ $order->order_invoice_number }}</b></span><br>
                    <span class=""><b> Date: {{ showDateFormatTwo($order->created_at) }}</b></span><br>
                </div>
            </div>
        </div>
        <table class="table table-bordered border-primary mt-4">
            <thead>
            <tr>
                <th>SL</th>
                <th>Item Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                @if($order->payment_method == 'ssl')
                    <th>Trans Info</th>
                @endif
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>1</td>
                <td>
                    {{ $order->ordered_for == 'course' ? $order->course->title : '' }}
                    {{ $order->ordered_for == 'product' ? $order->product->title : '' }}
                    {{ $order->ordered_for == 'batch_exam' ? $order->batchExam->title : '' }}
                </td>
                <td>
                    {{ $order->ordered_for == 'course' ? $order->course->price : '' }}
                    {{ $order->ordered_for == 'product' ? $order->product->price : '' }}
{{--                    {{ $order->ordered_for == 'batch_exam' ? $order->batchExam->batchExamSubscription->price : '' }}--}}
                    {{ $order->ordered_for == 'batch_exam' ? $order->total_amount : '' }}
                </td>
                <td>1</td>
                <td>
                    {{ $order->ordered_for == 'course' ? $order->course->price : '' }}
                    {{ $order->ordered_for == 'product' ? $order->product->price : '' }}
{{--                    {{ $order->ordered_for == 'batch_exam' ? $order->batchExam->batchExamSubscription->price : '' }}--}}
                    {{ $order->ordered_for == 'batch_exam' ? $order->total_amount : '' }}
                </td>
                @if($order->payment_method == 'ssl')
                    <td>
                        <span>Bank Trans Id: {{ $order->bank_tran_id }}</span> <br>
                        <span>Gateway Val Id: {{ $order->gateway_val_id }}</span> <br>
                        <span>Process Status: {{ $order->gateway_status }}</span> <br>
                    </td>
                @endif
            </tr>
            <tr>
                <td rowspan="4" colspan="3">Price</td>

                <td>Subtotal :</td>
                <td>
                    {{ $order->ordered_for == 'course' ? $order->course->price : '' }}
                    {{ $order->ordered_for == 'product' ? $order->product->price : '' }}
{{--                    {{ $order->ordered_for == 'batch_exam' ? $order->batchExam->batchExamSubscription->price : '' }}--}}
                    {{ $order->ordered_for == 'batch_exam' ? $order->total_amount : '' }}
                </td>
            </tr>
            <tr>
                <td>Discount</td>
                <td>
                    {{ $order->ordered_for == 'course' ? ($order->course->price - $order->total_amount) : '' }}
                    {{ $order->ordered_for == 'product' ? ($order->product->price - $order->total_amount) : '' }}
{{--                    {{ $order->ordered_for == 'batch_exam' ? ($order->batchExam->batchExamSubscription->price - $order->total_amount) : '' }}--}}
                    {{ $order->ordered_for == 'batch_exam' ? ($order->total_amount - $order->total_amount) : '' }}
                </td>
            </tr>
            <tr>
                <td>Grand total</td>
                <td>{{ $order->total_amount }}</td>
            </tr>
            <tr>
                <td>Paid</td>
                <td>{{ $order->paid_amount }}</td>
            </tr>
            <tr>
                <td colspan="3">Signature</td>

                <td>Due</td>
                <td>{{ $order->total_amount - $order->paid_amount }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
