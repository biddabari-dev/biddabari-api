@extends('frontend.student-master')

@section('student-body')
    <section class="py-5">
        <div class="">
            <div class="row custom_col_12">
                <div class="section-title text-center">
                    <h2>  আমার অর্ডার সমূহ</h2>
                    <hr class="w-25 mx-auto bg-danger"/>
                </div>
                <div class="col-lg-12 col-md-6">
                    <div class="courses-item pt-5">
                        <div class="content">


                            <div class="custom_tab_pan_li">
                                <ul class="nav nav-pills mb-3 text-center" id="pills-tab" role="tablist" style="margin-left: 30%">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active f-s-22" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-all" type="button" role="tab" aria-controls="pills-home" aria-selected="true">All</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link f-s-22" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-course" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Course</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link f-s-22" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-batch-exam" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Batch Exam</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link f-s-22" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-product" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Product</button>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content overflow-scroll" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-home-tab">
                                    <table class="table table-striped table-bordered table-hover">
                                        <tr>
                                            <th>sl</th>
                                            <th>Order No</th>
                                            <th>Item Name</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                        </tr>
                                        @foreach($orders as $order)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>#{{ $order->order_invoice_number }}</td>
                                                @if($order->ordered_for == 'course')
                                                    <td class="custome_td">{{ $order->course->title }}</td>
                                                @elseif($order->ordered_for == 'batch_exam')
                                                    <td class="custome_td">{{ $order->batchExam->title }}</td>
                                                @else
                                                    <td class="custome_td">{{ $order->product->title }}</td>
                                                @endif
                                                    <td>{{ $order->total_amount }}</td>
                                                <td>
                                                    {{ $order->status }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="tab-pane fade " id="pills-course" role="tabpanel" aria-labelledby="pills-home-tab">
                                    <table class="table table-striped table-bordered table-hover">
                                        <tr>
                                            <th>sl</th>
                                            <th>Order No</th>
                                            <th>Item Name</th>
                                            <th>Price</th>
                                            <th>Partial Payment</th>
                                            <th>Status</th>
                                        </tr>
                                        @foreach($orders as $order)
                                            @if($order->ordered_for == 'course')
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>#{{ $order->order_invoice_number }}</td>
                                                    <td class="custome_td">{{ $order->course->title }}</td>
                                                    <td>{{ $order->total_amount }}</td>
                                                    <td>{{ $order->total_amount > $order->paid_amount ?  $order->paid_amount : $order->total_amount }}</td>
                                                    <td>
                                                        {{ $order->status }}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="pills-batch-exam" role="tabpanel" aria-labelledby="pills-profile-tab">
                                    <table class="table table-striped table-bordered table-hover">
                                        <tr>
                                            <th>sl</th>
                                            <th>Order No</th>
                                            <th>Item Name</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                        </tr>
                                        @foreach($orders as $order)
                                            @if($order->ordered_for == 'batch_exam')
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>#{{ $order->order_invoice_number }}</td>
                                                    <td class="custome_td">{{ $order->batchExam->title }}</td>
                                                    <td>{{ $order->total_amount }}</td>
                                                    <td>
                                                        {{ $order->status }}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="pills-product" role="tabpanel" aria-labelledby="pills-contact-tab">
                                    <table class="table table-striped table-bordered table-hover">
                                        <tr>
                                            <th>sl</th>
                                            <th>Order No</th>
                                            <th>Item Name</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                        </tr>
                                        @foreach($orders as $order)
                                            @if($order->ordered_for == 'product')
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>#{{ $order->order_invoice_number }}</td>
                                                    <td class="custome_td">{{ $order->product->title }}</td>
                                                    <td>{{ $order->total_amount }}</td>
                                                    <td>
                                                        {{ $order->status }}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
