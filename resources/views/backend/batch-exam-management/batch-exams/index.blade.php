@extends('backend.master')

@section('title', 'Batch Exams')

@section('body')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">Batch Exams</h4>
                    @can('create-batch-exam')
                        <button type="button" data-bs-toggle="modal" data-bs-target="#coursesModal" class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4 open-modal"><i class="fa-solid fa-circle-plus"></i></button>
                    @endcan
                    <button type="button" data-bs-toggle="modal" data-bs-target="#jsonImport" class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 m-r-50 "><i class="fa-solid fa-arrow-alt-circle-up"></i></button>
                </div>
                <div class="card-body">
                    <form action="" method="get">
                        {{--                    @csrf--}}
                        <div class="row pb-5 pt-3">
                            <div class="col-md-6 mx-auto card card-body">
                                <div class="row" >
                                    <div class="col select2-div">
                                        <label for="">Batch Exam Category </label>
                                        <select name="category_id" class="form-control select2" id="categoryId" data-placeholder="Select Batch Exam Categories" >
                                            @if(isset($batchExamCategories))
                                                @foreach($batchExamCategories as $batchExamCategory)
                                                    <option value="{{ $batchExamCategory->id }}" {{ isset($_GET['category_id']) && $_GET['category_id'] == $batchExamCategory->id ? 'selected' : '' }} >{{ $batchExamCategory->name }}</option>
                                                    @if(!empty($batchExamCategory))
                                                        @if(count($batchExamCategory->batchExamCategories) > 0)
                                                            @include('backend.batch-exam-management.batch-exams.course-category-loop-type-two', ['batchExamCategory' => $batchExamCategory, 'child' => 1])
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-success ms-4 " style="margin-top: 18px" >Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <table class="table" id="file-datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Links</th>
                                <th>Categories</th>
{{--                                <th>Duration</th>--}}
{{--                                <th>Discount</th>--}}
{{--                                <th>Partial Payment</th>--}}
                                <th>Extra Features</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($batchExams))
                                @foreach($batchExams as $batchExam)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="mt-3">
                                                <a href="{{ route('batch-exam-sections.index', ['batch_exam_id' => $batchExam->id]) }}" >
                                                    <div class="text-center">
                                                        <img src="{{ asset($batchExam->banner) }}" alt="" style="height: 100px;" />
                                                    </div>
                                                    {{--                                            <br>--}}
                                                    <div class="text-center mt-2">{{ $batchExam->title }}</div>
                                                </a>
                                            </div>
                                        </td>
                                        <td class="nav flex-column course-links">

                                            @can('assign-batch-exam-teacher-page')
                                            <a href="{{ route('assign-teacher-to-batch-exam', ['batch_exam_id' => $batchExam->id]) }}" class="nav-link fw-bold" title="Batch Exam Assigned Teachers">Teachers</a>
                                            @endcan
                                            @can('assign-batch-exam-student-page')
                                            <a href="{{ route('assign-student-to-batch-exam', ['batch_exam_id' => $batchExam->id]) }}" class="nav-link fw-bold" title="Batch Exam Assigned Students">Students</a>
                                                @endcan
                                            @can('manage-batch-exam-routine')
                                            <a href="{{ route('batch-exam-routines.index', ['batch_exam_id' => $batchExam->id]) }}" class="nav-link fw-bold" title="Batch Exam Routines">Routines</a>
                                                @endcan
                                            @can('manage-batch-exam-section')
                                            <a href="{{ route('batch-exam-sections.index', ['batch_exam_id' => $batchExam->id]) }}" class="nav-link fw-bold" title="Batch Exam Content">Content</a>
                                                @endcan
                                        </td>
{{--                                        <td>--}}
{{--                                            @foreach($batchExam->batchExamSubscriptions as $xmPackage)--}}
{{--                                                <p></p>--}}
{{--                                            @endforeach--}}
{{--                                        </td>--}}
                                        <td>
                                            @foreach($batchExam->batchExamCategories as $category)
                                                <span class="badge bg-secondary">{{ $category->name }}</span>
                                            @endforeach
                                        </td>
{{--                                        <td>--}}
{{--                                            ৳ {{ $batchExam->discount_type == 1 ? $batchExam->discount_amount : ($batchExam->price * $batchExam->discount_amount)/100 }}--}}
{{--                                        </td>--}}
{{--                                        <td> ৳ {{ $batchExam->partial_payment }}</td>--}}
                                        <td>
                                            <a href="javascript:void(0)" class="nav-link">{{ $batchExam->status == 1 ? 'Published' : 'Unpublished' }}</a>
                                            <a href="javascript:void(0)" class="nav-link">{{ $batchExam->is_paid == 1 ? 'Paid' : 'Free' }}</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('export-course-json', ['model_id' => $batchExam->id, 'model' => 'batch_exam']) }}" data-course-id="{{ $batchExam->id }}"  class="btn btn-sm mt-1 btn-secondary " title="Export course to JSON">
                                                <i class="fa-solid fa-arrow-alt-circle-up"></i>
                                            </a>
                                            @can('show-batch-exam')
                                                <a href="" data-course-id="{{ $batchExam->id }}" class="btn btn-sm btn-primary show-btn" title="View Batch Exam">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                            @endcan
                                            @can('edit-batch-exam')
                                                <a href="" data-course-id="{{ $batchExam->id }}" class="btn btn-sm btn-warning edit-btn" title="Edit Batch Exam">
                                                    <i class="fa-solid fa-edit"></i>
                                                </a>
                                                @endcan
                                            @can('delete-batch-exam')
                                                <form class="d-inline" action="{{ route('batch-exams.destroy', $batchExam->id) }}" method="post" >
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-sm btn-danger data-delete-form" title="Delete Batch Exam">
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
    <div class="modal fade modal-div" id="coursesModal" data-bs-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" id="modalForm">
                @include('backend.batch-exam-management.batch-exams.form')
            </div>
        </div>
    </div>
    <div class="modal fade modal-div" id="jsonImport" data-bs-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" id="">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Courses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('import-model-json', ['model' => 'batch_exam']) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="">Input Json</label>
                            <div>
                                <input type="file" name="json_file" class="" accept="application/JSON" />
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
    <!-- DragNDrop Css -->
{{--    <link href="{{ asset('/') }}backend/assets/css/dragNdrop.css" rel="stylesheet" type="text/css" />--}}
    <style>
        .course-links a:hover {
            color: darkorange!important;
        }
        input[switch]+label {
            margin-bottom: 0px;
        }
        .datetimepicker {z-index: 100009!important;}
    </style>
