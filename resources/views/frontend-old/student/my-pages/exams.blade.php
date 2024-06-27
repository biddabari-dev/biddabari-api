@extends('frontend.student-master')

@section('student-body')
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="section-title text-center">
                    <h2> আমার এক্সাম সমূহ</h2>
                    <hr class="w-25 mx-auto bg-danger"/>
                </div>
                @if(!empty($exams))
                    @forelse($exams as $exam)
                        <div class="col-lg-4 col-md-6">
                            <a href="{{ route('front.student.batch-exam-contents', ['xm_id' => $exam->batchExam->id, 'master' => base64_encode($exam->batchExam->is_master_exam), 'slug' => $exam->batchExam->slug]) }}" @if($exam->status == 'pending') onclick="event.preventDefault(); toastr.error('Your request is pending. Please wait till your request is approved.')" @endif >
                                <div class="courses-item">
                                    <img src="{{ asset($exam->batchExam->banner) }}" alt="Courses" class="img-fluid w-100" style="height: 230px" />
                                    <div class="content">
                                        <h3>{{ $exam->batchExam->title }}</h3>
                                        @if($exam->order_status == 'pending')
                                            <div class="bottom-content justify-content-end">
                                                <p class=""><button type="button" class="btn btn-sm btn-danger ms-auto">Pending</button></p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-lg-12">
                            <div class="courses-item">
                                <p class="text-center">No Exams Enrolled Yet</p>
                            </div>
                        </div>
                    @endforelse
                @endif
            </div>
        </div>
    </section>
@endsection
