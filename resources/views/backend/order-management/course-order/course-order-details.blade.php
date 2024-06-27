<div class="row">
    <div class="col-md-4 mt-2">
        <span class="fw-bold">Order Number</span>
        <p>#{{ $courseOrder->order_invoice_number }}</p>
    </div>
    <div class="col-md-4 mt-2">
        <span class="fw-bold">Course Name</span>
        <p>{{ $courseOrder->course->title }}</p>
    </div>
    <div class="col-md-4 mt-2">
        <span class="fw-bold">Total Amount</span>
        <p>{{ $courseOrder->total_amount }}</p>
    </div>
    <div class="col-md-4 mt-2">
        <span class="fw-bold">Paid Amount</span>
        <p>{{ $courseOrder->paid_amount }}</p>
    </div>
    <div class="col-md-4 mt-2">
        <span class="fw-bold">Due Amount</span>
        <p>{{ $courseOrder->total_amount - $courseOrder->paid_amount }}</p>
    </div>
    <div class="col-md-4 mt-2">
        <span class="fw-bold">Used Coupon Code</span>
        <p>{{ $courseOrder->coupon_code }}</p>
    </div>
    <div class="col-md-4 mt-2">
        <span class="fw-bold">Used Coupon Amount</span>
        <p>{{ $courseOrder->coupon_amount }}</p>
    </div>
    <div class="col-md-4 mt-2">
        <span class="fw-bold">Payment Method</span>
        <p>{{ $courseOrder->payment_method }}</p>
    </div>
    <div class="col-md-4 mt-2">
        <span class="fw-bold">Paid From</span>
        <p>{{ $courseOrder->paid_from }}</p>
    </div>
    <div class="col-md-4 mt-2">
        <span class="fw-bold">Paid To</span>
        <p>{{ $courseOrder->paid_to }}</p>
    </div>
    <div class="col-md-4 mt-2">
        <span class="fw-bold">Vendor Name</span>
        <p>{{ $courseOrder->vendor }}</p>
    </div>
    <div class="col-md-4 mt-2">
        <span class="fw-bold">Transaction Id</span>
        <p>{{ $courseOrder->txt_id }}</p>
    </div>
    <div class="col-md-4 mt-2">
        <span class="fw-bold">Order Status</span>
        <p>
            <a href="javascript:void(0)" class="">{{ $courseOrder->status  }}</a>
{{--            <a href="javascript:void(0)" class="badge bg-primary">{{ $courseOrder->status == 1 ? 'Approved' : '' }}</a>--}}
{{--            <a href="javascript:void(0)" class="badge bg-primary">{{ $courseOrder->status == 2 ? 'Canceled' : '' }}</a>--}}
        </p>
    </div>
</div>
