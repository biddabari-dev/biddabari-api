@extends('backend.master')

@section('title', 'Manage Order')

@section('body')
    <div class="row mt-5">
        <div class="col-sm-8 mx-auto">
            <div class="card card-body">
                <form action="" method="get">
{{--                    @csrf--}}
                    <div class="row" >
                        <div class="col-md-3">
                            <label for="">Date</label>
                            <input type="date" name="date" value="{{isset($_GET['date']) && $_GET['date'] != ''? $_GET['date']:''}}" class="form-control" id="" data-placeholder="">
                        </div>
                        <div class="col-md-7 select2-div">
                            <label for="">Available Courses</label>
{{--                            <input type="text" class="form-control" id="questionTopicInputField">--}}
{{--                            <input type="hidden" class="form-control" name="category_id" id="questionTopic">--}}
                            <select name="course_id" class="form-control select2" id="categoryId" data-placeholder="Select Course Category">
                                <option value=""></option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->title }}</option>

                                @endforeach
                            </select>
                        </div>

                        <div class="col-auto">
                            <input type="submit" class="btn btn-success ms-4 " style="margin-top: 18px" value="Search" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    @if(isset($courseOrders) && !empty($courseOrders))
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Manage Course Orders</h2>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table" id="file-datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Order No.</th>
                                    <th>Course Title</th>
{{--                                    <th>C.Image</th>--}}
{{--                                    <th>Price</th>--}}
{{--                                    <th>Discount</th>--}}
                                    <th>S. Name</th>
                                    <th>Payment</th>
{{--                                    <th>Paid</th>--}}
{{--                                    <th>Due</th>--}}
                                    <th>Payment Info</th>
{{--                                    <th>Vendor</th>--}}
{{--                                    <th>Paid Form</th>--}}
{{--                                    <th>Paid to</th>--}}
                                    <th>Txt Id</th>
                                    <th>Enroll Date</th>