@endpush

@push('script')
    @include('backend.includes.assets.plugin-files.datatable')
    @include('backend.includes.assets.plugin-files.editor')
{{--    @include('backend.includes.assets.plugin-files.date-time-picker')--}}
    <script src="{{ asset('/') }}backend/assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js"></script>
    <script>
        $(function () {
            $(".summernote").summernote({
                height:70,
                inheritPlaceholder: true
                });
            // $('#dateTime1').bootstrapMaterialDatePicker({
            //     format: 'YYYY-MM-DD HH:mm',
            //     minDate : new Date(),
            // });
            // $('#dateTime2').bootstrapMaterialDatePicker({
            //     format: 'YYYY-MM-DD HH:mm',
            //     minDate : new Date(),
            // });
            // $('#dateTime3').bootstrapMaterialDatePicker({
            //     format: 'YYYY-MM-DD HH:mm',
            //     minDate : new Date(),
            // });
            $('input[data-dtp="dtp_Nufud"]').val(currentDateTime);
            $("#dateTime").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
            $("#dateTime1").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
            $("#dateTime2").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
            $("#dateTime3").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
        })
        $(document).on('click', '.dtp-btn-cancel', function () {
            alert('sdfsdf');
        })
    </script>


{{--    edit course category--}}
    <script>
        $(document).on('click', '.edit-btn', function () {
            event.preventDefault();
            var courseId = $(this).attr('data-course-id');
            $.ajax({
                url: base_url+"batch-exams/"+courseId+"/edit",
                method: "GET",
                // dataType: "JSON",
                success: function (data) {
                    // console.log(data);
                    $('#modalForm').empty().append(data);
                    $("#summernote").summernote({height:70, inheritPlaceholder: true});
                    // $("#summernote1").summernote({height:70, inheritPlaceholder: true});

                    // $('#dateTime').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm', minDate : new Date(),});
                    // $('#dateTime1').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm', minDate : new Date(),});
                    // $('#dateTime2').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm', minDate : new Date(),});
                    // $('#dateTime3').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm', minDate : new Date(),});

                    $("#dateTime").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
                    $("#dateTime1").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
                    $("#dateTime2").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
                    $("#dateTime3").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});

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
                url: base_url+"batch-exams/"+courseId,
                method: "GET",
                // dataType: "JSON",
                success: function (data) {
                    // console.log(data);

                    $('#modalForm').empty().append(data);
                    $("#summernote").summernote({height:70, inheritPlaceholder: true});
                    // $("#summernote1").summernote({height:70, inheritPlaceholder: true});

                    // $('#dateTime').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm', minDate : new Date(),});
                    // $('#dateTime1').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm', minDate : new Date(),});
                    // $('#dateTime2').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm', minDate : new Date(),});
                    // $('#dateTime3').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm', minDate : new Date(),});

                    $("#dateTime").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
                    $("#dateTime1").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
                    $("#dateTime2").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
                    $("#dateTime3").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});

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
    </script>
{{-- update course category--}}
    <script>
        $(document).on('click', '.update-btn', function () {
            event.preventDefault();


            var status = false;
            $('.price').each(function () {
                var loopId = $(this).attr('data-loop-id');
                var price = Number($(this).val());
                var discountAmount = Number($('#discountAmount'+loopId).val());
                if(price < discountAmount)
                {
                    toastr.error('Discount can\'t be bigger then price.');
                    $('#discountErrorMsg'+loopId).text('Discount can\'t be bigger then price.');
                    // event.stopPropagation();
                    status = true;
                    return false;
                }
            })
            if (status == true)
            {
                return false;
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
                    console.log(message);
                    toastr.success(message);
                    $('.update-btn').addClass('submit-btn').removeClass('update-btn');
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
            var status = false;
            $('.price').each(function () {
                var loopId = $(this).attr('data-loop-id');
                var price = Number($(this).val());
                var discountAmount = Number($('#discountAmount'+loopId).val());
                if(price < discountAmount)
                {
                    toastr.error('Discount can\'t be bigger then price.');
                    $('#discountErrorMsg'+loopId).text('Discount can\'t be bigger then price.');
                    // event.stopPropagation();
                    status = true;
                    return false;
                }
            })
            if (status == true)
            {
                return false;
            }
            var form = $('#coursesForm')[0];
            var formData = new FormData(form);
            $.ajax({
                url: "{{ route('batch-exams.store') }}",
                method: "POST",
                data: formData,
                dataType: "JSON",
                contentType: false,
                processData: false,
                beforeSend: function () {

                    $('.submit-btn').attr('disabled', 'disabled');
                },
                success: function (data) {
                    console.log(data);
                    // if (result.errors)
                    // {
                    //     $.each(result.errors, function(key, value){
                    //         console.log(key+'<br>');
                    //     });
                    // }
                        toastr.success(data);
                        $('#coursesModal').modal('hide');
                        window.location.reload();
                },
                error: function (errors) {
                    if (errors.responseJSON)
                    {
                        $('span[class="text-danger"]').empty();
                        var allErrors = errors.responseJSON.errors;
                        for (key in allErrors)
                        {
                                $('#'+key).empty().append(allErrors[key]);
                        }
                        $('.submit-btn').attr('disabled', false);
                    }
                }
            })
        })
    </script>
    <!-- DragNDrop js -->

    <script>
        $(document).on('keyup', '.discount-amount', function () {
            var discountAmount = Number($(this).val());
            var dataLoopId = $(this).attr('data-loop-id');
            var discountType = $('.discount-type'+dataLoopId).val();
            var price = Number($('.price-val-'+dataLoopId).val());
            var discountErrorMsg = $('#discountErrorMsg'+dataLoopId);
            if (discountType == '')
            {
                toastr.error('Please select a Discount type.');
                return false;
            }
            if (discountType == 1)
            {
                if (discountAmount > price)
                {
                    discountErrorMsg.empty().append('Discount can\'t be greater then Price');
                }else if (discountAmount <= price){
                    discountErrorMsg.empty();
                }
            } else if (discountType == 2)
            {
                if (discountAmount > 100)
                {
                    discountErrorMsg.empty().append('Discount can\'t be greater then 100%');
                }else if (discountAmount <= 100){
                    discountErrorMsg.empty();
                }
            }
        })
    </script>


    <script>
        $(document).on('change', '#courseImage', function () {
            var imgURL = URL.createObjectURL(event.target.files[0]);
            $('#courseImagePreview').attr('src', imgURL).css({
                height: 150+'px',
                width: 150+'px',
                marginTop: '5px'
            });
        })

    </script>

{{--    hide error msgs--}}
    <script>
        $(document).on('keyup', 'input:not(#discountAmount),textarea', function () {
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
        $(document).on('click', '.open-modal', function () {
            event.preventDefault();
                resetFromInputAndSelect("{{ route('batch-exam-sections.store') }}", 'coursesForm')
            $('#summernote').summernote('reset');
            $('#coursesModal').modal('show');
        })


    </script>


{{--    batch exam package js code starts--}}
    <script>
        var n = 1;
        var x = 11;
        $(document).on('click', '.add-row', function () {
            event.preventDefault();
            var div = '';
            div     += '<div class="row">\n' +
                '                <div class="col-12 mt-3">\n' +
                '                    <h4>New Package Details</h4>\n' +
                '                </div>\n' +
                '                <div class="col-md-4 mt-2">\n' +
                '                    <label for="">Package Title</label>\n' +
                '                    <input type="text"  class="form-control" name="package_title['+n+']" placeholder="Package Title" />\n' +
                '                    <span class="text-danger" id="package_title"></span>\n' +
                '                </div>\n' +
                '                <div class="col-md-4 mt-2">\n' +
                '                    <label for="">Package Duration</label>\n' +
                '                    <input type="number"  class="form-control" name="package_duration_in_days['+n+']" placeholder="Duration in Days" />\n' +
                '                    <span class="text-danger" id="package_duration_in_days"></span>\n' +
                '                </div>\n' +
                '                <div class="col-md-4 mt-2">\n' +
                '                    <label for="">Price</label>\n' +
                '                    <input type="number" name="price['+n+']" data-loop-id="'+n+'" class="form-control price price-val-'+n+'" placeholder="Price" />\n' +
                '                    <span class="text-danger" id="price"></span>\n' +
                '                </div>\n' +
                '                <div class="col-md-4 mt-2 select2-div d-none">\n' +
                '                    <label for="">Select a Discount Type</label>\n' +
                '                    <select name="discount_type['+n+']" class="form-control discount-type'+n+'" data-placeholder="Select a Discount Type">\n' +
                '                        <option value="" disabled >Select a Discount Option</option>\n' +
                '                        <option value="1" selected>Fixed</option>\n' +
                '                        <option value="2">Percentage</option>\n' +
                '                    </select>\n' +
                '                </div>\n' +
                '                <div class="col-md-4 mt-2">\n' +
                '                    <label for="">Discount Value</label>\n' +
                '                    <input type="number" id="discountAmount'+n+'" name="discount_amount['+n+']" data-loop-id="'+n+'" class="form-control discount-amount" placeholder="Discount Value" />\n' +
                '                    <span id="discountErrorMsg'+n+'" class="text-danger"></span>\n' +
                '                </div>\n' +
                '                <div class="col-md-3 mt-2">\n' +
                '                    <label for="">Discount Start Date</label>\n' +
                '                    <input type="text" name="discount_start_date['+n+']" id="dateTime'+x+'" data-dtp="dtp_Nufud" class="form-control" placeholder="Discount Start Date" />\n' +
                '                    <span class="text-danger" id="discount_start_date"></span>\n' +
                '                </div>\n' +
                '                <div class="col-md-3 mt-2">\n' +
                '                    <label for="">Discount End Date</label>\n' +
                '                    <input type="text" name="discount_end_date['+n+']" id="dateTimex'+x+'" data-dtp="dtp_Nufud" class="form-control" placeholder="Discount Start Date" />\n' +
                '                    <span class="text-danger" id="discount_end_date"></span>\n' +
                '                </div>\n' +
                '                <div class="col-md-2 m-t-30">\n' +
                '                    <div class="text-end">\n' +
                '                        <a href="" class="btn btn-sm btn-success add-row"><i class="fa-solid fa-plus"></i></a>\n' +
                '                        <a href="" class="btn btn-sm btn-danger remove-row"><i class="fa-solid fa-trash"></i></a>\n' +
                '                    </div>\n' +
                '                </div>\n' +
                '            </div>';
            $('#appendPackage').append(div);
            $("#dateTime"+x).val(currentDateTime);
            $("#dateTime"+x).datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
            $("#dateTimex"+x).datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
            n++;
            x++
        })
        $(document).on('click', '.remove-row', function () {
            event.preventDefault();
            $(this).closest('.row').remove();
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
                if (!ids.includes(existVal))
                {
                    ids.push(existVal);
                    topicNames += topicName+',';

                }
            } else {
                if (ids.includes(existVal))
                {
                    ids.splice(ids.indexOf(existVal), 1);
                    topicNames = topicNames.replace(topicName+',','');
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
