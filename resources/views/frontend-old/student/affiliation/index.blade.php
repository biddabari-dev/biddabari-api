@extends('frontend.student-master')

@section('title', 'my affiliation')

@section('student-body')

    <div class="row mt-3">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h3>My Affiliations</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h4>Affiliation Code</h4>
                            @if(isset($affiliateRegister) && $affiliateRegister->status == 1)
                                <p>{{ $affiliateRegister->affiliate_code }}</p>
                            @elseif(isset($affiliateRegister) && $affiliateRegister->status == 0)
                                <p>Your request is still pending</p>
                            @else
                                <a href="{{ route('front.student.generate-user-affiliate-code') }}" class="btn btn-success">Apply</a>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <h4>Total Earnings</h4>
                            <p class="f-s-22">{{ isset($affiliateRegister) ? $affiliateRegister->affiliationInsertHistories->sum('amount') : 0 }}</p>
                        </div>
                        <div class="col-md-4">
                            <h4>Total Withdraws</h4>
                            <p class="f-s-22">{{ isset($affiliateRegister) ? $affiliateRegister->affiliationWithdrawHistories->sum('amount') : 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(isset($affiliateRegister) && $affiliateRegister->status == 1)
        <div class="row mt-3">
            <div class="col-md-11 mx-auto">
                <h2 class="text-center">Referral Links</h2>
                <p class="f-s-21 text-center">Click to copy referral link</p>
                <div class="py-5">
                    <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active f-s-22" data-bs-toggle="pill" data-bs-target="#pills-course" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Home</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link f-s-22" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-batch-exam" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Batch Exam</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-course" role="tabpanel" aria-labelledby="pills-home-tab">
                            <h4 class="text-center">Courses</h4>
                            <div class="row mt-3">
                                @foreach($courses as $course)
                                    <div class="col-md-3" style="cursor: pointer">
                                        <div class="card copy-link" data-link="{{ route('front.course-details', ['id' => $course->id, 'slug' => $course->slug, 'rc' => $affiliateRegister->affiliate_code]) }}">
                                            <img src="{{ asset($course->banner) }}" alt="course-1" style="height: 150px" class="card-img-top" />
                                            <div class="card-body py-0">
                                                <h3>{!! $course->title !!}</h3>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-batch-exam" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <h4 class="text-center">Batch Exams</h4>
                            <div class="row mt-3">
                                @foreach($batchExams as $batchExam)
                                    <div class="col-md-3" style="cursor: pointer">
                                        <div class="card copy-link" data-link="{{ route('front.all-exams', ['bxid' => $batchExam->id, 'slug' => $batchExam->slug, 'rc' => $affiliateRegister->affiliate_code]) }}">
                                            <img src="{{ asset($batchExam->banner) }}" alt="course-1" style="height: 150px" class="card-img-top" />
                                            <div class="card-body py-0">
                                                <h3>{!! $batchExam->title !!}</h3>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('script')
    <script>
        $(document).on('click', '.copy-link', function (){
            var link = $(this).attr('data-link');


            // Create a hidden input element
            var $tempInput = $("<input>");
            $("body").append($tempInput);
            // Set the value of the input to the text you want to copy
            $tempInput.val(link).select();
            // Execute the copy command
            document.execCommand("copy");
            // Remove the temporary input
            $tempInput.remove();
            // Provide some feedback to the user (you can use other methods for this)
            toastr.success("Link copied to clipboard!");

        })
    </script>
@endpush
