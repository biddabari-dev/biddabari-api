@extends('frontend.master')

@section('body')
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-10 mx-auto">
                    <div class="card">
                        <div class="card-body align-items-center" >
                            <div class="">
                                <div>
                                    <h2 class="text-secondary">{{ $exam->title }}</h2>
                                    <span class="fw-bold f-s-26">Biddabari</span>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <span class="text-primary f-s-22">Total Question: </span><small class="f-s-22">{{ count($exam->questionStores) }}</small>
                                    </div>
                                    <div class="col-4">
                                        <span class="text-primary f-s-22">Result: </span><small class="f-s-22">{{ $examResult->result_mark  }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body mt-3">
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
                                            <a href="{{ route('front.student.course-contents', ['course_id' => $exam->courseSection->course->id, 'slug' => str_replace(' ', '-', $exam->title)]) }}" class="btn btn-outline-success">{{ $exam->title }} Class Contents</a>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script>
        {{--setTimeout(function () {--}}
        {{--    window.location = "{{ route('front.student.course-contents', ['course_id' => $exam->courseSection->course->id, 'slug' => str_replace(' ', '-', $exam->title)]) }}";--}}
        {{--}, 2000)--}}
    </script>
@endsection
