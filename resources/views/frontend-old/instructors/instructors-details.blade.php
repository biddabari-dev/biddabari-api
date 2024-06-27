@extends('frontend.master')

@section('body')

    <div class="instructors-details-area pt-100 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="instructors-details-img">
                        <img src="{{ asset(isset($teacher->image) ? $teacher->image : 'https://png.pngtree.com/png-vector/20190710/ourmid/pngtree-user-vector-avatar-png-image_1541962.jpg') }}" alt="Instructor" />
                        <ul class="social-link">
                            <li class="social-title">Follow me:</li>
                            <li>
                                <a href="{{ $teacher->facebook }}" target="_blank">
                                    <i class="ri-facebook-fill"></i>
                                </a>
                            </li>
                            <li>
                                <a href="{{ $teacher->twitter }}" target="_blank">
                                    <i class="ri-twitter-fill"></i>
                                </a>
                            </li>
                            <li>
                                <a href="{{ $teacher->linkedin }}" target="_blank">
                                    <i class="ri-linkedin-line"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="instructors-details-content pl-20">
                        <h3 class="f-s-39">{{ $teacher->first_name. ' ' . $teacher->last_name }}</h3>
                        <span class="sub-title f-s-24">{{ $teacher->subject }}</span>
                        <ul>
                            <li class="f-s-22 mb-0">Phone number: <span><a href="tel:{{ $teacher->mobile }}">{{ $teacher->mobile }} </a></span></li>
                            <li class="f-s-22 mb-0">Email: <span><a href="mailto:{{ $teacher->email }}"><span class="__cf_email__">{{ $teacher->email }}</span></a></span></li>
                            <li class="f-s-22 mb-0">Website: <span><a href="{{ $teacher->website }}" target="_blank">{{ $teacher->website }}</a></span></li>

                        </ul>
                        {!! $teacher->description !!}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="courses-area pb-70">
        <div class="container">
            <div class="section-title text-center mb-45">
                <h2>Find Latest courses</h2>

            </div>
            <div class="row">
                @foreach($latestCourses as $latestCourse)
                <div class="col-lg-4 col-md-6">
                    <div class="courses-item">
                        <a href="{{ route('front.course-details',['id' => $latestCourse->id, 'slug' => $latestCourse->slug]) }}">
                            <img src="{{ asset(file_exists_obs($latestCourse->banner) ? $latestCourse->banner : '/frontend/logo/biddabari-card-logo.jpg') }}" alt="Courses" style="width: 100%; height: 200px" />
                        </a>
                        <div class="content">
{{--                            <a href="javascript:void(0)" class="tag-btn">Design</a>--}}
                            <div class="price-text">BDT. {{ $latestCourse->price }}</div>
                            <h3><a href="{{ route('front.course-details',['id' => $latestCourse->id, 'slug' => $latestCourse->slug]) }}">{{ $latestCourse->title }}</a></h3>
                            <ul class="course-list">
                                <li><i class="ri-time-fill"></i> {{ $latestCourse->total_hours }} min</li>
                                <li><i class="ri-vidicon-fill"></i> {{ $latestCourse->total_video }} lectures</li>
                            </ul>

                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
