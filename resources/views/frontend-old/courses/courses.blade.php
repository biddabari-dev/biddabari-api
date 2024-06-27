@extends('frontend.master')

@section('body')
  
    <div class="courses-area-two section-bg py-5 bg-white">
        <div class="container">
            <div class="col-md-12">
                <div class="card card-body border-0 rounded-0">
                    <div class="text-center mb-5">
                        <a href="" class="btn border-main-color"><span class="fw-bolder fs-2">আমাদের কোর্সসমূহ</span></a>
                    </div>
                    <div>
                        <ul class="nav nav-pills all-course-page-nav-pills text-center">
                            <li class="nav-item mb-3"><button type="button" class="nav-link active border-danger btn py-0 mx-2 text-dark " style="border: 1px solid #F18C53" data-bs-toggle="pill" data-bs-target="#allCourses" ><span class="f-s-25">All Running Courses</span></button></li>
                            @foreach($courseCategories as $index => $courseCategory)
                                <li class="nav-item mb-3"><button type="button" class="nav-link border-danger btn py-0 mx-2 text-dark" style="border: 1px solid #F18C53" data-bs-toggle="pill" data-bs-target="#{{ 'id'.$index }}"><span class="f-s-25">{{ $courseCategory->name }}</span></button></li>
                            @endforeach
                        </ul>
                        <div class="tab-content mt-5">
                            @foreach($courseCategories as $key => $courseCategory)
                                @if($key == 0)
                                    <div class="tab-pane px-1 fade show active" id="allCourses">
                                        <div class="row">

                                            @foreach($allCourses as $allIndex => $singleCourse)
                                                @include('frontend.courses.include-courses-course', ['course' => $singleCourse])
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                <div class="tab-pane fade" id="{{ 'id'.$key }}">
                                    @if(count($courseCategory->courseCategories) > 0)
                                        <div class="row pb-5">
                                            @foreach($courseCategory->courseCategories as $courseSubCategory)
                                                <div class="col-md-4">
                                                    <a href="{{ route('front.category-courses', ['id' => $courseSubCategory->id, 'slug' => $courseSubCategory->slug]) }}" class="w-100">
                                                        <div class="categories-item rounded-0">
                                                            <img src="{{ asset(!empty($courseSubCategory->image) ? $courseSubCategory->image : 'frontend/logo/biddabari-card-logo.jpg') }}" alt="Categories" class="w-100 border-0" style="height: 240px">
                                                            <div class="content" style="min-height: 80px">
                                                                <span class="float-start border rounded-circle p-3" style="">
                                                                    <i class="flaticon-web-development "></i>
                                                                </span>
                                                                <h3 class="float-start ms-3 mt-3">{{ $courseSubCategory->name ?? 'Course Category' }}</h3>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="row">
                                        @if(count($courseCategory->courses) > 0)
                                            @forelse($courseCategory->courses as $course)
                                                @include('frontend.courses.include-courses-course', ['course' => $course])
                                            @empty
                                            <div class="col-md-12">
                                                <div class="text-center">
                                                    <h2>কোনো কোর্স চালু হয়নি।  খুব দ্রুত কোর্স চালু হবে। </h2>
                                                </div>
                                            </div>
                                            @endforelse
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
{{--                         <div class="d-flex justify-content-center">--}}
{{--                            {!! $allCourses->links() !!}--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
