@extends('backend.master')

@section('title', 'Courses')

@section('body')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">Courses</h4>
                    @can('create-course')
                        <button type="button" data-bs-toggle="modal" data-bs-target="#coursesModal"
                                class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4 open-modal">
                            <i class="fa-solid fa-circle-plus"></i></button>
                    @endcan
                    <button type="button" data-bs-toggle="modal" data-bs-target="#jsonImport"
                            class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 m-r-50 ">
                        <i class="fa-solid fa-arrow-alt-circle-up"></i></button>
                </div>
                <div class="card-body">
                    <form action="" method="get">
                        {{--                                            @csrf--}}
                        <div class="row pb-5 pt-3">
                            <div class="col-md-6 mx-auto card card-body">
                                <div class="row">
                                    <div class="col select2-div">
                                        <label for="">Course Category </label>
                                        {{--                                        <select name="category_id" class="form-control select2" id="categoryId" data-placeholder="Select Course Category">--}}
                                        {{--                                            <option value=""></option>--}}
                                        {{--                                            @foreach($courseCategories as $courseCategory)--}}
                                        {{--                                                <option value="{{ $courseCategory->id }}">{{ $courseCategory->name }}</option>--}}
                                        {{--                                            @endforeach--}}
                                        {{--                                        </select>--}}


                                        <select name="category_id" class="form-control select2" id="courseCategories"
                                                data-placeholder="Select Course Categories">
                                            @if(isset($courseCategories))
                                                @foreach($courseCategories as $courseCategory)
                                                    <option
                                                        value="{{ $courseCategory->id }}" {{ isset($_GET['category_id']) && $_GET['category_id'] == $courseCategory->id ? 'selected' : '' }} >{{ $courseCategory->name }}</option>
                                                    @if(!empty($courseCategory))
                                                        @if(count($courseCategory->courseCategories) > 0)
                                                            @include('backend.course-management.course.courses.course-category-loop-type-two', ['courseCategory' => $courseCategory, 'child' => 1])
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>


                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-success ms-4 " style="margin-top: 18px">
                                            Search
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-md-12 mt-2 dd" id="nestable-wrapper">
                            <ol class="dd-list list-group">
                                @foreach($courses as $k => $course)
                                    <li class="dd-item list-group-item" data-id="{{ $course['id'] }}">

                                        <div class="dd-option-handle">
                                            <div class="row">

                                                <table class="table table-bordered border-primary mt-4" id="file-datatable">
                                                    <tbody>
                                                    <tr>
                                                        <td class="custom_first_td">
                                                            <div class="dd-handle">
                                                                <div class="row">
                                                                    <div class="col-md-9 custom">
                                                                        <div class=" ps-3">
                                                                            <img src="{{ asset($course->banner) }}" alt="" style="height: 100px;"/>
                                                                        </div>
                                                                        <div class=" ps-3 mt-2">{{ $course->title }}</div>
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <p>৳ {{ $course->price }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="custom_2nd_td">
                                                            <!-- <div class="col-md-4"> -->
                                                            <div class="nav flex-column course-links">
                                                                @can('assign-course-teacher-page')
                                                                    <a href="{{ route('assign-teacher-to-course', ['course_id' => $course->id, 'title' => str_replace(' ', '-', $course->title)]) }}"
                                                                       class="btn btn-sm fw-bold"
                                                                       title="Course Assigned Teachers">Teachers</a>
                                                                @endcan
                                                                @can('assign-course-student-page')
                                                                    <a href="{{ route('assign-student-to-course', ['course_id' => $course->id, 'title' => str_replace(' ', '-', $course->title)]) }}"
                                                                       class="btn btn-sm fw-bold"
                                                                       title="Course Assigned Students">Students</a>
                                                                @endcan
                                                                @can('manage-course-routine')
                                                                    <a href="{{ route('course-routines.index', ['course_id' => $course->id, 'title' => str_replace(' ', '-', $course->title)]) }}"
                                                                       class="btn btn-sm fw-bold"
                                                                       title="Course Routines">Routines</a>
                                                                @endcan
                                                                @can('manage-course-coupon')
                                                                    <a href="{{ route('course-coupons.index', ['course_id' => $course->id, 'title' => str_replace(' ', '-', $course->title)]) }}"
                                                                       class="btn btn-sm fw-bold"
                                                                       title="Course Coupons">Coupons</a>
                                                                @endcan
                                                                @can('manage-course-section')
                                                                    <a href="{{ route('course-sections.index', ['course_id' => $course->id, 'title' => str_replace(' ', '-', $course->title)]) }}"
                                                                       class="btn btn-sm fw-bold"
                                                                       title="Course Content">Content</a>
                                                                @endcan
                                                                <!-- </div> -->
                                                            </div>
                                                        </td>
                                                        <td class="custom_3rd_td text-center">
                                                            <!-- <div class="col-md-4"> -->
                                                            <a href="javascript:void(0)"
                                                               class="badge badge-sm badge-orange-light text-dark">{{ $course->status == 1 ? 'Published' : 'Unpublished' }}</a>
                                                            <br>
                                                            <a href="javascript:void(0)"
                                                               class="badge badge-sm badge-success-light text-dark">{{ $course->is_paid == 1 ? 'Paid' : 'Free' }}</a>
                                                            <br>
                                                            <a href="javascript:void(0)"
                                                               class="badge badge-sm badge-default text-dark">{{ $course->is_featured == 1 ? 'Featured' : 'Not Featured' }}</a>
                                                            <!-- </div> -->
                                                        </td>
                                                        <td class="custom_4th_td text-center">
                                                            <!-- <div class="col-md-4"> -->
                                                            <a href="{{ route('export-course-json', ['model_id' => $course->id, 'model' => 'course']) }}"
                                                               data-course-id="{{ $course->id }}"
                                                               class="btn btn-sm mt-1 btn-secondary "
                                                               title="Export course to JSON">
                                                                <i class="fa-solid fa-arrow-alt-circle-down"></i>
                                                            </a>
                                                            <br>
                                                            @can('show-course')
                                                                <a href="" data-course-id="{{ $course->id }}"
                                                                   class="btn btn-sm mt-1 btn-primary show-btn"
                                                                   title="View Course">
                                                                    <i class="fa-solid fa-eye"></i>
                                                                </a>
                                                            @endcan
                                                            <br>
                                                            @can('edit-course')
                                                                <a href="" data-course-id="{{ $course->id }}"
                                                                   class="btn btn-sm mt-1 btn-warning edit-btn"
                                                                   title="Edit Course">
                                                                    <i class="fa-solid fa-edit"></i>
                                                                </a>
                                                            @endcan
                                                            <br>
                                                            @can('delete-course')
                                                                <form class="d-inline"
                                                                      action="{{ route('courses.destroy', $course->id) }}"
                                                                      method="post">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button type="submit"
                                                                            class="btn btn-sm mt-1 btn-danger data-delete-form"
                                                                            title="Delete Course">
                                                                        <i class="fa-solid fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            @endcan
                                                            <!-- </div> -->
                                                        </td>
                                                    </tr>

                                                    </tbody>
                                                </table>


                                                <!--
                                                <div class="col-md-4">
                                                    <div class="nav flex-column course-links">
                                                        @can('assign-course-teacher-page')
                                                    <a href="{{ route('assign-teacher-to-course', ['course_id' => $course->id, 'title' => str_replace(' ', '-', $course->title)]) }}" class="btn btn-sm fw-bold" title="Course Assigned Teachers">Teachers</a>

                                                @endcan
                                                @can('assign-course-student-page')
                                                    <a href="{{ route('assign-student-to-course', ['course_id' => $course->id, 'title' => str_replace(' ', '-', $course->title)]) }}" class="btn btn-sm fw-bold" title="Course Assigned Students">Students</a>

                                                @endcan
                                                @can('manage-course-routine')
                                                    <a href="{{ route('course-routines.index', ['course_id' => $course->id, 'title' => str_replace(' ', '-', $course->title)]) }}" class="btn btn-sm fw-bold" title="Course Routines">Routines</a>

                                                @endcan
                                                @can('manage-course-coupon')
                                                    <a href="{{ route('course-coupons.index', ['course_id' => $course->id, 'title' => str_replace(' ', '-', $course->title)]) }}" class="btn btn-sm fw-bold" title="Course Coupons">Coupons</a>

                                                @endcan
                                                @can('manage-course-section')
                                                    <a href="{{ route('course-sections.index', ['course_id' => $course->id, 'title' => str_replace(' ', '-', $course->title)]) }}" class="btn btn-sm fw-bold" title="Course Content">Content</a>

                                                @endcan
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <a href="javascript:void(0)" class="badge badge-sm badge-orange-light text-dark">{{ $course->status == 1 ? 'Published' : 'Unpublished' }}</a>
                                                    <br>
                                                    <a href="javascript:void(0)" class="badge badge-sm badge-success-light text-dark">{{ $course->is_paid == 1 ? 'Paid' : 'Free' }}</a>
                                                    <br>
                                                    <a href="javascript:void(0)" class="badge badge-sm badge-default text-dark">{{ $course->is_featured == 1 ? 'Featured' : 'Not Featured' }}</a>
                                                </div>
                                                <div class="col-md-4">
                                                    <a href="{{ route('export-course-json', ['model_id' => $course->id, 'model' => 'course']) }}" data-course-id="{{ $course->id }}"  class="btn btn-sm mt-1 btn-secondary " title="Export course to JSON">
                                                        <i class="fa-solid fa-arrow-alt-circle-down"></i>
                                                    </a>
                                                    <br>
                                                    @can('show-course')
                                                    <a href="" data-course-id="{{ $course->id }}"  class="btn btn-sm mt-1 btn-primary show-btn" title="View Course">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </a>

                                                @endcan
                                                <br>
                                                @can('edit-course')
                                                    <a href="" data-course-id="{{ $course->id }}" class="btn btn-sm mt-1 btn-warning edit-btn" title="Edit Course">
                                                            <i class="fa-solid fa-edit"></i>
                                                        </a>

                                                @endcan
                                                <br>
                                                @can('delete-course')
                                                    <form class="d-inline" action="{{ route('courses.destroy', $course->id) }}" method="post" >
                                                            @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-sm mt-1 btn-danger data-delete-form" title="Delete Course">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>

                                                @endcan
                                                </div>
                                            </div>
                                        </div>
                                        @if(!empty($course->courses))
                                                    @include('backend.course-management.course.courses.child-course-view', ['course' => $course])
                                                @endif -->
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>

                    <div class="row">
                        <form action="{{ route('courses.saveNestedCategories') }}" method="post"
                              id="nestedCategoryOrderForm">
                            @csrf
                            <textarea style="display: none;" name="nested_category_array"
                                      id="nestable-output"></textarea>
                            <button type="submit" class="btn btn-success" style="margin-top: 15px;display: none">Update
                                Order
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-div" id="coursesModal" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" id="modalForm">
                @include('backend.course-management.course.courses.form')
            </div>
        </div>
    </div>
    <div class="modal fade modal-div" id="jsonImport" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" id="">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Courses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('import-model-json', ['model' => 'course']) }}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="">Input Json</label>
                            <div>
                                <input type="file" name="json_file" class="" accept="application/JSON"/>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-success">Import</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
          integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <!-- DragNDrop Css -->
    <link href="{{ asset('/') }}backend/assets/css/dragNdrop.css" rel="stylesheet" type="text/css"/>
    <style>
        .course-links a:hover {
            color: darkorange !important;
        }

        input[switch] + label {
            margin-bottom: 0px;
        }

        .datetimepicker {
            z-index: 100009 !important;
        }

        .dd {
            max-width: 100% !important;
        }
    </style>
@endpush

@push('script')
    @if(!isset($_GET['category_id']))
        <!-- DragNDrop js -->
        <script src="{{ asset('/') }}backend/assets/plugins/dragNdrop/jquery.nestable.js"></script>
        <script src="{{ asset('/') }}backend/assets/plugins/dragNdrop/init.js"></script>
    @endif
    @include('backend.includes.assets.plugin-files.datatable')
    @include('backend.includes.assets.plugin-files.editor')
    {{--    @include('backend.includes.assets.plugin-files.date-time-picker')--}}
    <script
        src="{{ asset('/') }}backend/assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js"></script>
    {{--    @if($errors->any())--}}
    {{--        <script>--}}
    {{--            --}}
    {{--        </script>--}}
    {{--    @endif--}}
    <script>
        $(function () {
            $(".summernote").summernote({
                height: 70,
                inheritPlaceholder: true
            });

            const date = new Date();

            $("#dateTime").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
            $("#dateTime1").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
            $("#dateTime2").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
            $("#dateTime3").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
            $("#admissionLastDate").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
            $('.select2').select2();
            $('input[data-dtp="dtp_Nufud"]').val(currentDateTime);
        })
        $(document).on('click', '.dtp-btn-cancel', function () {
            alert('sdfsdf');
        })
    </script>
    <script>
        $(document).on('change', '#nestable-wrapper', function () {
            setTimeout(function () {
                var data = $('#nestedCategoryOrderForm').serialize();
                $.ajax({
                    url: "{{ route('courses.saveNestedCategories') }}",
                    method: "POST",
                    data: data,
                    dataType: "JSON",
                    success: function (message) {
                        toastr.success(message);
                    }
                })
            }, 800)
        })
    </script>

    {{--    edit course category--}}
    <script>
        $(document).on('click', '.edit-btn', function () {
            event.preventDefault();
            var courseId = $(this).attr('data-course-id');
            $.ajax({
                url: base_url + "courses/" + courseId + "/edit",
                method: "GET",
                // dataType: "JSON",
                success: function (data) {

                    $('#modalForm').empty().append(data);
                    $("#summernote").summernote({height: 70, inheritPlaceholder: true});
                    // $("#summernote1").summernote({height:70, inheritPlaceholder: true});


                    $("#dateTime").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
                    $("#dateTime1").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
                    $("#dateTime2").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
                    $("#dateTime3").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
                    $("#admissionLastDate").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});

                    $('.select2').select2({
                        placeholder: $(this).attr('data-placeholder'),
                        // dropdownParent: $('#'+$('.modal-fix').attr('data-modal-parent')),
                        // dropdownParent: $('.modal').attr('data-modal-parent'),
                    });
                    $('.submit-btn').addClass('update-btn').removeClass('submit-btn');

                    $('#coursesModal').modal('show');
                }
            })
        })
        $(document).on('click', '.show-btn', function () {
            event.preventDefault();
            var courseId = $(this).attr('data-course-id');
            $.ajax({
                url: base_url + "courses/" + courseId,
                method: "GET",
                // dataType: "JSON",
                success: function (data) {
                    // console.log(data);

                    $('#modalForm').empty().append(data);
                    $("#summernote").summernote({height: 70, inheritPlaceholder: true});
                    // $("#summernote1").summernote({height:70, inheritPlaceholder: true});


                    $("#dateTime").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
                    $("#dateTime1").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
                    $("#dateTime2").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
                    $("#dateTime3").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
                    $("#admissionLastDate").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});

                    $('.select2').select2({
                        placeholder: $(this).attr('data-placeholder'),
                        // dropdownParent: $('#'+$('.modal-fix').attr('data-modal-parent')),
                        // dropdownParent: $('.modal').attr('data-modal-parent'),
                    });
                    // $('.submit-btn').addClass('update-btn').removeClass('submit-btn');

                    $('#coursesModal').modal('show');
                }
            })
        })

    </script>
    {{-- update course category--}}
    <script>
        $(document).on('click', '.update-btn', function () {
            event.preventDefault();

            var discountAmount = Number($('input[name="discount_amount"]').val());
            if (discountAmount != '') {
                var price = Number($('input[name="price"]').val());
                if (discountAmount > price) {
                    $('#discountErrorMsg').text('Discount amount should be lower then Price.');
                    return false;
                }
            }

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
                beforeSend: function () {

                    $('.update-btn').attr('disabled', 'disabled');
                },
                success: function (message) {
                    // console.log(message);
                    toastr.success(message);
                    $('.update-btn').addClass('submit-btn').removeClass('update-btn');
                    $('#courseCategoryForm').attr('action', '');
                    $('#courseCategoryModal').modal('hide');
                    window.location.reload();
                },
                error: function (errors) {
                    if (errors.responseJSON) {

                        var allErrors = errors.responseJSON.errors;
                        for (key in allErrors) {
                            $('#' + key).empty().append(allErrors[key]);
                        }
                        $('.update-btn').attr('disabled', false);
                    }
                }
            })
        })
    </script>

    {{--    store course--}}
    <script>
        $(document).on('click', '.submit-btn', function () {
            event.preventDefault();
            var discountAmount = Number($('input[name="discount_amount"]').val());
            if (discountAmount != '') {
                var price = Number($('input[name="price"]').val());
                if (discountAmount > price) {
                    $('#discountErrorMsg').text('Discount amount should be lower then Price.');
                    return false;
                }
            }

            var form = $('#coursesForm')[0];
            var formData = new FormData(form);
            $.ajax({
                url: "{{ route('courses.store') }}",
                method: "POST",
                data: formData,
                dataType: "JSON",
                contentType: false,
                processData: false,
                beforeSend: function () {

                    $('.submit-btn').attr('disabled', 'disabled');
                },
                success: function (data) {
                    // console.log(data);
                    toastr.success(data);
                    $('#coursesModal').modal('hide');
                    window.location.reload();
                },
                error: function (errors) {
                    if (errors.responseJSON) {
                        $('span[class="text-danger"]').empty();
                        var allErrors = errors.responseJSON.errors;
                        for (key in allErrors) {
                            $('#' + key).empty().append(allErrors[key]);
                        }
                        $('.submit-btn').attr('disabled', false);
                    }
                }
            })
        })
    </script>
    <!-- DragNDrop js -->

    <script>
        $(document).on('keyup', '#discountAmount', function () {
            var discountAmount = Number($(this).val());
            var discountType = $('select[name="discount_type"]').val();
            var price = Number($('input[name="price"]').val());
            var discountErrorMsg = $('#discountErrorMsg');
            // console.log('price-'+price);
            // console.log('d-a-'+discountAmount);
            if (discountType == '') {
                toastr.error('Please select a Discount type.');
                return false;
            }
            if (discountType == 1) {
                if (discountAmount > price) {
                    discountErrorMsg.empty().append('Discount can\'t be greater then Price');
                } else if (discountAmount <= price) {
                    discountErrorMsg.empty();
                }
            } else if (discountType == 2) {
                if (discountAmount > 100) {
                    discountErrorMsg.empty().append('Discount can\'t be greater then 100%');
                } else if (discountAmount <= 100) {
                    discountErrorMsg.empty();
                }
            }
        })
    </script>


    <script>
        $(document).on('change', '#courseImage', function () {
            var imgURL = URL.createObjectURL(event.target.files[0]);
            $('#courseImagePreview').attr('src', imgURL).css({
                height: 150 + 'px',
                width: 150 + 'px',
                marginTop: '5px'
            });
        })
    </script>

    {{--    hide error msgs--}}
    <script>
        $(document).on('keyup', 'input:not(#discountAmount),textarea', function () {
            var selectorId = $(this).attr('name');
            if ($('#' + selectorId).text().length) {
                $('#' + selectorId).text('');
            }
        })
        $(document).on('change', 'select', function () {
            var selectorId = $(this).attr('name');
            if ($('#' + selectorId).text().length) {
                $('#' + selectorId).text('');
            }
        })

    </script>

    <script>
        $(document).on('click', '.open-modal', function () {
            event.preventDefault();

            resetFromInputAndSelect("{{ route('courses.store') }}", 'coursesForm')
            $('#summernote').summernote('reset');
            $('#coursesModal').modal('show');
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
            if ($(this).is(':checked')) {
                if (!ids.includes(existVal)) {
                    ids.push(existVal);
                    topicNames += topicName + ',';

                }
            } else {
                if (ids.includes(existVal)) {
                    ids.splice(ids.indexOf(existVal), 1);
                    topicNames = topicNames.replace(topicName + ',', '');
                    // topicNames = topicNames.split(topicName).join('');
                }
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
            if ($(this).find('fa-circle-arrow-down')) {
                $(this).html('<i class="fa-solid fa-circle-arrow-up"></i>');
            }
            if ($(this).find('fa-circle-arrow-up')) {
                $(this).html('<i class="fa-solid fa-circle-arrow-down"></i>');
            }
            if ($('.childDiv' + dataId).hasClass('d-none')) {
                $('.childDiv' + dataId).removeClass('d-none');
            } else {
                $('.childDiv' + dataId).addClass('d-none');
            }
        })
        $(document).on('click', '.close-topic-modal', function () {
            $('#questionTopicModal').modal('hide');
        })
    </script>
    <!--show hide test end-->

    {{--    export json--}}
    <script>
        $(document).on('click', '.export-json', function () {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                method: "GET",
                dataType: "JSON",
                success: function (data) {
                    // console.log(data);
                    toastr.success('course exported successfully');
                },
            })
        })
    </script>

@endpush
