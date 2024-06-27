@extends('backend.master')

@section('title', 'Batch Exam Routines')

@section('body')
    <div class="row py-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">Batch Exam Contents</h4>
                    <div class="position-absolute end-0">
                        @can('create-batch-exam-section-content')
                        <button type="button" data-bs-toggle="modal" data-bs-target="#courseContentModal" class="rounded-circle text-white border-5 text-light f-s-22 btn float-end me-4 course-section-modal-btn"><i class="fa-solid fa-circle-plus"></i></button>
                        @endcan
                        <a href="{{ route('batch-exam-sections.index', ['batch_exam_id' => $_GET['batch_exam_id']]) }}" class="rounded-circle text-white border-5 text-light f-s-22 btn float-end "><i class="fa-solid fa-arrow-left"></i></a>
                    </div>
                </div>
                <div class="card-body">

                    <form action="" method="get">
                        {{--                    @csrf--}}
                        <div class="row w-50 mx-auto mb-4" >
                            <div class="col select2-div">
                                <label for="">Batch Exam Section</label>
                                <select name="category_id" class="form-control select2" id="sectionId" data-placeholder="Select Exam Category">
                                    <option value=""></option>
                                    @foreach($batchExamSections as $batchExamSection)
                                        <option value="{{ $batchExamSection->id }}">{{ $batchExamSection->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-auto">
                                <input type="button" class="btn btn-success ms-4 change-url" style="margin-top: 18px" value="Visit" />
                            </div>
                        </div>
                    </form>

                    <table class="table" id="file-datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Available at</th>
                                <th>Content Type</th>
                                <th>Features</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($sectionContents))
                                @foreach($sectionContents as $sectionContent)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if($sectionContent->content_type == 'pdf')
                                            <a href="{{ asset($sectionContent->pdf_file) }}" target="_blank">{{ $sectionContent->title }}</a>
                                            @else
                                                <a href="javascript:void(0)" >{{ $sectionContent->title }}</a>
                                            @endif
                                        </td>
                                        <td>{{ $sectionContent->available_at }}</td>
                                        <td>{{ $sectionContent->content_type == 'written_exam' ? 'Written Exam' : $sectionContent->content_type }}</td>
                                        <td>
                                            <a href="javascript:void(0)" class="badge badge-sm bg-primary">{{ $sectionContent->is_paid == 1 ? 'Paid' : 'Free' }}</a>
                                            <a href="javascript:void(0)" class="badge badge-sm bg-primary">{{ $sectionContent->status == 1 ? 'Published' : 'Unpublished' }}</a>
                                        </td>
                                        <td class="float-end">
                                            @can('add-question-to-batch-exam-section-content')
                                                @if($sectionContent->content_type == 'exam' || $sectionContent->content_type == 'written_exam')
                                                    <a href="" data-section-content-id="{{ $sectionContent->id }}" data-xm-type="{{ $sectionContent->content_type }}" class="btn btn-sm btn-primary add-question-modal-btn" title="Add Questions">
                                                        <i class="fa-solid fa-plus"></i>
                                                    </a>
                                                @endif
                                            @endcan
                                            @can('show-batch-exam-section-content')
                                                <a href="" data-section-content-id="{{ $sectionContent->id }}" class="btn btn-sm btn-success show-btn" title="Show Batch Exam Content">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                                @endcan
                                                @can('edit-batch-exam-section-content')
                                            <a href="" data-section-content-id="{{ $sectionContent->id }}" class="btn btn-sm btn-warning section-content-edit-btn" title="Edit Batch Exam Content">
                                                <i class="fa-solid fa-edit"></i>
                                            </a>
                                                @endcan
                                                @can('delete-batch-exam-section-content')
                                            <form class="d-inline" action="{{ route('batch-exam-section-contents.destroy', $sectionContent->id) }}" method="post">
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

    <div class="modal fade modal-div" id="courseContentModal" data-modal-parent="courseContentModal" >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" id="courseSectionContentForm">
                @include('backend.batch-exam-management.section-contents.form')
            </div>
        </div>
    </div>
    <div class="modal fade modal-div" id="setQuestionOnSectionContentModal" data-modal-parent="courseContentModal" >
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
        .datetimepicker {z-index: 100009!important;}
        input[switch]+label {
            margin-bottom: 0px;
        }

    </style>
@endpush

@push('script')
    @if($errors->any())
        <script>
            $(function () {
                $('#courseContentModal').modal('show');
            })
        </script>
    @endif
    @include('backend.includes.assets.plugin-files.datatable')
{{--    @include('backend.includes.assets.plugin-files.date-time-picker')--}}
    @include('backend.includes.assets.plugin-files.editor')
    <script src="{{ asset('/') }}backend/assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js"></script>

    <script>
        $(function () {
            $('#summernote1').summernote({height:70,inheritPlaceholder: true});
            $('#summernote2').summernote({height:70,inheritPlaceholder: true});
            $('#summernote3').summernote({height:70,inheritPlaceholder: true});
            $('#summernote4').summernote({height:50,inheritPlaceholder: true});
            $('input[data-dtp="dtp_Nufud"]').val(currentDateTime);
            // $('#dateTime1').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm:ss'});
            // $('#dateTime2').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm:ss'});
            // $('#dateTime3').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm:ss'});
            // $('#dateTime4').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm:ss'});
            // $('#dateTime5').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm:ss'});
            // $('#dateTime6').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm:ss'});
            // $('#dateTime7').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm:ss'});
            // $('#dateTime8').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm:ss'});
            // $('#dateTime9').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm:ss'});
            // $('#dateTime10').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm:ss'});
            // $('#dateTime11').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm:ss'});
            // $('#dateTime12').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm:ss'});
            // $('#dateTime13').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm:ss'});
            $("#datetimepicker").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0})
            $("#datetimepicker1").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0})
            $("#datetimepicker2").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0})
            $("#datetimepicker3").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0})
            $("#datetimepicker4").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0})
            $("#datetimepicker5").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0})
            $("#datetimepicker6").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0})
            $("#datetimepicker7").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0})
            $("#datetimepicker8").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0})
            $("#datetimepicker9").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0})
            $("#datetimepicker10").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0})
            $("#datetimepicker11").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0})
            $("#datetimepicker12").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0})
            $("#datetimepicker13").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0})
        })
    </script>
{{--    edit section contents--}}
    <script>
        $(document).on('click', '.section-content-edit-btn', function () {
            event.preventDefault();
            var sectionContentId = $(this).attr('data-section-content-id'); //change value
            $.ajax({
                url: base_url+"batch-exam-section-contents/"+sectionContentId+"/edit",
                method: "GET",
                // dataType: "JSON",
                success: function (data) {
                    // console.log(data);
                    $('#courseSectionContentForm').empty().append(data);
                    var summernote = $('#summernote');
                    var summernote1 = $('#summernote1');
                    var summernote2 = $('#summernote2');
                    var summernote3 = $('#summernote3');
                    var summernote4 = $('#summernote4');
                    summernote.summernote('destroy');
                    summernote.summernote();
                    summernote1.summernote('destroy');
                    summernote1.summernote();
                    summernote2.summernote('destroy');
                    summernote2.summernote();
                    summernote4.summernote('destroy');
                    summernote4.summernote();
                    $('.select2').select2();
                    // $('#dateTime1').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm:ss'});
                    // $('#dateTime2').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm:ss'});
                    // $('#dateTime3').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm:ss'});
                    // $('#dateTime4').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm:ss'});
                    // $('#dateTime5').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm:ss'});
                    // $('#dateTime6').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm:ss'});
                    // $('#dateTime7').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm:ss'});
                    // $('#dateTime8').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm:ss'});
                    // $('#dateTime9').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm:ss'});
                    // $('#dateTime10').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm:ss'});
                    // $('#dateTime11').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm:ss'});
                    // $('#dateTime12').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm:ss'});
                    // $('#dateTime13').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm:ss'});
                    $("#datetimepicker").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0})
                    $("#datetimepicker1").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0})
                    $("#datetimepicker2").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0})
                    $("#datetimepicker3").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0})
                    $("#datetimepicker4").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0})
                    $("#datetimepicker5").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0})
                    $("#datetimepicker6").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0})
                    $("#datetimepicker7").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0})
                    $("#datetimepicker8").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0})
                    $("#datetimepicker9").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0})
                    $("#datetimepicker10").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0})
                    $("#datetimepicker11").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0})
                    $("#datetimepicker12").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0})
                    $("#datetimepicker13").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0})

                    // $('#dateTime').bootstrapMaterialDatePicker({
                    //     format: 'YYYY-MM-DD HH:mm'
                    // });
                    $('#courseContentModal').modal('show');
                }
            })
        })
    </script>
{{--    Show Course contents--}}
    <script>
        $(document).on('click', '.show-btn', function () {
            event.preventDefault();
            var sectionContentId = $(this).attr('data-section-content-id'); //change value
            $.ajax({
                url: base_url+"batch-exam-section-contents/"+sectionContentId,
                method: "GET",
                // dataType: "JSON",
                success: function (data) {
                    // console.log(data);
                    $('#courseSectionContentForm').empty().append(data);
                    var summernote = $('#summernote');
                    var summernote1 = $('#summernote1');
                    var summernote2 = $('#summernote2');
                    var summernote3 = $('#summernote3');
                    var summernote4 = $('#summernote4');
                    summernote.summernote('destroy');
                    summernote.summernote();
                    summernote1.summernote('destroy');
                    summernote1.summernote();
                    summernote2.summernote('destroy');
                    summernote2.summernote();
                    summernote4.summernote('destroy');
                    summernote4.summernote();
                    $('.select2').select2();
                    $('#courseContentModal').modal('show');
                }
            })
        })
    </script>

