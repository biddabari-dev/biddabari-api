@extends('backend.master')

@section('title', 'Course Coupons')

@section('body')
    <div class="row py-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">Course Coupons</h4>
                    <a href="{{ route('courses.index') }}" title="Back to Courses" class="rounded-circle text-white border-5 f-s-22 btn position-absolute end-0 m-r-50"><i class="fa-solid fa-arrow-left"></i></a>
                    @can('create-course-coupon')
                        <button type="button" data-bs-toggle="modal" data-bs-target="#coursesModal" class="rounded-circle text-white border-5 f-s-22 btn position-absolute end-0 me-4"><i class="fa-solid fa-circle-plus"></i></button>
                    @endcan
                </div>
                <div class="card-body">
                    <table class="table" id="file-datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Code</th>
                                <th>Discount Type</th>
                                <th>Coupon Value</th>
                                <th>Expire Date</th>
                                <th>Usage time start</th>
{{--                                <th>Usage time end</th>--}}
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($courseCoupons))
                                @foreach($courseCoupons as $courseCoupon)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $courseCoupon->code }}</td>
                                        <td>{{ $courseCoupon->type }}</td>
                                        <td>{{ $courseCoupon->type == 'Flat' ? ' ৳ '.$courseCoupon->discount_amount : $courseCoupon->percentage_value.'%' }}</td>
                                        <td>{{ $courseCoupon->expire_date_time }}</td>
                                        <td>{{ $courseCoupon->available_from }}</td>
{{--                                        <td>{{ $courseCoupon->avaliable_to }}</td>--}}
                                        <td>
                                            @can('edit-course-coupon')
                                                <a href="" data-course-coupon-id="{{ $courseCoupon->id }}" class="btn btn-sm btn-warning edit-btn" title="Edit Course Coupon">
                                                    <i class="fa-solid fa-edit"></i>
                                                </a>
                                            @endcan
                                            @can('delete-course-coupon')
                                                <form class="d-inline" action="{{ route('course-coupons.destroy', $courseCoupon->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-sm btn-danger data-delete-form" title="Delete Course Coupon">
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
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-div" id="coursesModal" data-bs-backdrop="static" data-modal-parent="coursesModal" >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" id="modalForm">
                @include('backend.course-management.course.course-coupons.form')
            </div>
        </div>
    </div>
@endsection
@push('style')
    <!-- DragNDrop Css -->
{{--    <link href="{{ asset('/') }}backend/assets/css/dragNdrop.css" rel="stylesheet" type="text/css" />--}}
    <style>
        .datetimepicker {z-index: 100009!important;}
    </style>
@endpush

@push('script')
    @if($errors->any())
        <script>
            $(function () {
                $('#coursesModal').modal('show');
            })
        </script>
    @endif
{{--    datatable--}}
@include('backend.includes.assets.plugin-files.datatable')

{{--date-time-picker--}}
{{--@include('backend.includes.assets.plugin-files.date-time-picker')--}}
    <script src="{{ asset('/') }}backend/assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js"></script>
<script>
    $(function () {
        // $('#dateTime1').bootstrapMaterialDatePicker({
        //     format: 'YYYY-MM-DD HH:mm'
        // });
        // $('#dateTime2').bootstrapMaterialDatePicker({
        //     format: 'YYYY-MM-DD HH:mm'
        // });
        $('input[data-dtp="dtp_Nufud"]').val(currentDateTime);
        $("#dateTime").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
        $("#dateTime1").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
        $("#dateTime2").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
    });
</script>
    {{--    store course--}}
    <script>
        $(document).on('click', '.submit-btn', function () {
            event.preventDefault();
            var form = $('#coursesForm')[0];
            var formData = new FormData(form);
            $.ajax({
                url: "{{ route('course-coupons.store') }}",
                method: "POST",
                data: formData,
                dataType: "JSON",
                contentType: false,
                processData: false,
                success: function (message) {
                    // console.log(message);
                    toastr.success(message);
                    $('#coursesModal').modal('hide');
                    window.location.reload();
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

{{--    edit course category--}}
    <script>
        $(document).on('click', '.edit-btn', function () {
            event.preventDefault();
            var courseId = $(this).attr('data-course-coupon-id');
            $.ajax({
                url: base_url+"course-coupons/"+courseId+"/edit",
                method: "GET",
                // dataType: "JSON",
                success: function (data) {
                    console.log(data);
                    $('#modalForm').empty().append(data);
                    // $('#dateTime').bootstrapMaterialDatePicker({
                    //     format: 'YYYY-MM-DD HH:mm'
                    // });
                    // $('#dateTime1').bootstrapMaterialDatePicker({
                    //     format: 'YYYY-MM-DD HH:mm'
                    // });
                    // $('#dateTime2').bootstrapMaterialDatePicker({
                    //     format: 'YYYY-MM-DD HH:mm'
                    // });

                    $("#dateTime").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
                    $("#dateTime1").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
                    $("#dateTime2").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});

                    $('#coursesModal').modal('show');
                },

            })
        })
    </script>
{{-- update course category--}}
    <script>
        $(document).on('click', '.update-btn', function () {
            event.preventDefault();
            // var formData = $('#coursesForm').serialize();
            var form = $('#coursesForm')[0];
            var formData = new FormData(form);
            $.ajax({
                url: $('#coursesForm').attr('action'),
                method: "POST",
                data: formData,
                // dataType: "JSON",
                // async: false,
                // cache: false,
                contentType: false,
                processData: false,
                // enctype: 'multipart/form-data',
                success: function (message) {
                    // console.log(formData);
                    toastr.success(message);
                    // $('.update-btn').addClass('submit-btn').removeClass('update-btn');
                    $('#courseCategoryForm').attr('action', '');
                    $('#courseCategoryModal').modal('hide');
                    window.location.reload();
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
    <script>
        $(document).on('click', '.modal-trigger-btn', function () {
            event.preventDefault();
            resetInputFields();
            $('#coursesModal').modal('show');
        })
    </script>

    <script>
        $(document).on('keyup', 'input,textarea', function () {
            var selectorId = $(this).attr('name');
            if ($('#'+selectorId).text().length)
            {
                $('#'+selectorId).text('');
            }
        })
        $(document).on('change', 'select', function () {
            var selectorId = $(this).attr('name');
            if ($('#'+selectorId).text().length)
            {
                $('#'+selectorId).text('');
            }
        })
    </script>

    <script>
        $(document).ready(function() {
            $('#categoryImage').change(function() {
                var imgURL = URL.createObjectURL(event.target.files[0]);
                $('#imagePreview').attr('src', imgURL).css({
                    height: 150+'px',
                    width: 150+'px',
                    marginTop: '5px'
                });
            });
        });
    </script>
@endpush
