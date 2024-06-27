@extends('frontend.master')

@section('body')
<div class="hero-slider-area">
    <div class="hero-slider owl-carousel owl-theme">
        @foreach($homeSliderCourses as $homeSliderCourse)
                <div class="hero-item">
                    <a href="{{ $homeSliderCourse->link ?? '' }}" class="w-100">
                        <div class="container-fluid">
                            <div class="row align-items-center">
                                <div class="col-lg-6 c-dnone">
                                    <div class="hero-content ms-3">
                                        <h2 style="font-size: 36px">{{ \Illuminate\Support\Str::words(
                $homeSliderCourse->title,
                8,
                '....'
            ) }}</h2>
                                        <p>
                                            {!! str()->words(strip_tags($homeSliderCourse->description), 25) !!}
                                        </p>
                                        <div class="banner-btn">
                                            <button type="button" class="default-btn border-radius-50 text-dark f-s-22"
                                                style="background-color: #dedede!important;">ভর্তি হতে এখানে ক্লিক করুন</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="">
                                        <img src="{{ asset($homeSliderCourse->image) }}" class="w-100" alt="Home Slider" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
        @endforeach
    </div>
</div>


<div class="featured-area pt-2 pb-3">
    <div class="container">
        <div class="row align-items-center mb-45"></div>
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-6 col-m-6">
                <div class="featured-item-two">
                    <a href="{{ route('front.student.today-classes') }}" class="p-2">
                        <i class="flaticon-web-development"></i>
                        <h3>আজকের ক্লাস</h3>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-6 col-m-6">
                <div class="featured-item-two">
                    <a href="{{ route('front.student.today-exams') }}" class="p-2">
                        <i class="flaticon-design"></i>
                        <h3>আজকের এক্সাম</h3>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-6 col-m-6">
                <div class="featured-item-two">
                    <a href="" class="p-2">
                        <i class="flaticon-wellness"></i>
                        <h3>লাইভ এসাইনমেন্ট</h3>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-6 col-m-6">
                <div class="featured-item-two">
                    <a href="{{ route('front.guideline') }}" class="p-2">
                        <i class="flaticon-heart-beat"></i>
                        <h3>গাইড লাইন</h3>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-6 col-m-6">
                <div class="featured-item-two">
                    <a href="{{ route('front.instructors') }}" class="p-2">
                        <i class="flaticon-corporate"></i>
                        <h3>শিক্ষকবৃন্দ</h3>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-6 col-m-6">
                <div class="featured-item-two">
                    <a href="#StudentsComments" class="p-2">
                        <i class="flaticon-camera"></i>
                        <h3>শিক্ষার্থীর মন্তব্য</h3>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-6 col-m-6">
                <div class="featured-item-two">
                    <a href="{{ route('front.all-gallery-images') }}" class="p-2">
                        <i class="flaticon-user"></i>
                        <h3>ফটো গ্যালারি</h3>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-6 col-m-6">
                <div class="featured-item-two">
                    <a href="{{ route('front.all-job-circulars') }}" class="p-2">
                        <i class="flaticon-folder"></i>
                        <h3>জব সার্কুলার</h3>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


@if(!empty($courseCategories))
    <div class="categories-area section-bg py-5">
        <div class="container">
            <div class="section-title mb-45 text-center">
                <!--   <h2>কোর্স  <b>ক্যাটাগরি</b></h2>-->
                <h2>কোর্স <b>ক্যাটাগরি সমূহ</b></h2>
                <hr class="w-25 mx-auto bg-danger" />
            </div>

            <div class="row cat_mobile_res">
                @foreach($courseCategories as $courseCategory)
                    <div class="col-md-3 col-m-6">
                        <div class="categories-item">
                            <a
                                href="{{ route('front.category-courses', ['slug' => $courseCategory->slug]) }}">
                                <img loading="lazy"
                                    src="{{ asset(isset($courseCategory->image) ? $courseCategory->image : 'frontend/logo/biddabari-card-logo.jpg') }}"
                                    alt="Categories" class="w-100 border-0">
                            </a>
                            <div class="content">
                                <a
                                    href="{{ route('front.category-courses', ['slug' => $courseCategory->slug]) }}">
                                    <i class="{{ $courseCategory->icon ?? 'flaticon-web-development' }}"></i>
                                    <h3>{{ $courseCategory->name ?? 'No Title' }}</h3>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{-- <div class="see_more_btn text-center">
                <a href="" class="btn btn-warning">See More</a>
            </div> --}}
        </div>
    </div>