{{--    show hide input fields depends on content type--}}
    <script>
        $(document).on('change', '#contentType', function () {
            let contentType = $(this).val();

            if (contentType == 'pdf')
            {
                addHideClassToSelector('typePdf');
            } else if(contentType == 'note')
            {
                addHideClassToSelector('typeNote');
            } else if(contentType == 'exam')
            {
                addHideClassToSelector('typeExam');
            } else if(contentType == 'written_exam')
            {
                addHideClassToSelector('typeWrittenExam');
            }

        })

        function addHideClassToSelector(selector) {
            var idData = ['typePdf','typeNote','typeExam','typeWrittenExam'];
            $.each(idData, function (key, idValue) {
                if (!$('#'+idValue).hasClass('d-none'))
                {
                    $('#'+idValue).addClass('d-none');
                }
            })
            $('#'+selector).removeClass('d-none');
        }

        $(document).on('change', '#examMode', function () {
            var examMode = $(this).val();
            if (examMode == 'exam' || examMode == 'group')
            {
                if ($('.xm-group').hasClass('d-none'))
                {
                    $('.xm-group').removeClass('d-none')
                }
            }
            if (examMode == 'group')
            {
                $('.group').removeClass('d-none');
            } else {
                $('.group').addClass('d-none');
            }
            if (examMode == 'practice')
            {
                $('.xm-group').addClass('d-none');
                $('.group').addClass('d-none');
            }
        })


    </script>

    <script>
        $(document).on('click', '.change-url', function () {
            var sectionId = $('#sectionId').val();
            window.location = base_url+"batch-exam-section-contents?section_id="+sectionId+"&batch_exam_id={{ $_GET['batch_exam_id'] }}";
        })
    </script>

