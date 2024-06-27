@extends('frontend.master')

@section('body')
            <div class="courses-details-area pt-3 pb-70">
                <div class="container">
                    <div class="row">


                    <div class="col-lg-4 details_custom_mobile_block">
                            <div class="courses-details-sidebar shadow">
                                {{--                                <img src="{{ asset($course->banner) }}" alt="Courses" style="height: 240px" />--}}
                                @if(!empty($course->featured_video_url))
                                    <div class="video-container" >
                                        <div class="video-foreground">
                                            <iframe width="100%" height="315" src="https://www.youtube.com/embed/{!! $course->featured_video_url !!}?rel=0&amp;modestbranding=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"></iframe>
                                        </div>
                                    </div>
                                @else
                                    <img src="{{ asset(isset($course->banner) ? $course->banner : 'frontend/logo/biddabari-card-logo.jpg') }}" class="w-100 img-fluid" style="height: 315px" alt="{{ $course->alt_text }}" title="{{ $course->banner_title }}">
                                @endif
                                <div class="content">
                                    <h1>{!! $course->title !!}</h1>
                                    <span class="f-s-22 sub-title">{!! $course->sub_title !!}</span> <br>
                                    <p class="f-s-20 pb-0" style="color:red">{!! 'Admission Last Date : '.showDate($course->admission_last_date) !!}</p>
                                    <div class="row">
                                        <div class="col-md-6">

                                            @if($course->discount_end_date > \Illuminate\Support\Carbon::today()->format('Y-m-d') && $course->discount_amount > 0)
                                                <p class="f-s-20">Price: <del>{{ $course->is_paid == 1 ? $course->price : 'Free' }}</del> tk</p>
                                                {{--                                                <p class="f-s-20">Discount Price: {{ $course->price - $course->discount_amount }} tk</p>--}}
                                                {{--                                                <p class="f-s-20">Discount Price: {{ $discountPrice = $course->discount_type == 1 ? $course->discount_amount : ($course->price * $course->discount_amount)/100 }} tk</p>--}}
                                                    <?php
                                                    $discountPrice = $course->discount_type == 1 ? $course->discount_amount : ($course->price * $course->discount_amount)/100;
                                                    ?>
                                                <p class="f-s-20 pb-0">After Discount: {{ $totalAmount = $course->price - $discountPrice ?? 0 }} tk</p>
                                            @else
                                                <p class="f-s-20 pb-0">Price: {{ $course->is_paid == 1 ? $course->price.' tk' : 'Free' }} </p>
                                            @endif
                                        </div>
                                    </div>
                                    {{--                                    <p>Already Enrolled Student: {{ $course->fack_student_count }}</p>--}}
                                    <span class="f-s-26">This course includes:</span>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="f-s-20 d-flex"><i class="ri-time-fill me-2"></i> {{ $course->total_hours ?? '' }} hr</div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="f-s-20 d-flex"><i class="ri-vidicon-fill me-2"></i> {{ $course->total_class ?? '' }} lectures</div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="f-s-20 d-flex" ><i class="ri-a-b me-2"></i> {{ $course->total_exam ?? '' }} Exam</div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="f-s-20 d-flex"><i class="ri-store-3-line me-2"></i>{{ $course->total_live ?? '' }} live class</div>
                                        </div>
                                    </div>

                                    @if($course->is_paid == 1)
                                        @if($courseEnrollStatus == 'false')
                                            @php
                                                $date=date('Y-m-d H:i');
                                            @endphp
                                            @if($course->admission_last_date > $date)
                                                <a href="{{ route('front.checkout', ['type' => 'course', 'slug' => $course->slug, 'rc' => ($_GET['rc'] ?? '') ]) }}" class="default-btn bg-default-color mt-4">কোর্সটি কিনুন</a>
                                            @else
                                                <a class="default-btn bg-default-color btn-block mt-4">ভর্তির সময় শেষ</a>
                                            @endif

                                            <ul class="social-link">
                                            </ul>
                                        @elseif($courseEnrollStatus == 'pending')
                                            <a href="javascript:void(0)" class="default-btn bg-default-color mt-2">Your Order is Pending</a>
                                        @endif
                                    @else
                                        @if($courseEnrollStatus == 'false')
                                            @if(auth()->check())
                                                <a href="" data-course-id="{{ $course->id }}" onclick="event.preventDefault(); document.getElementById('freeCourseOrderForm').submit()" class="default-btn bg-default-color order-free-course">কোর্সটি করুন</a>
                                            @else
                                                <a href="{{ route('login') }}" data-course-id="{{ $course->id }}"  class="default-btn bg-default-color order-free-course">কোর্সটি করুন</a>
                                            @endif
                                            <form action="{{ route('front.place-free-course-order', ['course_id' => $course->id]) }}" method="post" id="freeCourseOrderForm">
                                                @csrf

                                                <input type="hidden" name="ordered_for" value="course">
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>





                        <div class="col-lg-8">
                            <div class="card content-shadow rounded-0">
                                <div class="card-body">
                                    <h1 class="text-center details_custom_mobile_none">{{($course->title)}}</h1>
                                    <hr/>
                                    <div class="courses-details-contact">
                                        <div class="tab courses-details-tab">
                                            <ul class="tabs">
                                                <li>
                                                    Overview
                                                </li>
                                                <li>
                                                    Instructor
                                                </li>
                                                <li>
                                                    Routine
                                                </li>
                                            </ul>
                                            <div class="tab_content current active">
                                                <div class="tabs_item current">
                                                    <div class="courses-details-tab-content">
                                                        <div class="courses-details-into ms-2">
                                                            <h3>Description</h3>


                                                            {!! $course->description !!}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tabs_item">
                                                    <div class="courses-details-tab-content">
                                                        <div class="courses-details-instructor">
                                                            <h3>About the instructors</h3>
                                                            @foreach($course->teachers as $teacher)
                                                                <div class="details-instructor float-start ms-2 d-flex">
                                                                    <img src="{{ !empty($teacher->image) ? asset($teacher->image) : asset('user-avatar.png') }}" alt="instructor" style="height: 60px; width:60px;" />
                                                                    <h3 style="font-weight: lighter;">{{ isset($teacher->first_name) ? $teacher->first_name.' '.$teacher->last_name : $teacher->user->name }}</h3>
                                                                    <span>{{ isset($teacher->subject) ? $teacher->subject : '' }}</span>
                                                                </div>
                                                            @endforeach
                                                            {{--                                                    <p>{!! isset($course->teachers->description) ? $course->teachers->description : 'No Information Provided.' !!}</p>--}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tabs_item ">
                                                    <div class="courses-details-tab-content">
                                                        <div class="courses-details-into ms-2">
                                                            <h3>Course Routine</h3>
                                                            <div class="card">
                                                                    <div class="card-body">
                                                                        <table class="table table-striped" id="file-datatable">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>#</th>
                                                                                    <th>Topic</th>
                                                                                    <th>Date</th>
                                                                                    <th>Day</th>
                                                                                    <th>Time</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @if(isset($course->courseRoutines))
                                                                                    @php
                                                                                        $i=0
//                                                                                    @php($i = 0)
                                                                                     @endphp
                                                                                    @foreach($course->courseRoutines as $courseRoutine)
                                                                                        @if($courseEnrollStatus == 'true')
                                                                                            @if($courseRoutine->is_fack == 0)
                                                                                                <tr>
                                                                                                    <td>{{ ++$i }}</td>
                                                                                                    <td>{{ $courseRoutine->content_name }}</td>
                                                                                                    <td>{{ showDate($courseRoutine->date_time) }}</td>
                                                                                                    <td>{{ $courseRoutine->day }}</td>
                                                                                                    <td>{{ showTime($courseRoutine->date_time) }}</td>
                                                                                                </tr>
                                                                                            @endif
                                                                                        @else
                                                                                            @if($courseRoutine->is_fack == 1)
                                                                                                <tr>
                                                                                                    <td>{{ ++$i }}</td>
                                                                                                    <td>{{ $courseRoutine->content_name }}</td>
                                                                                                    <td>{{ showDate($courseRoutine->date_time) }}</td>
                                                                                                    <td>{{ $courseRoutine->day }}</td>
                                                                                                    <td>{{ showTime($courseRoutine->date_time) }}</td>
                                                                                                </tr>
                                                                                            @endif
                                                                                        @endif
                                                                                @endforeach
                                                                                 @endif
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--comment - has to work later--}}
                            <div class="comments-form">
                                <div class="contact-form">
                                    <h4>Leave a Reply</h4>
                                    <form id="" action="{{ route('front.new-comment') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="type" value="course">
                                        <input type="hidden" name="parent_model_id" value="{{ $course->id }}">
                                        <input type="hidden" name="name" value="{{ auth()->check() ? auth()->user()->name : '' }}">
                                        <input type="hidden" name="email" value="{{ auth()->check() ? auth()->user()->email : '' }}">
                                        <input type="hidden" name="mobile" value="{{ auth()->check() ? auth()->user()->mobile : '' }}">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="form-group">
                                                    <textarea name="message" class="form-control" id="" cols="30" rows="3" required placeholder="Write here..." required></textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <button type="submit"
                                                {{-- @if(!auth()->check()) onclick="event.preventDefault(); toastr.error('Please Login First');" @endif  --}}
                                                class="default-btn">
                                                    Submit
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>



                            {{--dynamic data--}}
                            @foreach($comments as $comment)
                                <div class="py-2">
                                    <div class="d-flex flex-row w-100">
                                        <div class="d-flex flex-column">
                                            <div class="com-img-box">
                                                @if(isset($comment->user->profile_photo_path))
                                                    <img src="{{ asset( isset($comment->user->profile_photo_path) ? $comment->user->profile_photo_path : '' ) }}" alt="user-image" class="comment-user-image">
                                                @else
                                                    <img src="https://www.vhv.rs/dpng/d/509-5096993_login-icon-vector-png-clipart-png-download-user.png" alt="user-image" class="comment-user-image">
                                                @endif
                                            </div>
                                        </div>

                                        <div class="d-flex flex-column bg-light ml-2 w-100 px-2">
                                            <p class="mb-0 f-s-20 ">{{ $comment->user->name }}</p>
                                            <p class="text-justify ps-3">{{ $comment->message }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach



                        </div>





                        <div class="col-lg-4 details_custom_mobile_none">
                            <div class="courses-details-sidebar shadow">
                                {{--                                <img src="{{ asset($course->banner) }}" alt="Courses" style="height: 240px" />--}}
                                @if(!empty($course->featured_video_url))
                                    <div class="video-container" >
                                        <div class="video-foreground">
                                            <iframe width="100%" height="315" src="https://www.youtube.com/embed/{!! $course->featured_video_url !!}?rel=0&amp;modestbranding=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"></iframe>
                                        </div>
                                    </div>
                                @else
                                    <img src="{{ asset(isset($course->banner) ? $course->banner : 'frontend/logo/biddabari-card-logo.jpg') }}" class="w-100 img-fluid" style="height: 315px" alt="{{ $course->alt_text }}" title="{{ $course->banner_title }}">
                                @endif
                                <div class="content">
                                    {{-- <h1>{!! $course->title !!}</h1> --}}
                                    <span class="f-s-22 sub-title">{!! $course->sub_title !!}</span> <br>
                                    <p class="f-s-20 pb-0" style="color:red">{!! 'Admission Last Date : '.showDate($course->admission_last_date) !!}</p>
                                    <div class="row">
                                        <div class="col-md-6">

                                            @if($course->discount_end_date > \Illuminate\Support\Carbon::today()->format('Y-m-d') && $course->discount_amount > 0)
                                                <p class="f-s-20">Price: <del>{{ $course->is_paid == 1 ? $course->price : 'Free' }}</del> tk</p>
                                                {{--                                                <p class="f-s-20">Discount Price: {{ $course->price - $course->discount_amount }} tk</p>--}}
                                                {{--                                                <p class="f-s-20">Discount Price: {{ $discountPrice = $course->discount_type == 1 ? $course->discount_amount : ($course->price * $course->discount_amount)/100 }} tk</p>--}}
                                                    <?php
                                                    $discountPrice = $course->discount_type == 1 ? $course->discount_amount : ($course->price * $course->discount_amount)/100;
                                                    ?>
                                                <p class="f-s-20 pb-0">After Discount: {{ $totalAmount = $course->price - $discountPrice ?? 0 }} tk</p>
                                            @else
                                                <p class="f-s-20 pb-0">Price: {{ $course->is_paid == 1 ? $course->price.' tk' : 'Free' }} </p>
                                            @endif
                                        </div>
                                    </div>
                                    {{--                                    <p>Already Enrolled Student: {{ $course->fack_student_count }}</p>--}}
                                    <span class="f-s-26">This course includes:</span>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="f-s-20 d-flex"><i class="ri-time-fill me-2"></i> {{ $course->total_hours ?? '' }} hr</div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="f-s-20 d-flex"><i class="ri-vidicon-fill me-2"></i> {{ $course->total_class ?? '' }} lectures</div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="f-s-20 d-flex"><i class="ri-a-b me-2"></i> {{ $course->total_exam ?? '' }} Exam</div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="f-s-20 d-flex"><i class="ri-store-3-line me-2"></i>{{ $course->total_live ?? '' }} live class</div>
                                        </div>
                                    </div>

                                    @if($course->is_paid == 1)
                                        @if($courseEnrollStatus == 'false')
                                            @php
                                                $date=date('Y-m-d H:i');
                                            @endphp
                                            @if($course->admission_last_date > $date)
                                                <a href="{{ route('front.checkout', ['type' => 'course', 'slug' => $course->slug, 'rc' => ($_GET['rc'] ?? '') ]) }}" class="default-btn bg-default-color mt-4">কোর্সটি কিনুন</a>
{{--                                                <form action="{{ route('front.place-course-order', ['course_id' => $course->id]) }}" method="post">--}}
{{--                                                    @csrf--}}
{{--                                                    <input type="hidden" name="course_id" value="{{ $course->id }}" />--}}
{{--                                                    <input type="hidden" name="total_amount" value="{{ $totalAmount ?? 0 }}" />--}}
{{--                                                    <input type="hidden" name="used_coupon" value="0">--}}
{{--                                                    <input type="hidden" name="coupon_code" value="">--}}
{{--                                                    <input type="hidden" name="coupon_amount" value="">--}}
{{--                                                    <input type="hidden" name="ordered_for" value="course">--}}
{{--                                                    <input type="hidden" name="rc" value="{{ $_GET['rc'] ?? '' }}">--}}
{{--                                                    <input type="hidden" name="payment_method" value="ssl">--}}
{{--                                                    <input type="submit" class="btn btn-warning" value="কোর্সটি কিনুন">--}}
{{--                                                </form>--}}
                                            @else
                                                <a class="default-btn bg-default-color btn-block mt-4">ভর্তির সময় শেষ</a>
                                            @endif

                                            <ul class="social-link">
                                            </ul>
                                        @elseif($courseEnrollStatus == 'pending')
                                            <a href="javascript:void(0)" class="default-btn bg-default-color mt-2">Your Order is Pending</a>
                                        @endif
                                    @else
                                        @if($courseEnrollStatus == 'false')
                                            @if(auth()->check())
                                                <a href="" data-course-id="{{ $course->id }}" onclick="event.preventDefault(); document.getElementById('freeCourseOrderForm').submit()" class="default-btn bg-default-color order-free-course">কোর্সটি করুন</a>
                                            @else
                                                <a href="{{ route('login') }}" data-course-id="{{ $course->id }}"  class="default-btn bg-default-color order-free-course">কোর্সটি করুন</a>
                                            @endif
                                            <form action="{{ route('front.place-free-course-order', ['course_id' => $course->id]) }}" method="post" id="freeCourseOrderForm">
                                                @csrf

                                                <input type="hidden" name="ordered_for" value="course">
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
@endsection

@push('style')
    <style>
        .video-container{
            width:100%!important;
            height:315px;
            overflow:hidden;
            position:relative;
        }
        .video-container iframe{
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        .video-container iframe{
            position: absolute;
            top: -60px;
            left: 0;
            width: 100%;
            /*height: calc(50% + 100px);*/
            height: 315px;
        }
        .video-foreground{
            pointer-events:auto;
        }

    </style>
    <style>
        /*review section*/
        .no-pad p {
            margin-bottom: 2px!important;
        }
        .comment-user-image {
            border-radius: 60%;
            width: 40px;
            height: 40px;
        }
        .com-img-box {
            /*height: 78px;*/
            width: 56px;
        }
        .main-comment p {
            margin-bottom: 2px!important;
        }
        .sub-replay p {
            margin-bottom: 2px !important;
        }
        .bb-1px {
            border-bottom: 1px solid black;
        }
    </style>
@endpush
@push('script')
    <script src="{{ asset('/') }}frontend/assets/js/page-js/product-comments.js"></script>


    <script>
        $(document).on('click', '.next', function () {
            event.preventDefault();
            var getClassDivOrder = $('.auth-div').find('[data-active="1"]').attr('data-order');
            var mobileNumber = $('.auth-div input[name="mobile"]').val();
            if (getClassDivOrder == 0)
            {


                $.ajax({
                    url: "{{ route('front.send-otp') }}",
                    method: "POST",
                    dataType: "JSON",
                    data: {mobile:mobileNumber},
                    success: function (data) {
                        console.log(data);
                        // if (data.status == 'success')
                        if (data.status == 'success')
                        {
                            $('.mobile-div').addClass('d-none').attr('data-active', '');

                            if (data.user_status == 'exist')
                            {
                                $('.password-div').removeClass('d-none').attr('data-active', 1);
                                $('.next').removeClass('next').addClass('submit').text('Login').attr('data-status', 'login');
                            } else if (data.user_status == 'not_exist')
                            {
                                $('.otp-div').removeClass('d-none').attr('data-active', 1);
                                toastr.success('You will get otp shortly. Please input Otp correctly.');
                            }


                        } else {
                            toastr.error('something went wrong. Please check your mobile Number & try again.');
                        }
                    }
                })
            } else if (getClassDivOrder == 1)
            {
                var otpNumber = $('#otpInput').val();

                $.ajax({
                    url: "{{ route('front.verify-otp') }}",
                    method: "POST",
                    dataType: "JSON",
                    data: {otp:otpNumber, mobile_number:mobileNumber},
                    success: function (data) {
                        console.log(data);
                        if (data.status == 'success')
                        {
                            $('.otp-div').addClass('d-none').attr('data-active', '');
                            if (data.user_status == 'exist')
                            {
                                $('.password-div').removeClass('d-none').attr('data-active', 1);
                                $('.next').removeClass('next').addClass('submit').text('Login').attr('data-status', 'login');
                            } else if (data.user_status == 'not_exist')
                            {
                                $('.name-div').removeClass('d-none').attr('data-active', 1);
                                $('.password-div').removeClass('d-none').attr('data-active', 1);
                                $('.next').removeClass('next').addClass('submit').text('Register').attr('data-status', 'register');
                            }
                            // $('#registerForm').submit();
                        } else {
                            console.log('something went wrong. Please try again.');
                        }
                    }
                })
            }
        })
        $(document).on('click', '.submit', function () {
            event.preventDefault();
            var formData = $('#authModalForm').serialize();
            var authStatus = $(this).attr('data-status');
            var ajaxUrl = '';
            if (authStatus == 'login')
            {
                ajaxUrl = "{{ route('login') }}";
            } else if (authStatus == 'register')
            {
                ajaxUrl = "{{ route('register') }}"
            }
            $.ajax({
                url: ajaxUrl,
                method: "POST",
                dataType: "JSON",
                data: formData,
                success: function (data) {
                    console.log(data);
                    if (data.status == 'success')
                    {
                        var courseId = $('.order-free-course').attr('data-course-id');
                        toastr.success('Your are successfully logged in.');
                        $('#freeCourseOrderForm').submit();
                        // window.location.href = base_url+'place-free-course-order/'+courseId;
                    } else if (data.status == 'error')
                    {
                        toastr.error('Something went wrong. Please try again');
                    }
                },
                error: function (errors) {
                    if (errors.responseJSON)
                    {

                        var allErrors = errors.responseJSON.errors;
                        for (key in allErrors)
                        {
                            $('#'+key).empty().append(allErrors[key]);
                        }
                    }
                }
            })
        })
    </script>

@endpush