@endif
@if(!empty($courses))
    <div class="courses-area-two py-5">
        <div class="container">
            <div class="section-title text-center mb-45">
                <!--   <span>কোর্স সমূহ</span>-->
                <h2>চলমান কোর্স সমূহ</h2>
                <h5>ভর্তি চলছে ... !!!</h5>
                <hr class="w-25 mx-auto bg-danger" />
            </div>
            <div class="row cat_mobile_res">
                @foreach($courses as $course)
                        <div class="col-lg-4 col-md-6">
                            <div class="courses-item">
                                <a href="{{ route('front.course-details', ['slug' => $course->slug]) }}">
                                    <img loading="lazy"
                                        src="{{ asset(file_exists_obs($course->banner) ? $course->banner : 'frontend/logo/biddabari-card-logo.jpg') }}"
                                        alt="{{ $course->alt_text }}" title="{{ $course->banner_title }}" class="w-100 p-2" style="height: 230px" />
                                </a>
                                <a href="{{ route('front.course-details', ['slug' => $course->slug]) }}">
                                    <div class="content">
                                        <h3 class="py-2"><a
                                                href="{{ route('front.course-details', ['slug' => $course->slug]) }}">{{
                        $course->title }}</a></h3>

                                        <ul class="course-list">
                                            {{-- <li><i class="ri-time-fill"></i> 06 hr</li>--}}
                                            <li><i class="ri-vidicon-fill"></i> {{ $course->total_note ?? 0 }} lectures</li>
                                            <li><i class="ri-file-pdf-line"></i> {{ $course->total_pdf ?? 0 }} PDF</li>
                                            <li><i class="ri-a-b"></i> {{ $course->total_exam ?? 0 }} Exam</li>
                                            <li><i class="ri-store-3-line"></i>{{ $course->total_live ?? 0 }} live class</li>
                                            <div class="dis-course-price">
                                                @if($course->discount_type == 1 || $course->discount_type == 2)
                                                    <span class="course-price"> ৳ <del>{{ $course->price ?? 0 }} </del> </span>
                                                    <span class="dis-course-amount">৳
                                                        {{ $course->price - $course->discount_amount }}</span>
                                                @else
                                                    <span class="dis-course-amount"> ৳ {{ $course->price ?? 0 }} </span>
                                                @endif
                                            </div>
                                        </ul>



                                        <div class="custome_dis_course_price">
                                            @if($course->discount_type == 1 || $course->discount_type == 2)
                                                <span class="course-price"> ৳ <del>{{ $course->price ?? 0 }} </del> </span>
                                                <span class="dis-course-amount">৳ {{ $course->price - $course->discount_amount }}</span>
                                            @else
                                                <span class="dis-course-amount"> ৳ {{ $course->price ?? 0 }} </span>
                                            @endif
                                        </div>
                                        @php
                                            $discountAmount = $course->discount_type == 1 ? $course->discount_amount : ($course->price * $course->discount_amount) / 100;
                                            $totalAmount = $course->price - (isset($discountAmount) ? $discountAmount : 0);
                                         @endphp


                                        <div class="bottom-content">
                                            @if($course->order_status != 'true')
                                                <a href="{{ route('front.course-details', ['slug' => $course->slug]) }}"
                                                    class="btn btn-warning">বিস্তারিত দেখুন</a>
                                            @else
                                                <a href="javascript:void(0)" class=""></a>
                                            @endif
                                            <div class="rating ">
                                                @if($course->order_status == 'true')
                                                    <a href="javascript:void(0)" class="btn text-success">Active</a>
                                                @elseif($course->order_status == 'pending')
                                                    <a href="javascript:void(0)" class="btn text-success">Pending</a>
                                                @else
                                                                            @php
                                                                                $date = date('Y-m-d H:i')
                                                                            @endphp
                                                                            @if($course->admission_last_date > $date)
                                                                                <a
                                                                                {{-- {{ dd($course) }} --}}
                                                                                    href="{{ route('front.checkout', ['type' => 'course', 'slug' => $course->slug]) }}"
                                                                                    class="btn btn-warning">কোর্সটি কিনুন</a>

                                                                                {{-- <form action="{{ route('front.place-course-order', ['course_id' => $course->id]) }}"
                                                                                    method="post">
                                                                                    @csrf
                                                                                    <input type="hidden" name="course_id" value="{{ $course->id }}" />
                                                                                    <input type="hidden" name="total_amount" value="{{ $totalAmount }}" />
                                                                                    <input type="hidden" name="used_coupon" value="0">
                                                                                    <input type="hidden" name="coupon_code" value="">
                                                                                    <input type="hidden" name="coupon_amount" value="">
                                                                                    <input type="hidden" name="ordered_for" value="course">
                                                                                    <input type="hidden" name="rc" value="{{ $_GET['rc'] ?? '' }}">
                                                                                    <input type="hidden" name="payment_method" value="ssl">`
                                                                                    <input type="submit" class="btn btn-warning" value="কোর্সটি কিনুন">
                                                                                </form> --}}
                                                                            @else
                                                                                <a class="btn btn-warning">ভর্তির সময় শেষ</a>
                                                                            @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                @endforeach
            </div>
            @php
                $course_count = DB::table('courses')->count();
            @endphp
            @if ($course_count > 9)
                <div class="see_more_btn text-center">
                    <a href="{{route('front.all-courses')}}" class="btn btn-warning">আরও দেখুন</a>
                </div>
            @endif
        </div>
    </div>
@endif

@if(!empty($products))
    <div class="section-bg py-5">
        <div class="container">
            <div class="row mb-3">
                <div class="col">
                    <div class="section-title mt-rs-20">
                        <h2 class="text-center">বইসমূহ</h2>
                        <hr class="w-25 mx-auto bg-danger" />
                    </div>
                </div>
            </div>
            <div class="row product_mobile_res pro_book_mobile_res">
                @foreach($products as $product)
                        <div class="col-lg-3 col-md-6">
                            <div class="blog-card">
                                <div class="book-btn-sec">
                                    <a href="{{ route('front.product-details', ['id' => $product->id, 'slug' => $product->slug]) }}"
                                        class="read-btn btn btn-warning">Read More</a>
                                    @php
                                        $stockStatus = false;
                                        if ($product->stock_amount > 0) {
                                            $stockStatus = true;
                                        }
                                    @endphp
                                    <p></p>

                                    @if(!empty(\Cart::get($product->id)))
                                        <a href="{{ route('front.view-cart') }}" class="default-btn ">এখনই কিনুন</a>
                                    @else
                                        @if($stockStatus == true)
                                            <form action="{{ route('front.add-to-cart-home') }}" method="post"
                                                class="addSimpleCardFrom{{$product->id}}">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}" />
                                                <input type="hidden" name="price"
                                                    value="{{ $product->has_discount_validity == 'true' ? $grandPrice : $product->price }}" />
                                                {{-- <button type="submit" class="default-btn">Add to cart</button>--}}
                                                <a href="javascript:void(0)" onclick="addSimpleProCard({{$product->id}})"
                                                    class="read-btn btn btn-warning cart_count-{{$product->id}} mt-1"> Add To Cart </a>
                                            </form>
                                        @endif
                                    @endif

                                </div>
                                <div class="blog_card_img">

                                    <img loading="lazy"
                                        src="{{ asset($product->image ?? 'frontend/logo/biddabari-card-logo.jpg') }}"
                                        alt="{{ $product->title }}">

                                </div>
                                <div class="content">
                                    <h3><a
                                            href="{{ route('front.product-details', ['id' => $product->id, 'slug' => $product->slug]) }}">{{
                        $product->title ?? '' }}</a></h3>
                                    @if($stockStatus == true)
                                        <p class="text-success f-s-19">In Stock</p>
                                    @else
                                        <p class="text-danger f-s-19">Out Of Stock</p>
                                    @endif
                                    <h5>TK {{$product->price}} </h5>
                                </div>
                            </div>
                        </div>
                @endforeach
            </div>
            @php
                $count_product = DB::table('products')->count();
            @endphp
            @if ($count_product > 8)
                <div class="see_more_btn text-center">
                    <a href="{{route('front.all-products')}}" class="btn btn-warning">আরও দেখুন</a>
                </div>
            @endif
        </div>
    </div>
@endif

<div class="counter-area pt-5 pb-4" style="background-color: #F18345 !important;">
    <div class="container">
        <div class="row">
            @foreach($numberCounters as $numberCounter)
                <div class="col-lg-3 col-6 col-md-3">
                    <div class="counter-content">
                        <i class="{{ $numberCounter->icon_code ?? 'flaticon-online-course' }}"></i>
                        <h3><span class="odometer" data-count="{{ $numberCounter->total_number }}">00000</span>+</h3>
                        <p>{{ $numberCounter->label ?? '' }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>



<div class="py-5 section-bg">
    <div class="container">
        <div class="row pb-4">
            <div class="col-12 mb-4">
                <div class="section-title text-center">
                    <h2 class="">আমাদের কথা</h2>
                    <hr class="w-25 mx-auto bg-danger" />
                </div>
            </div>
            <div class="col-lg-6">
                <video class="border-0" style="width: 100%!important;" height="350" controls>
                    <source src="{{asset($siteSettings->our_speech_video_url)}}" type="video/mp4">
                    {{--
                    <source src="movie.ogg" type="video/ogg">--}}
                    Your browser does not support the video tag.
                </video>
            </div>
            <div class="col-lg-6">
                <div class="card card-body rounded-0 our-speech content-shadow">

                    {!! $siteSettings->our_speech_text !!}
                </div>
            </div>
        </div>
    </div>
</div>


<div class="py-5">
    <div class="container">
        <div class="row align-items-center mb-3">
            <div class="col">
                <div class="section-title mt-rs-20">
                    <h2 class="text-center">আমাদের সেবা সমূহ</h2>
                    <hr class="w-25 mx-auto bg-danger" />
                </div>
            </div>
        </div>
        <div class="row facility course-slider-two-one owl-carousel owl-theme">
            @foreach($ourServices as $key => $ourService)
                @if($key == 0 || $key == 2 || $key == 4 || $key == 6)
                    <div class="col-12 col-m-6">
                        <div class="card mb-4 border-0 content-shadow">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img loading="lazy"
                                        src="{{ asset($ourService->image) ?? 'frontend/assets/images/our-speak/1.png' }}"
                                        class="img-fluid rounded-start h-100 py-2" alt="..." />
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body text-end">
                                        <h2 class="card-title mb-2">{{ $ourService->title ?? '' }}</h2>
                                        <p class="card-text text-muted">
                                            {!! $ourService->content !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($key == 1 || $key == 3 || $key == 5 || $key == 7)
                    <div class="col-12 col-m-6">
                        <div class="card mb-3 border-0 content-shadow">
                            <div class="row g-0">
                                <div class="col-md-8">
                                    <div class="card-body text-start">
                                        <h2 class="card-title mb-2">{{ $ourService->title ?? '' }}</h2>
                                        <p class="card-text text-muted">
                                            {!! $ourService->content !!}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4 text-end">
                                    <img loading="lazy"
                                        src="{{ asset($ourService->image) ?? 'frontend/assets/images/our-speak/1.png' }}"
                                        class="img-fluid rounded-start h-100 py-2" alt="...">
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

        </div>
    </div>
</div>




<div class="courses-area-two py-5">
    <div class="container">
        <div class="section-title text-center mb-3">
            <h2>শ্রদ্ধেয় শিক্ষকদের কথা</h2>
            <hr class="w-25 mx-auto bg-danger" />
        </div>
        <div class="course-slider-two owl-carousel owl-theme">
            @foreach($ourTeams as $ourTeam)
                <div class="courses-item">
                    <div>
                        <video class="border-0" style="width: 100%!important;" height="240" controls>
                            <source src="{{asset($ourTeam->video_file)}}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                    <div class="content teacher-name">
                        <h3><a href="javascript:void(0)">{{ $ourTeam->name ?? '' }}</a></h3>
                        <span> {{ $ourTeam->designation ?? '' }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div id="StudentsComments" class="testimonials-area bg-light py-5">
    <div class="container">
        <div class="section-title text-center">
            <h2>শিক্ষার্থীদের মতামত</h2>
            <hr class="w-25 mx-auto bg-danger" />
            <div class="offset-md-3 col-md-6 stu-tab mt-2">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                            data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane"
                            aria-selected="true">সফল শিক্ষার্থীদের মতামত</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                            data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane"
                            aria-selected="false">চলমান শিক্ষার্থীদের মতামত</button>
                    </li>
                </ul>
            </div>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab"
                    tabindex="0">
                    <div class="testimonials-slider-two owl-carousel owl-theme">
                        @foreach($studentOpinions as $successStudentOpinion)
                            @if($successStudentOpinion->show_type == 'all_students')
                                <div class="testimonials-card-two">
                                    {!! $successStudentOpinion->comment !!}
                                    <div class="content">
                                        <img loading="lazy"
                                            src="{{ asset($successStudentOpinion->image) ?? 'frontend/assets/images/testimonials/s-1.jpg' }}"
                                            alt="testimonials" />
                                        <h3>{{ $successStudentOpinion->name ?? 'Student Name' }}</h3>
                                        <span>Student</span>
                                    </div>
                                    <div class="quote"> <i class="flaticon-quote"></i></div>
                                </div>
                            @endif
                        @endforeach

                    </div>
                </div>
                <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab"
                    tabindex="0">
                    <div class="testimonials-slider-two owl-carousel owl-theme">
                        @foreach($studentOpinions as $runningStudentOpinion)
                            @if($runningStudentOpinion->show_type == 'running_student')
                                <div class="testimonials-card-two">
                                    {!! $runningStudentOpinion->comment !!}
                                    <div class="content">
                                        <img loading="lazy"
                                            src="{{ asset($runningStudentOpinion->image) ?? 'frontend/assets/images/testimonials/s-1.jpg' }}"
                                            alt="testimonials" />
                                        <h3>{{ $runningStudentOpinion->name ?? 'Student Name' }}</h3>
                                        <span>Student</span>
                                    </div>
                                    <div class="quote"> <i class="flaticon-quote"></i></div>
                                </div>
                            @endif
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
@if(!empty($poppup))
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>--}}
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body popup_card">
                    <div class="card border-0">
                        <img src="{{asset(file_exists_obs($poppup->image) ? $poppup->image : 'frontend/logo/biddabari-card-logo.jpg')}}"
                            alt="popup-img">
                        <p>{!! $poppup->description ?? '  ' !!}</p>
                        {{-- <div class="d-flex">--}}
                            {{-- <a class="btn btn-primary btn-sm ms-auto" href="{{$poppup->active_btn_link}}">
                                {{$poppup->action_btn_text}}</a>--}}
                            {{-- </div>--}}
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>--}}
                    {{-- <a type="button" class="btn btn-primary">--}}
                        <a class="btn btn-primary btn-sm ms-auto" href="{{$poppup->active_btn_link ?? ''}}">
                            {{$poppup->action_btn_text ?? ''}}</a>
                        {{-- </a>--}}
                </div>
            </div>
        </div>
    </div>
@endif
@endsection
@push('style')

    <style>
        .hero-slider-area {
            padding: 5px 0 !important;
            /*background-color: rgba(241, 131, 69, .5)*/
            background-color: #ebe9f1
        }

        .featured-item-two a h3 {
            font-size: 24px
        }
    </style>
    <style>
        @media screen and (max-width: 426px) {
            .col-m-6 {
                width: 50% !important;
            }
        }
    </style>

@endpush

@push('script')
    @if(isset($poppup))
        <script>
            $(function () {
                setTimeout(function () {
                    $('#staticBackdrop').modal('show');
                }, 3000)
            });
        </script>
    @endif
@endpush
