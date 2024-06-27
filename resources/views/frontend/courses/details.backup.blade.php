@extends('frontend.master')

@section('body')

    <div class="inner-banner inner-banner-bg9">
        <div class="container">
            <div class="inner-title">
                <h3>{{ $course->title }}</h3>

                <div class="inner-banner-content">
                    <ul class="course-list">
                        <li><i class="ri-time-fill"></i> 10 hr 07 min</li>
                        <li><i class="ri-vidicon-fill"></i> {{ count($course->courseSections) }} lectures</li>
                    </ul>
                </div>
                <ul>
                    <li>
                        <a href="{{ route('front.home') }}">Home</a>
                    </li>
                    <li>Courses details</li>
                </ul>
            </div>
        </div>
    </div>


    <div class="courses-details-area pt-100 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="courses-details-contact">
                        <div class="tab courses-details-tab">
                            <ul class="tabs">
                                <li>
                                    Overview
                                </li>
                                <li>
                                    Course Content
                                </li>
                                <li>
                                    Instructor
                                </li>
                            </ul>
                            <div class="tab_content current active">
                                <div class="tabs_item current">
                                    <div class="courses-details-tab-content">
                                        <div class="courses-details-into">
                                            <h3>Description</h3>
                                            {!! $course->description !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="tabs_item">
                                    <div class="courses-details-tab-content">
                                        <div class="courses-details-accordion">
                                            <ul class="accordion">
                                                @if($courseEnrollStatus == 'true')
                                                    @if(!empty($course->courseSections))
                                                        @forelse($course->courseSections as $courseSection)
                                                            <li class="accordion-item">
                                                                <a class="accordion-title" href="javascript:void(0)">
                                                                    <i class="ri-add-fill"></i>
                                                                    {{ $courseSection->title }}
                                                                </a>
                                                                @if(!empty($courseSection->courseSectionContents))
                                                                        <div class="accordion-content">
                                                                            @foreach($courseSection->courseSectionContents as $courseSectionContent)
                                                                                @if($courseSectionContent->content_type == 'pdf')
                                                                                    <div class="accordion-content-list">
                                                                                        <div class="accordion-content-left">
                                                                                            <i class="ri-file-text-line"></i>
                                                                                            PDF
                                                                                        </div>
                                                                                        <div class="accordion-content-right">
                                                                                            <div class="tag2">
                                                                                                <a href="{{ !empty($courseSectionContent->pdf_link) ? $courseSectionContent->pdf_link : asset($courseSectionContent->pdf_file) }}" download="download">Download</a>
                                                                                            </div>
                                                                                            <!--                                                            <i class="ri-play-circle-line"></i>-->
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                                @if($courseSectionContent->content_type == 'video')
                                                                                    <div class="accordion-content-list">
                                                                                        <div class="accordion-content-left">
                                                                                            <i class="ri-file-text-line"></i>
                                                                                            Video
                                                                                        </div>
                                                                                        <div class="accordion-content-right">
                                                                                            <div class="tag2">
                                                                                                <a href="{{ !empty($courseSectionContent->video_link) ? $courseSectionContent->video_link : '' }}" download="download">Download</a>
                                                                                            </div>
                                                                                            <!--                                                            <i class="ri-play-circle-line"></i>-->
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                                @if($courseSectionContent->content_type == 'live')
                                                                                    <div class="accordion-content-list">
                                                                                        <div class="accordion-content-left">
                                                                                            <i class="ri-file-text-line"></i>
                                                                                            Go Live
                                                                                        </div>
                                                                                        <div class="accordion-content-right">
                                                                                            <div class="tag2">
                                                                                                <a href="{{ !empty($courseSectionContent->live_link) ? $courseSectionContent->live_link : '' }}" target="_blank">Go Live</a>
                                                                                            </div>
                                                                                            <!--                                                            <i class="ri-play-circle-line"></i>-->
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                                @if($courseSectionContent->content_type == 'link')
                                                                                    <div class="accordion-content-list">
                                                                                        <div class="accordion-content-left">
                                                                                            <i class="ri-file-text-line"></i>
                                                                                            Regular Link
                                                                                        </div>
                                                                                        <div class="accordion-content-right">
                                                                                            <div class="tag2">
                                                                                                <a href="{{ !empty($courseSectionContent->regular_link) ? $courseSectionContent->regular_link : '' }}" target="_blank">Visit</a>
                                                                                            </div>
                                                                                            <!--                                                            <i class="ri-play-circle-line"></i>-->
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                                @if($courseSectionContent->content_type == 'assignment')
                                                                                    <div class="accordion-content-list">
                                                                                        <div class="accordion-content-left">
                                                                                            <i class="ri-file-text-line"></i>
                                                                                            Assignment File
                                                                                        </div>
                                                                                        <div class="accordion-content-right">
                                                                                            <div class="tag2">
                                                                                                <a href="{{ !empty($courseSectionContent->assignment_question) ? $courseSectionContent->assignment_question : '' }}" download>Download</a>
                                                                                            </div>
                                                                                            <!--                                                            <i class="ri-play-circle-line"></i>-->
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                                @if($courseSectionContent->content_type == 'testmoj')
                                                                                    <div class="accordion-content-list">
                                                                                        <div class="accordion-content-left">
                                                                                            <i class="ri-file-text-line"></i>
                                                                                            TestMoj
                                                                                        </div>
                                                                                        <div class="accordion-content-right">
                                                                                            <div class="tag2">
                                                                                                <a href="{{ !empty($courseSectionContent->testmoj_link) ? $courseSectionContent->testmoj_link : '' }}" download>Visit</a>
                                                                                            </div>
                                                                                            <!--                                                            <i class="ri-play-circle-line"></i>-->
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                                @if($courseSectionContent->content_type == 'exam')
                                                                                    <div class="accordion-content-list">
                                                                                        <div class="accordion-content-left">
                                                                                            <i class="ri-file-text-line"></i>
                                                                                            Exam
                                                                                        </div>
                                                                                        <div class="accordion-content-right">
                                                                                            <div class="tag2">
                                                                                                Exam
    {{--                                                                                            <a href="{{ !empty($courseSectionContent->testmoj_link) ? $courseSectionContent->testmoj_link : '' }}" download>View</a>--}}
                                                                                            </div>
                                                                                            <!--                                                            <i class="ri-play-circle-line"></i>-->
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                                @if($courseSectionContent->content_type == 'written_exam')
                                                                                    <div class="accordion-content-list">
                                                                                        <div class="accordion-content-left">
                                                                                            <i class="ri-file-text-line"></i>
                                                                                            Written Exam
                                                                                        </div>
    {{--                                                                                    <div class="accordion-content-right">--}}
    {{--                                                                                        <div class="tag2">--}}
    {{--                                                                                            Exam--}}
    {{--                                                                                            <a href="{{ !empty($courseSectionContent->testmoj_link) ? $courseSectionContent->testmoj_link : '' }}" download>View</a>--}}
    {{--                                                                                        </div>--}}
    {{--                                                                                        <!--                                                            <i class="ri-play-circle-line"></i>-->--}}
    {{--                                                                                    </div>--}}
                                                                                    </div>
                                                                                @endif
                                                                            @endforeach
                                                                        </div>
                                                                @endif
                                                            </li>
                                                        @empty
                                                            <li class="accordion-item">
                                                                <a class="accordion-title" href="javascript:void(0)">
                                                                    No Content Available Yet
                                                                </a>
                                                            </li>
                                                        @endforelse
                                                    @endif
                                                @else
                                                    <li class="accordion-item">
                                                        <a class="accordion-title" href="javascript:void(0)">
                                                            <i class="ri-add-fill"></i>
                                                            You need to enroll to view course contents.
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="tabs_item">
                                    <div class="courses-details-tab-content">
                                        <div class="courses-details-instructor">
                                            <h3>About the instructor</h3>
                                            <div class="details-instructor">
                                                <img src="{{ !empty($course->teachers->image) ? asset($course->teachers->image) : asset('user-avatar.png') }}" alt="instructor" style="height: 75px;" />
                                                <h3>{{ isset($course->teachers->first_name) ? $course->teachers->first_name.' '.$course->teachers->last_name : 'Trainer' }}</h3>
                                                <span>{{ isset($course->teachers->subject) ? $course->teachers->subject : 'Unknown' }}</span>
                                            </div>
                                            <p>{!! isset($course->teachers->description) ? $course->teachers->description : 'No Information Provided.' !!}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
{{--comment - has to work later--}}
{{--                    <div class="comments-form">--}}
{{--                        <div class="contact-form">--}}
{{--                            <h4>Leave A Reply</h4>--}}
{{--                            <p>Your email address will not be published. Required fields are marked</p>--}}
{{--                            <form id="contactForm" action="" method="post">--}}
{{--                                @csrf--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-lg-6 col-sm-6">--}}
{{--                                        <div class="form-group">--}}
{{--                                            <input type="text" name="name" id="name" class="form-control" required data-error="Please enter your name" placeholder="Your Name">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-lg-6 col-sm-6">--}}
{{--                                        <div class="form-group">--}}
{{--                                            <input type="email" name="email" id="email" class="form-control" required data-error="Please enter your email" placeholder="Your Email">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-lg-12 col-md-12">--}}
{{--                                        <div class="form-group">--}}
{{--                                            <textarea name="message" class="form-control" id="message" cols="30" rows="8" required data-error="Write your message" placeholder="Comment..."></textarea>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-lg-12 col-md-12">--}}
{{--                                        <button type="submit" class="default-btn">--}}
{{--                                            Post A Comment--}}
{{--                                        </button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </form>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
                <div class="col-lg-4">
                    <div class="courses-details-sidebar">
                        <img src="{{ asset($course->banner) }}" alt="{{ $course->alt_text }}" title="{{ $course->banner_title }}" style="height: 240px" />
                        <div class="content">
                            <h3>{{ $course->price }} tk</h3>
                            <span>This course includes:</span>
                            <ul class="courses-details-list">
                                <li><i class="ri-time-fill"></i> {{ $course->total_hours ?? '' }} hr</li>
                                <li><i class="ri-vidicon-fill"></i> {{ $course->total_class ?? '' }} lectures</li>
                                <li><i class="ri-file-pdf-line"></i> {{ $course->total_pdf ?? '' }} PDF</li>
                                <li><i class="ri-a-b"></i> {{ $course->total_exam ?? '' }} Exam</li>
                                <li><i class="ri-store-3-line"></i>{{ $course->total_live ?? '' }} live class</li>
                            </ul>
                            <a href="{{ route('front.checkout', ['id' => $course->id, 'slug' => $course->slug]) }}" class="default-btn bg-default-color">কোর্সটি কিনুন</a>
                            <ul class="social-link">
                                <li class="social-title">Share this course:</li>
                                <li>
                                    <a href="https://www.facebook.com/" target="_blank">
                                        <i class="ri-facebook-fill"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://twitter.com/" target="_blank">
                                        <i class="ri-twitter-fill"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.pinterest.com/" target="_blank">
                                        <i class="ri-instagram-line"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
