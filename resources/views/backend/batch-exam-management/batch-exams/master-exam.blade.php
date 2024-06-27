@extends('backend.master')

@section('title', 'Master Exams')

@section('body')
    <div class="row mt-5">
        <div class="col-8 mx-auto">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">Master Exam</h4>
{{--                    <button type="button" data-bs-toggle="modal" data-bs-target="#coursesModal" class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4 open-modal"><i class="fa-solid fa-circle-plus"></i></button>--}}
                </div>
                <div class="card-body">
                    @if(isset($masterExam))
                        <form action="{{ isset($masterExam) ? route('batch-exams.update', $masterExam->id) : '' }}" method="post" enctype="multipart/form-data" id="coursesForm">
                            @if(isset($masterExam))
                                <input type="hidden" name="_method" id="formMethod" value="put" />

                            @endif
                            <input type="hidden" name="_token" id="formToken" value="{{ csrf_token() }}" />
                            {{--                    <input type="hidden" name="category_id" >--}}
                            <div class="">
                                <div class="card card-body">
                                    <div class="row mt-2">
                                        <div class="col-md-7 mt-2">
                                            <label for="courseTitle">Batch Exam Title</label>
                                            <input type="text" name="title" value="{{ isset($masterExam) ? $masterExam->title : '' }}" class="form-control" placeholder="Batch Exam Title" />
                                            <span class="text-danger" id="title"></span>
                                        </div>
    {{--                                    <div class="col-md-5 mt-2 select2-div">--}}
    {{--                                        <label for="">Select Batch Exam Categories</label>--}}
    {{--                                        <select name="batch_exam_categories[]" class="form-control select2"  multiple data-placeholder="Select Batch Exam Categories" >--}}
    {{--                                            <option></option>--}}
    {{--                                            @if(isset($masterExamCategories))--}}
    {{--                                                @foreach($masterExamCategories as $masterExamCategory)--}}
    {{--                                                    <option value="{{ $masterExamCategory->id }}" @if(isset($masterExam->batchExamCategories)) @foreach($masterExam->batchExamCategories as $selectedCourseCategory) @if($masterExamCategory->id == $selectedCourseCategory->id) selected @endif @endforeach @endif>{{ $masterExamCategory->name }}</option>--}}
    {{--                                                    @if(isset($masterExamCategory->batchExamCategories))--}}
    {{--                                                        @include('backend.batch-exam-management.batch-exams.course-category-loop', ['batchExamCategory' => $masterExamCategory, 'child' => 1, 'batchExam' => $masterExam ?? ''])--}}
    {{--                                                    @endif--}}
    {{--                                                @endforeach--}}

    {{--                                            @endif--}}
    {{--                                        </select>--}}
    {{--                                        <span class="text-danger" id="course_categories"></span>--}}
    {{--                                    </div>--}}
                                        <div class="col-md-12 mt-2">
                                            <label for="">Batch Exam Sub Title</label>
                                            <textarea name="sub_title" placeholder="Batch Exam Sub Title" id="" class="form-control" cols="30" rows="5">{{ isset($masterExam) ? $masterExam->sub_title : '' }}</textarea>
                                            <span class="text-danger" id="sub_title"></span>
                                        </div>
                                        <div class="col-md-12 mt-2 mb-2">
                                            <label for="">Batch Exam Description</label>
                                            <textarea name="description" class="form-control" id="summernote" placeholder="Batch Exam Description" cols="30" rows="5">{!! isset($masterExam) ? $masterExam->description : '' !!}</textarea>
                                            <span class="text-danger" id="description"></span>
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label for="">Featured Video</label>
                                            <input type="text" value="{{ isset($masterExam) ? 'https://youtu.be/'.$masterExam->featured_video_url : '' }}" name="featured_video_url" class="form-control" placeholder="Featured Video" />
                                            <span class="text-danger" id="featured_video_url"></span>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <label for="">Featured Banner</label>
                                            <input type="file" class="form-control" name="banner" id="courseImage" accept="images/*" placeholder="Featured Banner">
                                            <span class="text-danger" id="banner"></span>

                                        </div>
                                        <div class="col-md-6 mt-2">
                                            @if(isset($masterExam))
                                                <div>
                                                    <img src="{{ asset($masterExam->banner) }}" id="courseImagePreview" style="height: 60px; width: 70px" />
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-body" id="appendPackage">
                                    @foreach($masterExam->batchExamSubscriptions as $key => $examPackage)
                                        <div class="row">
                                            <div class="col-12 mt-3">
                                                <h4>Exam Package Details</h4>
                                            </div>
                                            <div class="col-md-4 mt-2">
                                                <label for="">Package Title</label>
                                                <input type="text"  class="form-control" name="package_title[{{ $key }}]" value="{{ isset($examPackage) ? $examPackage->package_title : '' }}" placeholder="Package Title" />
                                                <span class="text-danger" id="package_title"></span>
                                            </div>
                                            <div class="col-md-4 mt-2">
                                                <label for="">Package Duration</label>
                                                <input type="text" value="{{ isset($examPackage) ? $examPackage->package_duration_in_days : '' }}" class="form-control" name="package_duration_in_days[{{ $key }}]" placeholder="Duration in Days" />
                                                <span class="text-danger" id="package_duration_in_days"></span>
                                            </div>
                                            <div class="col-md-4 mt-2">
                                                <label for="">Price</label>
                                                <input type="text" name="price[{{ $key }}]" value="{{ isset($examPackage) ? $examPackage->price : '' }}" class="form-control" placeholder="Price" />
                                                <span class="text-danger" id="price"></span>
                                            </div>
                                            <div class="col-md-4 mt-2 select2-div d-none">
                                                <label for="">Select a Discount Type</label>
                                                <select name="discount_type[{{ $key }}]" class="form-control" data-placeholder="Select a Discount Type">
                                                    <option value="" disabled>Select a Discount Option</option>
                                                    <option value="1" {{ isset($examPackage) && $examPackage->discount_type == 1 ? 'selected' : '' }}>Fixed</option>
                                                    <option value="2" {{ isset($examPackage) && $examPackage->discount_type == 2 ? 'selected' : '' }}>Percentage</option>
                                                </select>
                                                <span class="text-danger" id="discount_type"></span>
                                            </div>
                                            <div class="col-md-4 mt-2">
                                                <label for="">Discount Value</label>
                                                <input type="text" id="discountAmount" name="discount_amount[{{ $key }}]" value="{{ isset($examPackage) ?  $examPackage->discount_amount : '' }}" class="form-control" placeholder="Discount Value" />
                                                <span id="discountErrorMsg" class="text-danger"></span>
                                            </div>
                                            <div class="col-md-3 mt-2">
                                                <label for="">Discount Start Date</label>
                                                <input type="text" name="discount_start_date[{{ $key }}]" id="datetimepicker{{ $key }}" value="{{ isset($examPackage) ? $examPackage->discount_start_date : '' }}" data-dtp="dtp_Nufud" class="form-control" placeholder="Discount Start Date" />
                                                <span class="text-danger" id="discount_start_date"></span>
                                            </div>
                                            <div class="col-md-3 mt-2">
                                                <label for="">Discount End Date</label>
                                                <input type="text" name="discount_end_date[{{ $key }}]" id="datetimepickerx{{ $key }}" value="{{ isset($examPackage) ? $examPackage->discount_end_date : '' }}" data-dtp="dtp_Nufud" class="form-control" placeholder="Discount Start Date" />
                                                <span class="text-danger" id="discount_end_date"></span>
                                            </div>
                                            <div class="col-md-2 m-t-30">
                                                <div class="text-end">
                                                    <a href="" class="btn btn-sm btn-success add-row"><i class="fa-solid fa-plus"></i></a>
                                                    @if($key != 0)
                                                        <a href="" class="btn btn-sm btn-danger remove-row"><i class="fa-solid fa-trash"></i></a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

{{--                                    @push('script')--}}
{{--                                        <script>--}}
{{--                                            $('#dateTime{{ $key }}').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm', minDate : new Date()});--}}
{{--                                            $('#dateTimex{{ $key }}').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm', minDate : new Date()});--}}
{{--                                        </script>--}}
{{--                                        @endpush--}}
                                    @endforeach
                                </div>
                                <div class="card card-body d-none">
                                    <div class="row">
                                        <div class="col-md-4 mt-3">
                                            <label for="">Status</label>
                                            <div class="material-switch">
                                                <input id="someSwitchOptionInfo" name="status" type="checkbox" {{ isset($masterExam) && $masterExam->status == 0 ? '' : 'checked' }} />
                                                <label for="someSwitchOptionInfo" class="label-info"></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label for="">Is Paid</label>

                                            <div class="material-switch">
                                                <input id="someSwitchOptionWaring" name="is_paid" type="checkbox" {{ isset($masterExam) && $masterExam->is_paid == 0 ? '' : 'checked' }} />
                                                <label for="someSwitchOptionWaring" class="label-info"></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label for="">Featured This Batch Exam</label>

                                            <div class="material-switch">
                                                <input id="someSwitchOptionSuccess" name="is_featured" type="checkbox" {{ isset($masterExam) && $masterExam->is_featured == 0 ? '' : 'checked' }} />
                                                <label for="someSwitchOptionSuccess" class="label-info"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary update-btn" >Update</button>
                            </div>
                        </form>
                    @else
                        <p class="text-center">No Master Exam Created Yet</p>
                    @endif
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
    </style>
@endpush

@push('script')
{{--    @include('backend.includes.assets.plugin-files.datatable')--}}
    @include('backend.includes.assets.plugin-files.editor')
    @include('backend.includes.assets.plugin-files.date-time-picker')
    <script src="{{ asset('/') }}backend/assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js"></script>
    <script>
        $(function () {
            $(".summernote").summernote({
                height:70,
                inheritPlaceholder: true
            });
            @foreach($masterExam->batchExamSubscriptions as $index => $examPackagex)
                {{--$('#dateTime{{ $index }}').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm', minDate : new Date()});--}}
                $("#datetimepicker{{ $index }}").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0})
                $("#datetimepickerx{{ $index }}").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0})
                {{--$('#dateTimex{{ $index }}').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm', minDate : new Date()});--}}
            @endforeach
            // $('#dateTimec').bootstrapMaterialDatePicker({
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
        })
        $(document).on('click', '.dtp-btn-cancel', function () {
            alert('sdfsdf');
        })
    </script>




    {{-- update course category--}}
    <script>
        // $(document).on('click', '.update-btn', function () {
        //     event.preventDefault();
        //     var form = $('#coursesForm')[0];
        //     var formData = new FormData(form);
        //     $.ajax({
        //         url: $('#coursesForm').attr('action'),
        //         method: "POST",
        //         data: formData,
        //         // dataType: "JSON",
        //         // async: false,
        //         // cache: false,
        //         contentType: false,
        //         processData: false,
        //         // enctype: 'multipart/form-data',
        //         success: function (message) {
        //             console.log(message);
        //             toastr.success(message);
        //             $('.update-btn').addClass('submit-btn').removeClass('update-btn');
        //             $('#courseCategoryForm').attr('action', '');
        //             $('#courseCategoryModal').modal('hide');
        //             window.location.reload();
        //         },
        //         error: function (errors) {
        //             if (errors.responseJSON)
        //             {
        //
        //                 var allErrors = errors.responseJSON.errors;
        //                 for (key in allErrors)
        //                 {
        //                     $('#'+key).empty().append(allErrors[key]);
        //                 }
        //             }
        //         }
        //     })
        // })
    </script>
    {{--    <script>--}}
    {{--        $(document).on('change', '#nestable-wrapper', function () {--}}
    {{--            setTimeout(function () {--}}
    {{--                var data = $('#nestedCategoryOrderForm').serialize();--}}
    {{--                $.ajax({--}}
    {{--                    url: "{{ route('courseCategories.saveNestedCategories') }}",--}}
    {{--                    method: "POST",--}}
    {{--                    data: data,--}}
    {{--                    dataType: "JSON",--}}
    {{--                    success: function (message) {--}}
    {{--                        toastr.success(message);--}}
    {{--                    }--}}
    {{--                })--}}
    {{--            }, 800)--}}
    {{--        })--}}
    {{--    </script>--}}

    {{--    store course--}}
    <script>
        {{--$(document).on('click', '.submit-btn', function () {--}}
        {{--    event.preventDefault();--}}
        {{--    var form = $('#coursesForm')[0];--}}
        {{--    var formData = new FormData(form);--}}
        {{--    $.ajax({--}}
        {{--        url: "{{ route('batch-exams.store') }}",--}}
        {{--        method: "POST",--}}
        {{--        data: formData,--}}
        {{--        dataType: "JSON",--}}
        {{--        contentType: false,--}}
        {{--        processData: false,--}}
        {{--        success: function (data) {--}}
        {{--            console.log(data);--}}
        {{--            // if (result.errors)--}}
        {{--            // {--}}
        {{--            //     $.each(result.errors, function(key, value){--}}
        {{--            //         console.log(key+'<br>');--}}
        {{--            //     });--}}
        {{--            // }--}}
        {{--            toastr.success(data);--}}
        {{--            $('#coursesModal').modal('hide');--}}
        {{--            window.location.reload();--}}
        {{--        },--}}
        {{--        error: function (errors) {--}}
        {{--            if (errors.responseJSON)--}}
        {{--            {--}}
        {{--                $('span[class="text-danger"]').empty();--}}
        {{--                var allErrors = errors.responseJSON.errors;--}}
        {{--                for (key in allErrors)--}}
        {{--                {--}}
        {{--                    $('#'+key).empty().append(allErrors[key]);--}}
        {{--                }--}}
        {{--            }--}}
        {{--        }--}}
        {{--    })--}}
        {{--})--}}
    </script>
    <!-- DragNDrop js -->

    <script>
        $(document).on('keyup', '#discountAmount', function () {
            var discountAmount = Number($(this).val());
            var discountType = $('select[name="discount_type"]').val();
            var price = Number($('input[name="price"]').val());
            var discountErrorMsg = $('#discountErrorMsg');
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
        // $(document).ready(function() {
        //     $('#courseImage').change(function() {
        //         var imgURL = URL.createObjectURL(event.target.files[0]);
        //         $('#courseImagePreview').attr('src', imgURL).css({
        //             height: 150+'px',
        //             width: 150+'px',
        //             marginTop: '5px'
        //         });
        //     });
        // });
    </script>

    {{--    hide error msgs--}}
    {{--    <script>--}}
    {{--        $(document).on('keyup', 'input:not(#discountAmount),textarea', function () {--}}
    {{--            var selectorId = $(this).attr('name');--}}
    {{--            if ($('#'+selectorId).text().length)--}}
    {{--            {--}}
    {{--                $('#'+selectorId).text('');--}}
    {{--            }--}}
    {{--        })--}}
    {{--        $(document).on('change', 'select', function () {--}}
    {{--            var selectorId = $(this).attr('name');--}}
    {{--            if ($('#'+selectorId).text().length)--}}
    {{--            {--}}
    {{--                $('#'+selectorId).text('');--}}
    {{--            }--}}
    {{--        })--}}
    {{--        // date time error empty not working--}}
    {{--        // $(document).on('click', '#dateTime', function () {--}}
    {{--        //     var selectorId = $(this).attr('name');--}}
    {{--        //     alert('hi');--}}
    {{--        //     if ($('#'+selectorId).text().length)--}}
    {{--        //     {--}}
    {{--        //         $('#'+selectorId).text('');--}}
    {{--        //     }--}}
    {{--        // })--}}
    {{--    </script>--}}

{{--    <script>--}}
{{--        $(document).on('click', '.open-modal', function () {--}}
{{--            event.preventDefault();--}}
{{--            resetFromInputAndSelect("{{ route('batch-exam-sections.store') }}", 'coursesForm')--}}
{{--            $('#summernote').summernote('reset');--}}
{{--            $('#coursesModal').modal('show');--}}
{{--        })--}}

{{--    </script>--}}


    {{--    batch exam package js code starts--}}
    <script>
        var n = 1;
        var x = 121;
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
                '                    <input type="number" name="price['+n+']"  class="form-control" placeholder="Price" />\n' +
                '                    <span class="text-danger" id="price"></span>\n' +
                '                </div>\n' +
                '                <div class="col-md-4 mt-2 select2-div d-none">\n' +
                '                    <label for="">Select a Discount Type</label>\n' +
                '                    <select name="discount_type['+n+']" class="form-control" data-placeholder="Select a Discount Type">\n' +
                '                        <option value="" disabled >Select a Discount Option</option>\n' +
                '                        <option value="1" selected>Fixed</option>\n' +
                '                        <option value="2">Percentage</option>\n' +
                '                    </select>\n' +
                '                </div>\n' +
                '                <div class="col-md-4 mt-2">\n' +
                '                    <label for="">Discount Value</label>\n' +
                '                    <input type="number" id="discountAmount" name="discount_amount['+n+']" class="form-control" placeholder="Discount Value" />\n' +
                '                    <span id="discountErrorMsg" class="text-danger"></span>\n' +
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
            $('#dateTime'+x).bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm', minDate : new Date()});
            $('#dateTimex'+x).bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm', minDate : new Date()});
            n++;
            x++
        })
        $(document).on('click', '.remove-row', function () {
            event.preventDefault();
            $(this).closest('.row').remove();
        })
    </script>

@endpush
