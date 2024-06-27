@extends('backend.master')

@section('title', 'Exams')

@section('body')
    <div class="row py-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">Exams</h4>
                    <button type="button" class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4 course-section-modal-btn"><i class="fa-solid fa-circle-plus"></i></button>
                </div>
                <div class="card-body">
                    <table class="table" id="file-datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Xm Type</th>
                                <th>Xm Schedule</th>
                                <th>Xm Duration</th>
                                <th>Features</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($exams))
                                @foreach($exams as $exam)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $exam->title }}</td>
                                        <td>{{ $exam->examCategory->name }}</td>
                                        <td>{{ $exam->xm_type }}</td>
                                        <td>{{ $exam->xm_date.' ('.$exam->xm_start_time.' - '.$exam->xm_end_time.')' }}</td>
                                        <td>{{ $exam->xm_duration }}</td>
                                        <td>
                                            <a href="javascript:void(0)" class="badge bg-primary">{{ $exam->is_paid == 1 ? 'Paid' : 'Free' }}</a>
                                            <a href="javascript:void(0)" class="badge bg-primary">{{ $exam->is_featured == 1 ? 'Featured' : 'Not Featured' }}</a>
                                            <a href="javascript:void(0)" class="badge bg-primary">{{ $exam->status == 1 ? 'Published' : 'Unpublished' }}</a>
                                        </td>
                                        <td>
{{--                                            <a href="{{ route('course-section-contents.index', ['section_id' => $exam->id]) }}" data-course-section-id="{{ $exam->id }}" class="btn btn-sm btn-success content-add-btn" title="Edit Course">--}}
{{--                                                <i class="fa-solid fa-circle-plus"></i>--}}
{{--                                            </a>--}}
                                            <a href="" data-section-content-id="{{ $exam->id }}" data-xm-type="exam" class="btn btn-sm btn-primary add-question-modal-btn" title="Add Questions">
                                                <i class="fa-solid fa-plus"></i>
                                            </a>
                                            <a href="" data-course-section-id="{{ $exam->id }}" class="btn btn-sm btn-warning course-section-edit-btn" title="Edit Exam">
                                                <i class="fa-solid fa-edit"></i>
                                            </a>
                                            <form class="d-inline" action="{{ route('exams.destroy', $exam->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-danger data-delete-form" title="Delete Course">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
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






{{--    form test design--}}