{{--                                    <th>Payment Status</th>--}}
                                    <th>Payment & Contact Status</th>
{{--                                    <th>Order Status</th>--}}
{{--                                    <th>Contacted By</th>--}}
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(isset($courseOrders))
                                @foreach($courseOrders as $courseOrder)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><a href="" data-order-id="{{ $courseOrder->id }}" class="show-order-details">#{{ $courseOrder->order_invoice_number }}</a></td>
                                        <td>{{ $courseOrder->course->title ?? null}}</td>

                                        <td>{{ $courseOrder->user->name }} <br> {{ $courseOrder->user->mobile }}</td>
                                        <td>
                                            Total: {{ $courseOrder->total_amount }} <br>
                                            Paid: {{ $courseOrder->paid_amount ?? 0 }} <br>
                                            Due: {{ $courseOrder->total_amount - $courseOrder->paid_amount }}
                                        </td>
{{--                                        <td>{{ $courseOrder->paid_amount ?? 0 }}</td>--}}
{{--                                        <td>{{ $courseOrder->total_amount - $courseOrder->paid_amount }}</td>--}}
                                        <td>
                                            @if($courseOrder->payment_method == 'cod')
                                                Vendor- {{ $courseOrder->vendor }} <br>
                                                From- {{ $courseOrder->paid_from }} <br> To- {{ $courseOrder->paid_to }}
                                            @elseif($courseOrder->payment_method == 'ssl')
                                                TranId: {{ $courseOrder->bank_tran_id }} <br>
                                                ValId: {{ $courseOrder->gateway_val_id }} <br>
                                                GtStatus: {{ $courseOrder->gateway_status }} <br>
                                            @endif

                                        </td>

                                        <td>{{ $courseOrder->txt_id }}</td>
                                        <td>{{ $courseOrder->created_at->format('d M, Y') }}</td>
{{--                                        <td>{{ $courseOrder->payment_status }}</td>--}}
                                        <td>
                                            <a href="javascript:void(0)" class="badge bg-{{$courseOrder->payment_status !='complete' ? ($courseOrder->payment_status =='partial'?'warning':'danger'):'success'}} m-1">Payment {{ $courseOrder->payment_status }}</a>
{{--                                            <a href="javascript:void(0)" class="badge bg-primary m-1">Payment {{ $courseOrder->payment_status }}</a>--}}
                                            <br>
{{--                                            <a href="javascript:void(0)" class="badge bg-primary m-1">Contact {{ $courseOrder->contact_status }}</a><br>--}}
{{--                                            <a href="javascript:void(0)" class="badge bg-primary m-1">Order {{ $courseOrder->status }}</a>--}}
                                            <a href="javascript:void(0)" class="badge bg-{{$courseOrder->status=='approved' ? 'success':'danger'}} m-1">Order {{ $courseOrder->status }}</a>
                                        </td>

                                        <td>
                                            @can('update-course-order')
                                                <a href="" data-blog-category-id="{{ $courseOrder->id }}" class="btn btn-sm btn-warning blog-category-edit-btn mt-1" title="Change Order Status">
                                                    <i class="fa-solid fa-edit"></i>
                                                </a>
                                            @endcan
                                            <br>

                                            @can('delete-course-order')
                                                <form class="d-inline" action="{{ route('course-orders.destroy', $courseOrder->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-sm btn-danger mt-1 data-delete-form" title="Delete Blog Category">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                                @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
{{--                        {{ $courseOrders->links() }}--}}
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="modal fade modal-div" id="blogCategoryModal" data-modal-parent="blogCategoryModal" data-bs-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" id="">
                <form id="courseSectionForm" action="" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="">Update Course Order Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body">

                        <div class="card card-body">
                            @csrf
                            @method('put')
{{--                            <input type="hidden" id="courseIdEdit" name="edit_course_id" />--}}
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="paidAmount">Paid Amount</label>
                                    <input type="text" class="form-control" required name="paid_amount" placeholder="Paid Amount" />
                                    <span class="text-danger" id="paid_amount"></span>
                                </div>
                                <div class="col-sm-6 select2-div">
                                    <label for="paymentStatus">Payment Status</label>
                                    <select name="payment_status" class="form-control select2" id="paymentStatus" data-placeholder="Set Payment Status">
                                        <option value=""></option>
                                        <option value="pending">Pending</option>
                                        <option value="partial">Partial</option>
                                        <option value="complete">Complete</option>
                                    </select>
                                </div>

                                <div class="col-sm-6 select2-div">
                                    <label for="paymentStatus">Order Status</label>
                                    <select name="status" class="form-control select2" id="paymentStatus" data-placeholder="Set Order Status">
                                        <option value=""></option>
                                        <option value="pending">Pending</option>
                                        <option value="approved">Approved</option>
                                        <option value="canceled">Canceled</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary " value="save">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade modal-div" id="contactStatusModal" data-modal-parent="blogCategoryModal" data-bs-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" id="">
                <form id="contactStatusForm" action="" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="">Update Course Order Contact Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="card card-body">
                            @csrf
{{--                            <input type="hidden" id="courseIdEdit" name="edit_course_id" />--}}
                            <div class="row">
                                <div class="col-sm-6 select2-div">
                                    <label for="paymentStatus">Contact Status</label>
                                    <select name="contact_status" class="form-control select2" id="paymentStatus" data-placeholder="Set Contact Status">
                                        <option value=""></option>
                                        <option value="pending">Pending</option>
                                        <option value="not_answered">Not Answered</option>
                                        <option value="confirmed">Confirmed</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary " value="save">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade modal-div" id="courseDetailsModal" data-modal-parent="blogCategoryModal" data-bs-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" id="">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Course Order Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="card card-body" id="courseDetailsCard">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="questionTopicModal" data-bs-backdrop="static" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-secondary">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Select Course Categories</h1>
                    <button type="button" class="btn-close close-topic-modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="" id="">
                        @if(isset($courseCategories))
                            @foreach($courseCategories as $key => $courseCategory)
                                <div class="parent-div ">
                                    <div class="card card-body bg-transparent shadow-0 mb-2 p-1">
                                        <ul class="nav mb-0">
                                            @if(count($courseCategory->courseCategories) > 0)
                                                <li class="drop-icon f-s-15" style="cursor: pointer" data-id="{{ $courseCategory->id }}"><i class="fa-solid fa-circle-arrow-down"></i></li>
                                            @else
                                                <li class="ms-3"></li>
                                            @endif
                                            <li><label class="mb-0 f-s-15 ms-2"><input type="checkbox" class="check" value="{{ $courseCategory->id }}">{{ $courseCategory->name }}</label></li>
                                        </ul>
                                    </div>
                                    @if(!empty($courseCategory))
                                        @if(count($courseCategory->courseCategories) > 0)
                                            @include('backend.course-management.course.courses.course-category-loop', ['courseCategory' => $courseCategory, 'child' => 15])
                                        @endif
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
{{--                <div class="modal-footer">--}}
{{--                    <button type="button" class="btn btn-secondary close-topic-modal" >Close</button>--}}
{{--                    <button type="button" class="btn btn-primary" id="okDone">Save</button>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
@endsection

@push('script')

    @include('backend.includes.assets.plugin-files.datatable')

{{--        @include('backend.includes.assets.plugin-files.date-time-picker')--}}
{{--        @include('backend.includes.assets.plugin-files.editor')--}}

    {{--    edit course category--}}
{{--@include('backend.includes.assets.plugin-files.datatable')--}}
{{--@include('backend.includes.assets.plugin-files.editor')--}}

    <script>
        $(document).on('click', '.blog-category-edit-btn', function () {
            event.preventDefault();
            var courseId = $(this).attr('data-blog-category-id'); //change value
            $.ajax({
                url: base_url+"course-orders/"+courseId+"/edit",
                method: "GET",
                dataType: "JSON",
                success: function (data) {
                    console.log(data);
                    if (data.paid_amount > 0)
                    {
                        $('input[name="paid_amount"]').val(data.paid_amount);
                    } else {
                        $('input[name="paid_amount"]').val(data.total_amount);
                    }
                    $('input[name="paid_amount"]').attr('data-total-amount', data.total_amount);
                    $.each($('select[name="payment_status"] option'), function (paymentIndex, payment) {
                        if ($(this).val() == data.payment_status)
                        {
                            $(this).attr('selected', true);
                        }
                    })
                    $.each($('select[name="contact_status"] option'), function (contactIndex, contact) {
                        if ($(this).val() == data.contact_status)
                        {
                            $(this).attr('selected', true);
                        }
                    })
                    $.each($('select[name="status"] option'), function (statusIndex, status) {
                        if ($(this).val() == data.status)
                        {
                            $(this).attr('selected', true);
                        }
                    })
                    $(".select2").select2({
                        minimumResultsForSearch: "",
                        width: "100%",

                    })
                    $('#courseSectionForm').attr('action', base_url+"course-orders/"+courseId);
                    $('#blogCategoryModal').modal('show');
                }
            })
        })
        $(document).on('submit', $('#courseSectionForm'), function () {

            var totalAmount = Number($('input[name="paid_amount"]').attr('data-total-amount'));
            var paidAmount = Number($('input[name="paid_amount"]').val());
            if (paidAmount > totalAmount)
            {
                $('#paid_amount').text('Paid Amount can\'t be bigger then course Total amount.')
                return false;
            }
        })
    </script>
    <script>
        $(document).on('click', '.blog-category-edit-btnx', function () {
            event.preventDefault();
            var courseId = $(this).attr('data-blog-category-id'); //change value
            $.ajax({
                url: base_url+"course-orders/"+courseId+"/edit",
                method: "GET",
                dataType: "JSON",
                success: function (data) {
                    // console.log(data);
                    $.each($('select[name="contact_status"] option'), function (contactIndex, contact) {
                        if ($(this).val() == data.contact_status)
                        {
                            $(this).attr('selected', true);
                        }
                    })
                    $(".select2").select2({
                        minimumResultsForSearch: "",
                        width: "100%",

                    })
                    $('#contactStatusForm').attr('action', base_url+"course-orders/status/"+courseId);
                    $('#contactStatusModal').modal('show');
                }
            })
        })
    </script>
    <script>
        $(document).on('change', '#categoryId', function () {
            event.preventDefault();
            var categoryId = $(this).val(); //change value
            $.ajax({
                url: base_url+"get-courses-by-category/"+categoryId,
                method: "GET",
                dataType: "JSON",
                success: function (data) {
                    console.log(data);
                    console.log('data');
                    var option = '';
                    option += '<option value=""></option>';
                    $.each(data, function (key, value) {
                        option += '<option value="'+value.id+'">'+value.title+'</option>';
                    })
                    $(".select2").select2({
                        minimumResultsForSearch: "",
                        width: "100%",

                    })
                    $('.show-hide-exam-div').removeClass('d-none').css('transition', '1s');
                    $('#courseId').empty().append(option);
                }
            })
        })
        $(document).on('click', '.show-order-details', function () {
            event.preventDefault();
            var orderId = $(this).attr('data-order-id'); //change value
            $.ajax({
                url: base_url+"get-course-order-details/"+orderId,
                method: "GET",
                // dataType: "JSON",
                success: function (data) {
                    console.log(data);
                    $('#courseDetailsCard').empty().append(data);
                    $('#courseDetailsModal').modal('show');
                }
            })
        })
    </script>

    {{--    set value to input fields from modal start--}}
    <script>
        var ids = [];
        var topicNames = '';
        $(document).on('click', '#questionTopicInputField', function () {
            $('#questionTopicModal').modal('show');
            // $('#questionTopicModal').css('display', 'block');
        })
        $(document).on('click', '.check', function () {
            var existVal = $(this).val();
            var topicName = $(this).parent().text();
            // console.log(existVal);
            // console.log(topicName);
            if ($(this).is(':checked'))
            {
                // if (!ids.includes(existVal))
                // {
                //     ids.push(existVal);
                //     topicNames += topicName+',';
                //
                // }
                $('#questionTopic').val(existVal);
                $('#questionTopicInputField').val(topicName);
                $('#questionTopicModal').modal('hide');
                alert($('#questionTopic').val())
            } else {
                // if (ids.includes(existVal))
                // {
                //     ids.splice(ids.indexOf(existVal), 1);
                //     topicNames = topicNames.replace(topicName+',','');
                //     // topicNames = topicNames.split(topicName).join('');
                // }
                $('#questionTopic').val('');
            }
        })
        $(document).on('click', '#okDone', function () {
            $('#questionTopicInputField').val(topicNames.slice(0, -1));
            $('#questionTopic').val(ids);
            $('#questionTopicModal').modal('hide');
        })
    </script>
    {{--    set value to input fields from modal ends--}}
    <!--show hide test start-->
    <script>
        $(document).on('click', '.drop-icon', function () {
            var dataId = $(this).attr('data-id');
            if ($(this).find('fa-circle-arrow-down'))
            {
                $(this).html('<i class="fa-solid fa-circle-arrow-up"></i>');
            }
            if($(this).find('fa-circle-arrow-up')) {
                $(this).html('<i class="fa-solid fa-circle-arrow-down"></i>');
            }
            if($('.childDiv'+dataId).hasClass('d-none'))
            {
                $('.childDiv'+dataId).removeClass('d-none');
            } else {
                $('.childDiv'+dataId).addClass('d-none');
            }
        })
        $(document).on('click', '.close-topic-modal', function () {
            $('#questionTopicModal').modal('hide');
        })
    </script>
    <!--show hide test end-->
@endpush
