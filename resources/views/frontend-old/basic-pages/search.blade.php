@extends('frontend.master')

@section('body')
    {{\Illuminate\Support\Facades\Session::put('course_redirect_url',\Illuminate\Support\Facades\Request::url())}}
    <div class="courses-area-two section-bg py-5 bg-white">
        <div class="container">
            <div class="col-md-12">
                <div class="card card-body border-0 rounded-0">
                    <div class="text-center mb-5">
                        <a href="" class="btn border-main-color"><span class="fw-bolder fs-2">Search Results</span></a>
                    </div>
                    <div>
                        <ul class="nav nav-pills all-course-page-nav-pills text-center">
                            <li class="nav-item mb-3"><button type="button" class="nav-link active border-danger btn py-0 mx-2 text-dark " style="border: 1px solid #F18C53" data-bs-toggle="pill" data-bs-target="#allCourses" ><span class="f-s-25">Courses</span></button></li>
                            <li class="nav-item mb-3"><button type="button" class="nav-link border-danger btn py-0 mx-2 text-dark" style="border: 1px solid #F18C53" data-bs-toggle="pill" data-bs-target="#allExams"><span class="f-s-25">Batch Exams</span></button></li>
                        </ul>
                        <div class="tab-content mt-5">
                            <div class="tab-pane px-1 fade show active" id="allCourses">
                                <div class="row">
                                    @if(!empty($courses))
                                        @if(isset($courses))
                                            @foreach($courses as $courseIndex => $singleCourse)
                                                @include('frontend.courses.include-courses-course', ['course' => $singleCourse])
                                            @endforeach
                                        @else
                                            <div class="col-md-4">
                                                <p>No courses found</p>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="tab-pane px-1 fade show" id="allExams">
                                <div class="row">
                                    @if(!empty($batchExams))
                                        @if(count($batchExams) > 0)
                                            @foreach($batchExams as $batchExam)
                                                @include('frontend.exams.xm.include-batch-exams', $batchExam)
                                            @endforeach
                                        @else
                                            <div class="col-md-4">
                                                <p>No Batch Exams found</p>
                                            </div>
                                        @endif
                                    @endif
                                </div>
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
                                            <h2 id="catName">catName</h2>
                                            <div class="row mt-2 xm-details-row">

                                                <div class="col-md-12">
                                                    <span id="description"></span>
                                                </div>
                                                <div class="col-md-12 mt-3" id="xmPackages">
                                                    <table class="table table-borderless">
                                                        <thead>
                                                        <tr>
                                                            <th>Package Name</th>
                                                            <th>Price</th>
                                                            <th>Duration</th>
                                                            <th>Discount</th>
                                                            <th>Valid Till</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td>Package One</td>
                                                            <td>Price: 100Tk</td>
                                                            <td>Duration: 100Tk</td>
                                                            <td>Discount: 100Tk</td>
                                                            <td>Valid Till: 22-23-5</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Package One</td>
                                                            <td>Price: 100Tk</td>
                                                            <td>Duration: 100Tk</td>
                                                            <td>Discount: 100Tk</td>
                                                            <td>Valid Till: 22-23-5</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="card card-body" >
                                        <div id="checkEnroll">
                                            <form action="" id="xmCardForm" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="total_amount" id="totalAmount" />
                                                <input type="hidden" name="ordered_for" value="batch_exam" />
                                                <input type="hidden" name="rc" value="{{ $_GET['rc'] ?? '' }}" />
                                                <div class="payment-box">
                                                    <div class="payment-method">
                                                        <h3>Payment Method</h3>
                                                        <p>
                                                            <input type="radio" id="paypal" name="payment_method" value="ssl">
                                                            <label for="paypal">SSLCommerz</label>
                                                        </p>
                                                        <p>
                                                            <input type="radio" id="direct-bank-transfer" value="cod" name="payment_method" checked>
                                                            <label for="direct-bank-transfer">Manual Payment</label>
                                                        </p>
                                                    </div>
                                                    <div class="mt-2">
                                                        <h3>Select a Package</h3>
                                                        <div class="" id="selectPackages">

                                                        </div>
                                                    </div>
                                                    <div class="payment-des-parent-div">
                                                        <div class="payment-cod d-none xm-payment-div">
                                                            <p>ম্যানুয়াল পেমেন্ট করলে আমাদের <span>বিকাশ মার্চেন্ট</span> নাম্বারে টাকা পাঠাতে হবে। <br><span>01896 060888</span></p>
                                                            <p>রকেট এ পাঠাতে চাইলে <span>রকেট মার্চেন্ট</span> পাঠাতে হবে। <br><span>01963 929208</span></p>
                                                            <p>নগদ এ পাঠাতে চাইলে <span>নগদ মার্চেন্ট</span> নাম্বারে টাকা পাঠাতে হবে। <br><span>01896 060828</span></p>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label for="paidTo">Paid To</label>
                                                                    <input type="number" id="paidTo"  name="paid_to" class="form-control" placeholder="Paid To" />
                                                                    <span class="text-danger">{{ $errors->has('paid_to') ? $errors->first('paid_to') : '' }}</span>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="paidForm">Paid Form</label>
                                                                    <input type="number" id="paidForm"  name="paid_from" class="form-control" placeholder="Paid Form" />
                                                                    <span class="text-danger">{{ $errors->has('paid_from') ? $errors->first('paid_from') : '' }}</span>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="transactionId">Transaction Id</label>
                                                                    <input type="text" id="transactionId"  name="txt_id" class="form-control" placeholder="Transaction Id" />
                                                                    <span class="text-danger">{{ $errors->has('txt_id') ? $errors->first('txt_id') : '' }}</span>
                                                                </div>
                                                                <div class="col-md-6 select2-div">
                                                                    <label for="vendor">Vendor</label>
                                                                    <select name="vendor" id="vendor" class="form-control">
                                                                        <option value="" selected disabled>Select a Vendor</option>
                                                                        <option value="bkash">Bkash</option>
                                                                        <option value="nagad">Nagad</option>
                                                                        <option value="rocket">Rocket</option>
                                                                    </select>
                                                                    <span class="text-danger">{{ $errors->has('vendor') ? $errors->first('vendor') : '' }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if(auth()->check())
                                                        <button type="submit" class="default-btn">Place Order</button>
                                                    @else
                                                        <button type="button" onclick="toastr.error('Please Login First To Order this exam.')" class="default-btn">Place Order</button>
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
    <style>
        #textContainer {
            overflow: hidden;
        }

        #additionalText {
            display: none;
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
            @if(isset($_GET['rc']) && isset($_GET['bxid']) && $_GET['bxid'] != '' && $_GET['rc'] != '')

            batchExamDetailsShowModal({!! $_GET['bxid'] !!})
            @endif
        })
    </script>

    <script>
        $(document).on('click', '.open-modal', function () {
            var xmId = $(this).attr('data-xm-id');
            batchExamDetailsShowModal(xmId);
        })
        function batchExamDetailsShowModal(xmId)
        {
            $.ajax({
                url: base_url+"category-exams/"+xmId,
                method: "GET",
                success: function (data) {
                    console.log(data);
                    if ( data.exam.banner != null)
                    {
                        $('#xmImage').attr('src', data.exam.banner);
                    } else {
                        $('#xmImage').attr('src', base_url+'frontend/logo/biddabari-card-logo.jpg');
                    }
                    $('#catName').text(data.exam.title);
                    $('#price').text(data.exam.price);
                    $('#description').html(data.exam.description);

                    $('#xmCardForm').attr('action', base_url+'student/order-exam/'+xmId);

                    var div = '';
                    div += '<h3 class="text-center">Available Packages for this Exam</h3>\n' +
                        '                                                    <div class="row">\n';
                    $.each(data.exam.batch_exam_subscriptions, function (key, val) {
                        div += '<div class="col-md-6 mt-3">\n' +
                            '<div class="card card-body">\n' +
                            '<img src="'+base_url+'frontend/logo/biddabari-card-logo.jpg" alt="" class="card-img-top" style="height: 150px">\n'+
                            '       <h3 class="f-s-30">'+val.package_title+'</h3>\n' +
                            '       <p class="f-s-20 p-0 m-0">RegularPrice: <span class="f-s-24">'+val.price+'</span> Tk</p>\n' +
                            '       <p class="f-s-20 p-0 m-0">Duration: <span class="f-s-24">'+val.package_duration_in_days+'</span> Days</p>\n';
                        if(val.discount_amount > 0 && val.discount_amount != null)
                        {
                            div += '       <p class="f-s-20 p-0 m-0">Discount: <span class="f-s-24">'+val.discount_amount+'</span> Tk</p>\n' +
                                '       <p class="f-s-20 p-0 m-0">Current Price: <span class="f-s-24">'+(val.price - val.discount_amount)+'</span> Tk</p>\n' +
                                '       <p class="f-s-20 p-0 m-0">Valid Till: '+val.discount_end_date.split(" ")[0]+'</p>\n' ;
                        }

                        div += '   </div>\n'+
                            '   </div>\n';
                    })
                    div += '                                                    </div>';
                    $('#xmPackages').empty().append(div);
                    var label = '';
                    $.each(data.exam.batch_exam_subscriptions, function (index, value) {
                        if (index == 0)
                        {
                            label += '<label for="pak'+index+'" class=""><input type="radio" class="select-package" checked name="batch_exam_subscription_id" data-package-sell-price="'+(value.price - value.discount_amount)+'" value="'+value.id+'" id="pak'+index+'"> <span class="f-s-23"> &nbsp;'+value.package_title+' ('+(value.price - value.discount_amount)+'tk for '+value.package_duration_in_days+' days)</span></label><br/>';
                            $('#totalAmount').val(value.price - value.discount_amount);
                        } else {

                            label += '<label for="pak'+index+'" class=""><input type="radio" class="select-package" name="batch_exam_subscription_id" data-package-sell-price="'+(value.price - value.discount_amount)+'" value="'+value.id+'" id="pak'+index+'"> <span class="f-s-23"> &nbsp;'+value.package_title+' ('+(value.price - value.discount_amount)+'tk for '+value.package_duration_in_days+' days)</span></label><br/>';
                        }
                    });
                    $('#selectPackages').empty().append(label);

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
        }
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
        $(document).ready(function() {
            var mainText = $('#mainText');
            var additionalText = $('#additionalText');
            var seeMoreButton = $('#seeMore');
            var seeLessButton = $('#seeLess');

            // Show additional text when "See More" is clicked
            seeMoreButton.on('click', function() {
                additionalText.show();
                seeMoreButton.hide();
                seeLessButton.show();
            });

            // Hide additional text when "See Less" is clicked
            seeLessButton.on('click', function() {
                additionalText.hide();
                seeMoreButton.show();
                seeLessButton.hide();
            });
        });
    </script>
@endsection