{{--    pdf store show hide--}}
    <script>
        $(document).on('change', '#selectPdfFrom', function () {
            var selectPdfFrom = $(this).val();
            if (selectPdfFrom == 1)
            {
                $('#manualPdf').removeClass('d-none');
                $('#fromPdfStore').addClass('d-none');
            } else if (selectPdfFrom == 2)
            {
                $('#fromPdfStore').removeClass('d-none');
                $('#manualPdf').addClass('d-none');
            }
        });
        // get cat wise pdf file
        $(document).on('change', '#pdfStoreCategory', function () {
            var sectionContentId = $(this).val();
            $.ajax({
                url: base_url+"get-pdf-by-cat/"+sectionContentId,
                method: "GET",
                // dataType: "JSON",
                success: function (data) {
                    // console.log(data);
                    var option = '';
                    $.each(data, function (key, val) {
                        option += '<option value="'+val.file_url+'">'+val.title+'</option>';
                    })
                    $('#pdfStore').empty().append(option);
                }
            })
        })
    </script>

{{--    show question add modal--}}
    <script>
        $(document).on('click', '.add-question-modal-btn', function () {
            event.preventDefault();
            var sectionContentId = $(this).attr('data-section-content-id');
            var examType = $(this).attr('data-xm-type');
            $.ajax({
                url: base_url+"get-batch-exam-content-for-add-question",
                method: "GET",
                // dataType: "JSON",
                data: {section_content_id:sectionContentId,exam_type:examType},
                success: function (data) {
                    // console.log(data);
                    $('#addQueModalBody').empty().append(data);
                    $('.select2').select2();
                    $('#setQuestionOnSectionContentModal').modal('show');
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
                    // console.log(data);

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
    <script>
        $(document).on('click', '.detach-question', function () {
            event.preventDefault();
            var questionId = $(this).attr('data-question-id');
            var contentId = $(this).attr('data-content-id');
            $.ajax({
                url: base_url+"detach-question-from-content",
                method: "GET",
                // dataType: "JSON",
                data: {question_id:questionId,content_id:contentId},
                success: function (data) {
                    // console.log(data);
                    if (data.status == 'success')
                    {
                        $('#question'+questionId).remove();
                        toastr.success('Question deleted form this content successfully.');
                    }
                    // var div = '';
                    // $.each(data, function (key, topic) {
                    //     div += '';
                    // })
                    // $('#queCard').empty().append(data);
                },
                error: function ($error) {
                    toastr.error($error);
                }
            })
        });
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
            // $('#questionTopicModal').css('display', 'none');
            $('#questionTopicModal').modal('hide');
        })
    </script>
    <!--show hide test end-->
@endpush