{{--    <div class="modal fade modal-fix" id="courseContentModal" data-modal-parent="courseContentModal" >--}}
{{--        <div class="modal-dialog modal-dialog-centered modal-lg">--}}
{{--            <div class="modal-content" id="courseSectionContentForm">--}}
{{--                @include('backend.course-management.course.course-sections.form')--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
    <div class="modal fade modal-div" id="courseSectionModal" data-modal-parent="courseSectionModal" data-bs-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content" id="">
                <form id="courseSectionForm" action="{{ isset($exam) ? route('exams.update', $exam->id) : route('exams.store') }}" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="">Create Exams</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="card card-body">
                            <div class="row">
                                @csrf
                                <div class="col-sm-4">
                                    <label for="">Title</label>
                                    <input type="text" class="form-control" name="title" placeholder="Title" />
                                </div>
                                <div class="col-sm-4 select2-div">
                                    <label for="">Exam Category</label>
                                    <select name="exam_category_id" id="" class="form-control select2" data-placeholder="Select Question Type">
                                        <option value=""></option>
                                        @foreach($examCategories as $examCategory)
                                            <option value="{{ $examCategory->id }}">{{ $examCategory->name }}</option>
                                            @if(isset($examCategory->examCategories))
                                                @include('backend.exam-management.exams.include-cat-option', ['child' => 1, 'examCategory' => $examCategory])
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-4 select2-div d-none">
                                    <label for="">Exam Type</label>
                                    <select name="xm_type" id="examType" class="form-control select2" data-placeholder="Select Question Type">
                                        <option value=""></option>
                                        <option value="MCQ" selected>MCQ</option>
                                        <option value="Written">Written</option>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label for="">Exam Price</label>
                                    <input type="text" class="form-control" name="price" placeholder="Exam Price" />
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-4">
                                    <label for="">Xm Start Date Time</label>
                                    <input type="text" id="xmDate" data-dtp="dtp_Nufud" class="form-control" name="xm_start_time"  placeholder="Exam Date" />
{{--                                    <div id="dateTime"></div>--}}
{{--                                    <input type="hidden" id="result" class="form-control" name="xm_date"  placeholder="Exam Date" />--}}
                                </div>
                                <div class="col-sm-4">
                                    <label for="">Xm End Date Time</label>
                                    <input type="text" id="xmStartTime" class="form-control" data-dtp="dtp_Nufud" name="xm_end_time"  placeholder="Start Time" />
                                </div>
                                <div class="col-sm-4">
                                    <label for="">Subscription Duration (in Days)</label>
                                    <input type="Number" class="form-control" name="xm_subscription_duration"  placeholder="Exam Subscription Duration (in Days)" />
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-4">
                                    <label for="">Exam Duration</label>
                                    <input type="number" class="form-control" name="xm_duration" placeholder="Exam Duration in Minutes" />
                                </div>
                                <div class="col-sm-4 d-none">
                                    <label for="">Total Mark</label>
                                    <input type="number" class="form-control" name="total_mark" placeholder="Total Mark" />
                                </div>
                                <div class="col-sm-4">
                                    <label for="">Per Question Mark</label>
                                    <input type="number" class="form-control" name="per_question_mark" placeholder="Per Question Mark" />
                                </div>
                                <div class="col-sm-4">
                                    <label for="">Negative Mark</label>
                                    <input type="text" class="form-control" name="negative_mark" placeholder="Negative Mark" />
                                </div>
                                <div class="col-sm-4">
                                    <label for="">Exam Pass Mark</label>
                                    <input type="number" class="form-control" name="xm_pass_mark" placeholder="Exam Pass Mark" />
                                </div>
                                <div class="col-sm-4 select2-div d-none">
                                    <label for="">Subject Name</label>
                                    <select name="subject_name" class="form-control select2" id="" data-placeholder="Select a Subject">
                                        <option value="bangla">Bangla</option>
                                        <option value="english">English</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-4">
                                    <label for="">Is Paid</label> <br>
                                    <div class="material-switch">
                                        <input id="someSwitchOptionWarning" name="is_paid" type="checkbox">
                                        <label for="someSwitchOptionWarning" class="label-info"></label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="">Is Featured</label> <br>
                                    <div class="material-switch">
                                        <input id="someSwitchOptionWarningx" name="is_featured" type="checkbox">
                                        <label for="someSwitchOptionWarningx" class="label-info"></label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="">Status</label> <br>
                                    <div class="material-switch">
                                        <input id="someSwitchOptionInfo" name="status" type="checkbox" checked="">
                                        <label for="someSwitchOptionInfo" class="label-info"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-4">
                                    <label for="">Show Mark Result</label> <br>
                                    <div class="material-switch">
                                        <input id="someSwitchOptionInfox" name="mark_base_result" type="checkbox" >
                                        <label for="someSwitchOptionInfox" class="label-info"></label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="">Xm Banner</label>
                                    <input type="file" class="form-control" id="xmImage" name="image" />
                                </div>
                                <div class="col-sm-4">
                                    <img id="imagePreview" src="">
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
    <div class="modal fade modal-div" id="examEditModal" data-modal-parent="examEditModal" data-bs-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" id="examEditModalContent">

            </div>
        </div>
    </div>
    <div class="modal fade modal-div" id="setQuestionOnExamModal" data-modal-parent="courseContentModal" >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" id="">
                <div class="modal-header">
                    <h2 class="text-center">Set Questions to Exam</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body" id="addQueModalBody">

                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <!-- DragNDrop Css -->
{{--    <link href="{{ asset('/') }}backend/assets/css/dragNdrop.css" rel="stylesheet" type="text/css" />--}}
    <style>
        input[switch]+label {
            margin-bottom: 0px;
        }

    </style>
@endpush

@push('script')

    @include('backend.includes.assets.plugin-files.datatable')
    @include('backend.includes.assets.plugin-files.date-time-picker')
{{--    @include('backend.includes.assets.plugin-files.editor')--}}
    {{--    store course--}}
    <script>
        $(document).on('click', '.course-section-modal-btn', function () {
            event.preventDefault();
            // resetInputFields();
            if ($('input[name="_method"]').length)
            {
                $('input[name="_method"]').remove();
            }
            $('#courseSectionForm').attr('action', "{{ route('exams.store') }}");
            $('#courseSectionModal').modal('show');
        })
    </script>
    <script>
        $(function () {
            $('#xmDate').bootstrapMaterialDatePicker({
                format: 'YYYY-MM-DD HH:mm',
                minDate : new Date()
            });
            $('#xmStartTime').bootstrapMaterialDatePicker({
                format: 'YYYY-MM-DD HH:mm',
                minDate : new Date()
            });
            // $('#xmEndTime').bootstrapMaterialDatePicker({
            //     format: 'HH:mm',
            //     time: true,
            //     date: false
            // });
        })
    </script>
    <script>
        $(document).on('change', '#examType', function () {
            var xmType = $(this).val();
            if (xmType != null)
            {
                $('.question-div').show();
            }

            $.ajax({
                url: base_url+'exams/get-questions-for-exam',
                method: "POST",
                data: {question_type: xmType},
                dataType: "JSON",
                success: function (data) {
                    // console.log(data);
                    var option = '';
                    $.each(data, function (key, value) {
                        option += '<option value="'+value.id+'">'+value.question+'</option>';
                    })
                    $('#selectQuestions').empty().html(option);
                    $(".select2").select2({
                        minimumResultsForSearch: "",
                        width: "100%",
                    })
                }
            })

        })
        $(document).on('focusout', '.question-topic-div .select2-container', function () {
            // var questionTopic = $('#questionTopics').val();
            // var xmType = $('#examType').val();
            alert('work');
            console.log(questionTopic);
            // if (questionTopic == null || questionTopic == '')
            // {
            //     toastr.error('Please select a Question Topic.');
            //     return false;
            // }
            // if (xmType == null || xmType == '')
            // {
            //     toastr.error('Please select a Exam Type.');
            //     return false;
            // }

            // $.ajax({
            //     url: base_url+'exams/get-questions-for-exam',
            //     method: "POST",
            //     data: {question_type: xmType, 'question'},
            //     dataType: "JSON",
            //     success: function (data) {
            //         // console.log(data);
            //         var option = '';
            //         $.each(data, function (key, value) {
            //             option += '<option value="'+value.id+'">'+value.question+'</option>';
            //         })
            //         $('#selectQuestions').empty().html(option);
            //         $(".select2").select2({
            //             minimumResultsForSearch: "",
            //             width: "100%",
            //         })
            //     }
            // })

        })
    </script>

{{--    edit course category--}}
    <script>
        $(document).on('click', '.course-section-edit-btn', function () {
            event.preventDefault();
            var courseId = $(this).attr('data-course-section-id'); //change value
            $.ajax({
                url: base_url+"exams/"+courseId+"/edit",
                method: "GET",
                // dataType: "JSON",
                success: function (data) {
                    console.log(data);
                    $('#examEditModalContent').empty().html(data);
                    $(".select2").select2({
                        minimumResultsForSearch: "",
                        width: "100%",
                    })
                    $('#xmDate1').bootstrapMaterialDatePicker({
                        format: 'YYYY-MM-DD HH:mm',
                        minDate : new Date()
                    });
                    $('#xmStartTime1').bootstrapMaterialDatePicker({
                        format: 'YYYY-MM-DD HH:mm',
                        minDate : new Date()
                    });
                    // $('#xmEndTime1').bootstrapMaterialDatePicker({
                    //     format: 'HH:mm',
                    //     time: true,
                    //     date: false
                    // });
                    $('#examEditModal').modal('show');
                }
            })
        })
    </script>
{{-- update course category--}}
    <script>
        // $(document).on('click', '.update-btn', function () {
        //     event.preventDefault();
        //     var formData = $('#courseCategoryForm').serialize();
        //     $.ajax({
        //         url: $('#courseCategoryForm').attr('action'),
        //         method: "PUT",
        //         data: formData,
        //         dataType: "JSON",
        //         // async: false,
        //         // cache: false,
        //         contentType: false,
        //         processData: false,
        //         // enctype: 'multipart/form-data',
        //         success: function (message) {
        //             // console.log(formData);
        //             toastr.success(message);
        //             $('.update-btn').addClass('submit-btn').removeClass('update-btn');
        //             $('#courseCategoryForm').attr('action', '');
        //             $('#courseCategoryModal').modal('hide');
        //             window.location.reload();
        //             resetInputFields();
        //         }
        //     })
        // })
    </script>

    <script>
        $(document).ready(function() {
            $('#xmImage').change(function() {
                var imgURL = URL.createObjectURL(event.target.files[0]);
                $('#imagePreview').attr('src', imgURL).css({
                    height: 150+'px',
                    width: 150+'px',
                    marginTop: '5px'
                });
            });
        });
    </script>

    {{--    show question add modal--}}
    <script>
        $(document).on('click', '.add-question-modal-btn', function () {
            event.preventDefault();
            var sectionContentId = $(this).attr('data-section-content-id');
            var examType = $(this).attr('data-xm-type');
            $.ajax({
                url: base_url+"get-xm-for-add-question",
                method: "GET",
                // dataType: "JSON",
                data: {exam_id:sectionContentId,exam_type:examType},
                success: function (data) {
                    console.log(data);
                    $('#addQueModalBody').empty().append(data);
                    $('.select2').select2();
                    $('#setQuestionOnExamModal').modal('show');
                }
            })
        });
        $(document).on('click', '.check-topics', function () {
            event.preventDefault();
            var questionTopicId = $('#questionTopic').val();
            var xmType = $('input[name="xm_type"]').val();
            $.ajax({
                url: base_url+"get-ques-by-topic",
                method: "GET",
                // dataType: "JSON",
                data: {question_topic_ids:questionTopicId,exam_type:xmType},
                success: function (data) {
                    console.log(data);

                    // var div = '';
                    // $.each(data, function (key, topic) {
                    //     div += '';
                    // })
                    $('#queCard').empty().append(data);
                }
            })
        });
        $(document).on('change', '.check-all', function () {
            var questionTopicId = $(this).attr('data-question-topic-id');
            if (this.checked)
            {
                $('.que-top-'+questionTopicId).each(function () {
                    this.checked = true;
                });
                $('.que-check-id-'+questionTopicId).each(function () {
                    $(this).parent().addClass('bg-warning');
                });
            } else {
                $('.que-top-'+questionTopicId).each(function () {
                    this.checked = false;
                });
                $('.que-check-id-'+questionTopicId).each(function () {
                    $(this).parent().removeClass('bg-warning');
                });
            }
        });
        $(document).on('click', '.que-check', function () {
            var questionTopicId = $(this).attr('data-topic-id');
            var questionId = $(this).attr('data-question-id');
            if (!$(this).parent().hasClass('bg-warning'))
            {
                $(this).parent().addClass('bg-warning');
            } else {
                $(this).parent().removeClass('bg-warning');
            }
            if ($('#que'+questionId).is(':checked'))
            {
                var unchecked = 0;
                $('.que-check-id-'+questionTopicId).each(function () {
                    if(!this.checked){
                        unchecked = 1;
                    }
                });
                if (unchecked == 0){
                    $('#selectAll-'+questionTopicId).prop('checked', true);
                } else {
                    $('#selectAll-'+questionTopicId).prop('checked', false);
                }
            } else {
                // $('#selectAll-'+questionTopicId).prop('checked', false);
                $('#selectAll-'+questionTopicId).attr('checked', false);
            }
        });
    </script>
@endpush
