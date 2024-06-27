@extends('frontend.master')

@section('body')
    <div class="courses-area-two section-bg py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link f-s-26 active" id="" data-bs-toggle="pill" data-bs-target="#freeCourses" type="button" role="tab" aria-controls="pills-home" aria-selected="true">ফ্রি কোর্সসমূহ</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link f-s-26" id="" data-bs-toggle="pill" data-bs-target="#freeExams" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">ফ্রি পরীক্ষা সমূহ</button>
                        </li>
                    </ul>
                    <style>
                        .a .courses-item {padding-right: 50px;}
                    </style>
                    <div class="tab-content mt-4" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="freeCourses" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="row a">
                                @forelse($courses as $course)
                                    <div class="col-md-4 col-sm-6">
                                        <div class="courses-item">
                                            <a href="{{ route('front.course-details', ['slug' => $course->slug]) }}">
                                                <img src="{{ file_exists_obs($course->banner) ? asset($course->banner) : asset('frontend/logo/biddabari-card-logo.jpg') }}" alt="{{ $course->alt_text }}" title="{{ $course->banner_title }}" class="w-100" style="height: 230px"/>

                                                <div class="content">
                                                    <h3>{{ $course->title }}</h3>
                                                    <div class="bottom-content">
                                                        <button type="button" class="btn btn-warning">বিস্তারিত দেখুন</button>
                                                        <div class="rating ">
                                                            <button type="button" class="btn btn-warning">Free</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-md-12">
                                        <div class="card card-body">
                                            <h2 class="text-center">No Courses Available yet.</h2>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="tab-pane fade" id="freeExams" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <div class="row mt-3">
                                @forelse($batchExams as $batchExam)
                                    <div class="col-md-4 col-sm-6 open-modal" data-xm-id="{{ $batchExam->id }}" style="cursor: pointer;">
                                        <div class="courses-item">
                                            <a href="" class="w-100">
                                                <img src="{{ isset($batchExam->banner) ? asset($batchExam->banner) : asset('frontend/logo/biddabari-card-logo.jpg') }}" alt="Courses" class="w-100" style="height: 230px"/>
                                                <div class="content">
                                                    <h3>{{ $batchExam->title }}</h3>
                                                    <div class="bottom-content">
                                                        <button type="button" class="btn btn-warning">বিস্তারিত দেখুন</button>
                                                        <div class="rating ">
                                                            <button type="button" class="btn btn-warning">Free</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-md-12">
                                        <div class="card card-body">
                                            <h2 class="text-center">No Exams Available yet.</h2>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Order Exams</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="printHere">
                    <div class="courses-details-area p-b-20">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-7">
                                    <div class="card card-body">
                                        <div class="text-center">
                                            <img style="max-height: 250px" id="xmImage" src="{{ asset('frontend/logo/biddabari-card-logo.jpg') }}" alt="exam-image-text" class="img-fluid" />
                                        </div>
                                        <div class="mt-3">
                                            <h2 id="catName">Category Name</h2>
                                            <div class="row mt-2 xm-details-row">

                                                <div class="col-md-12">
                                                    <span id="description"></span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="" >
                                        <div id="checkEnroll">
                                            <form action="" id="xmCardForm" method="post" enctype="multipart/form-data">
                                                @csrf
{{--                                                <input type="hidden" name="total_amount" id="totalAmount" />--}}
                                                <input type="hidden" name="ordered_for" value="batch_exam" />
                                                <div class="payment-box">

                                                    @if(auth()->check())
                                                        <button type="submit" class="default-btn">Enroll Now</button>
                                                    @else
                                                        <a href="javascript:void(0)" class="default-btn" data-bs-toggle="modal" data-bs-target="#authModal">Enroll Now</a>
                                                    @endif
                                                </div>
                                            </form>
                                        </div>
                                        <div class="msgPrint">

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
@endsection

@push('style')
    <style>
        .xm-details-row p{
            font-size: 25px!important;
        }
        .xm-payment-div p{
            font-size: 20px!important;
        }
    </style>
@endpush

@section('js')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @if($errors->any())
        <script>
            $(function () {
                $('#staticBackdrop').modal('show');
            })
        </script>
    @endif
    <script>
        $(function () {
            $('.select2').select2();

        })
    </script>
    <script>
        $(document).on('click', '.open-modal', function (e) {
            e.preventDefault();
            var xmId = $(this).attr('data-xm-id');
            {{--            @if(auth()->check())--}}
            $.ajax({
                url: base_url+"category-exams/"+xmId,
                method: "GET",
                success: function (data) {
                    console.log(data);
                    if ( data.exam.banner != null)
                    {
                        $('#xmImage').attr('src', data.exam.banner);
                    } else {
                        alert('sdf');
                        $('#xmImage').attr('src', base_url+'frontend/logo/biddabari-card-logo.jpg');
                    }
                    $('#catName').text(data.exam.title);
                    $('#price').text(data.exam.price);
                    $('#description').html(data.exam.description);

                    $('#xmCardForm').attr('action', base_url+'place-free-course-order/'+xmId);



                    if (data.enrollStatus == 'true' || data.enrollStatus == 'pending')
                    {
                        if (!$('#checkEnroll').hasClass('d-none'))
                        {
                            $('#checkEnroll').addClass('d-none');
                            $('.msgPrint').html('<p class="fw-bolder f-s-22">You already enrolled this Exam.</p>');
                        }
                    } else {
                        if ($('#checkEnroll').hasClass('d-none'))
                        {
                            $('#checkEnroll').removeClass('d-none');
                            $('#msgPrint').empty();
                        }
                    }
                    $('#staticBackdrop').modal('show');
                }
            })
            {{--            @else--}}
            //                 toastr.error('Please login first');
            {{--            @endif--}}
        })
        $(document).on('click', '.select-package', function () {
            var sellPrice = $(this).attr('data-package-sell-price');
            $('#totalAmount').val(sellPrice);
        })
    </script>
    <script>
        $(function () {
            showHidePaymentMethod();
        })
        $(document).on('click', 'input[name="payment_method"]', function () {
            showHidePaymentMethod();
        });
        function showHidePaymentMethod() {
            var paymentMethod = $('input[name="payment_method"]:checked').val();
            if (paymentMethod == 'cod')
            {
                if ($('.payment-cod').hasClass('d-none'))
                {
                    $('.payment-cod').removeClass('d-none');
                }

            } else if (paymentMethod == 'ssl')
            {
                $('.payment-cod').addClass('d-none');
            }
        }
    </script>
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



                            // $('.otp-div').removeClass('d-none').attr('data-active', 1);
                            // toastr.success('You will get otp shortly. Please input Otp correctly.');
                            // $('.mobile-div').addClass('d-none').attr('data-active', '');
                            // $('.otp-div').removeClass('d-none').attr('data-active', 1);
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
                        $('#xmCardForm').submit();
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
@endsection
