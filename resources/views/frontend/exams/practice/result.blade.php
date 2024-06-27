@extends('frontend.master')

@section('body')
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-10 mx-auto">
                    <div class="card">
                        <div class="card-body align-items-center" >
                            <div class="float-start">
                                <div>
                                    <h2 class="text-secondary">{{ $exam->title }}</h2>
                                    <span class="fw-bold f-s-26">Biddabari</span>
                                </div>
                                <div class="">
                                    <div class="float-start">
                                        <span class="text-primary f-s-22">Question: </span><small class="f-s-22">{{ count($exam->questionStores) }}</small>
                                    </div>
                                    <div class="float-start ms-3">
                                        <span class="text-primary f-s-22">Pass Mark: </span><small class="f-s-22">{{ $exam->xm_pass_mark }}</small>
                                    </div>
                                    <div class="float-start ms-3">
                                        <span class="text-primary f-s-22">Total Mark: </span><small class="f-s-22">{{ $exam->total_mark }}</small>
                                    </div>
                                </div>
                            </div>
                            @if($exam->xm_type == 'MCQ')
                            <div class="float-end text-center mt-3">
                                <div class="me-4">
                                    <strong class="fw-bold" style="font-size: 25px">{{ $examResult->result_mark }}</strong> <br>
                                    <span>({{ $examResult->status == 'pass' ? 'Pass' : 'Failed' }})</span>
                                </div>
                            </div>
                                @endif
                        </div>
                        <div class="card-body mt-3">
                            @if($exam->xm_type == 'MCQ')
                                <div class="row">
                                    <div class="col-md-12">
                                        @if($examResult->status == 'fail')
                                        <div class="fail-div">
                                            <div class="text-center">
                                                <img src="{{ asset('/') }}backend/assets/images/xm-ressult/feeling.png" alt="" class="img-fluid" style="height: 500px" />
                                                <h3 class="text-primary">Sorry.... You failed in the exam</h3>
                                            </div>
                                        </div>
                                        @elseif($examResult->status == 'pass')
                                        <div class="win-div">
                                            <div class="text-center">
    {{--                                            <img src="{{ asset('/') }}backend/assets/images/xm-ressult/download.png" alt="" class="img-fluid" style="height: 500px" />--}}
                                                <img src="https://img.freepik.com/free-vector/employees-celebrating-business-success-with-huge-trophy_1150-37475.jpg" alt="" class="img-fluid" style="height: 500px" />
                                                <h3 class="text-primary">Hurray.... You Passed in the exam</h3>
                                            </div>
                                        </div>
                                        @endif
                                        <div>
                                            <h3>Go Back to :</h3>
                                            <a href="{{ route('front.home') }}" class="btn btn-outline-success">HomePage</a>
                                            <a href="{{ route('front.student.dashboard') }}" class="btn btn-outline-success">Student Dashboard</a>
                                        </div>
                                    </div>
                                </div>
                            @elseif($exam->xm_type == 'Written')
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="text-center">Your Answer Submitted Successfully. Our Trainer will mark your answer very soon.</h3>
                                    <div>
                                        <h3>Go Back to :</h3>
                                        <a href="{{ route('front.home') }}" class="btn btn-outline-success">HomePage</a>
                                        <a href="{{ route('front.student.dashboard') }}" class="btn btn-outline-success">Student Dashboard</a>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
