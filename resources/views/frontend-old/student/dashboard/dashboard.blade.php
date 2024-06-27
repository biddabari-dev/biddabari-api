@extends('frontend.student-master')

@section('student-body')
    <section class="py-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title text-center">
                        <h2> ড্যাশবোর্ড </h2>
                        <hr class="w-25 mx-auto bg-danger"/>
                    </div>
                    <div class="mt-3 row stu_das_mobile_res">
                        <div class="col-md-3">
                            <div class="card card-body text-center">
                                <h3 class="f-s-30">কোর্স সমূহ</h3>
                                <span class="f-s-50">{{ $totalEnrolledCourse }}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-body text-center">
                                <h3 class="f-s-30">পরীক্ষা সমূহ</h3>
                                <span class="f-s-50">{{ $totalEnrolledExams }}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-body text-center">
                                <h3 class="f-s-30">প্রোডাক্ট সমূহ</h3>
                                <span class="f-s-50">{{ $totalPurchasedProducts }}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-body text-center">
                                <h3 class="f-s-30">পেন্ডিং অর্ডার</h3>
                                <span class="f-s-50">{{ $totalPendingOrders }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 row">
                        <div class="col-md-12">
                            <div class="card  course_exam_mobile_res">
                                <div class="card-header">
                                    <h3 class="text-center f-s-32">Enrolled Courses & Exams</h3>
                                </div>
                                <div class="card-body overflow-scroll">
                                    <table class="table table-striped f-s-22">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Type</th>
                                                <th>Price</th>
                                                <th>Paid Amount</th>
                                                <th>Due</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orders as $order)
                                                @if($order->ordered_for != 'product')
                                                    <tr>
                                                        <td class="custome_td">
                                                            {{ $order->ordered_for == 'course' ? $order->course->title : '' }}
                                                            {{ $order->ordered_for == 'batch_exam' ? $order->batchExam->title : '' }}
                                                        </td>
                                                        <td>
                                                            {{ $order->ordered_for == 'course' ? 'Course' : '' }}
                                                            {{ $order->ordered_for == 'batch_exam' ? "Exam" : '' }}
                                                        </td>
                                                        <td>{{ $order->total_amount }}</td>
                                                        <td>{{ $order->paid_amount }}</td>
                                                        <td>{{ $order->total_amount - $order->paid_amount }}</td>
                                                        <td>{{ $order->status }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
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
