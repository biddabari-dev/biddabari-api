@extends('backend.master')

@section('title', 'Exam Sheets')

@section('body')
    <div class="row mt-5">
        <div class="col-sm-12 mx-auto">
            <div class="card card-body">
                <form action="" method="get">
                    {{--                    @csrf--}}
                    <div class="row" >
                        <div class="col select2-div">
                            <label for="">Exam Of</label>
                            <select name="exam_of" id="examOf" class="form-control select2" data-placeholder="Exam Of">
                                <option value="" selected disabled>Select a Exam Type</option>
                                <option value="course">Course</option>
                                <option value="batch_exam">Batch Exam</option>
                            </select>
                        </div>
                        <div class="col select2-div " >
                            <label for="">Exam Type Name</label>
                            <select name="exam_type_id" class="form-control select2" id="xmTypeId" data-placeholder="Select Exam Type Name">
                                <option value="" disabled >Select Exam Type Name</option>

                            </select>
                        </div>
                        <div class="col select2-div " >
                            <label for="">Select Section Name</label>
                            <select name="exam_section_id" class="form-control select2" id="sectionId" data-placeholder="Select Section Name">
                                <option value="" disabled>Select Section Name</option>

                            </select>
                        </div>
                        <div class="col select2-div " >
                            <label for="">Select Content Type</label>
                            <select name="exam_section_content_type" class="form-control " id="sectionContentType" data-placeholder="Select Section Name">
                                <option value="" >Select Section Name</option>
                                <option value="written">Written Exam</option>
                                <option value="assignment" id="assignment">Assignment</option>
                            </select>
                        </div>
                        <div class="col select2-div " >
                            <label for="">Select Exam Content</label>
                            <select name="section_content_id" class="form-control select2" id="xmId" data-placeholder="Select a Exam">
                                <option value="" disabled>Select a Exam</option>

                            </select>
                        </div>
                        <div class="col-auto xm-name-show-hide d-none">
                            <input type="submit" class="btn btn-success ms-4 " style="margin-top: 18px" value="Search" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if(isset($examSheets) && !empty($examSheets))
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Manage Exam Sheets</h2>
                    </div>
                    <div class="card-body">
                        <table class="table" id="file-datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Exam Name</th>
                                <th>Student Name</th>
                                <th>Exam File</th>
                                <th>Total Mark</th>
                                <th>Result Mark</th>
                                <th>Result Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($examSheets))
                                @foreach($examSheets as $examSheet)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $examOf == 'course' ? $examSheet->courseSectionContent->title : $examSheet->batchExamSectionContent->title }}</td>
                                        <td>{{ $examSheet->user->name ?? '' }}</td>
                                        <td>
                                            <a href="{{ route('check-xm-paper', ['id' => $examSheet->id, 'typeOf' => $examOf, 'sectionContentType' => $sectionContentType]) }}" target="_blank" >pdf file</a>
                                        </td>
                                        <td>{{ $examSheet->exam->total_mark ?? '' }}</td>
                                        <td>{{ $examSheet->result_mark ?? '' }}</td>
                                        <td>{{ $examSheet->status ?? '' }}</td>
                                        <td>
                                        <a href="" data-blog-category-id="{{ $examSheet->id }}" class="btn btn-sm btn-warning blog-category-edit-btn" title="Change Order Status">
                                                <i class="fa-solid fa-edit"></i>
                                            </a>
{{--                                        <a href="" data-blog-category-id="{{ $examSheet->id }}" class="btn btn-sm btn-primary blog-category-edit-btnx" title="Change Order Status">--}}
{{--                                                <i class="fa-solid fa-edit"></i>--}}
{{--                                            </a>--}}
                                        {{--                                            <form class="d-inline" action="{{ route('course-orders.destroy', $examSheet->id) }}" method="post" onsubmit="return confirm('Are you sure to delete this? Once deleted, It can not be undone.')">--}}
                                        {{--                                                @csrf--}}
                                        {{--                                                @method('delete')--}}
                                        {{--                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete Blog Category">--}}
                                        {{--                                                    <i class="fa-solid fa-trash"></i>--}}
                                        {{--                                                </button>--}}
                                        {{--                                            </form>--}}
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
    @endif
    <div class="modal fade modal-div" id="blogCategoryModal" data-modal-parent="blogCategoryModal" data-bs-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" id="">
                <form id="courseSectionForm" action="{{ route('update-xm-result') }}" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="">Update Course Order Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="card card-body">
                            @csrf
                            {{--                            <input type="hidden" id="courseIdEdit" name="edit_course_id" />--}}
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="paidAmount">result Mark</label>
                                    <input type="text" class="form-control" name="result_mark" id="resultMark" placeholder="Result Mark" />
                                    <input type="hidden" class="form-control" name="xm_result_id" id="xmResultId" />
                                </div>
                                <div class="col-md-6">
                                    <label for="paidAmount">Upload File</label>
                                    <input type="file" class="form-control" name="written_xm_file" placeholder="Written Xm File" />
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

@endsection

@push('script')

    @include('backend.includes.assets.plugin-files.datatable')
    {{--    @include('backend.includes.assets.plugin-files.date-time-picker')--}}
    {{--    @include('backend.includes.assets.plugin-files.editor')--}}

    {{--    edit course category--}}
    <script>
        $(document).on('click', '.blog-category-edit-btn', function () {
            event.preventDefault();
            var courseId = $(this).attr('data-blog-category-id'); //change value
            $('#xmResultId').val(courseId);
            $.ajax({
                url: base_url+"get-exam-sheet-data/"+courseId,
                method: "GET",
                dataType: "JSON",
                success: function (data) {
                    $('#resultMark').val(data.result_mark);
                    $('#blogCategoryModal').modal('show');
                }
            })

        })
    </script>
    <script>
        $(document).on('change', '#examOf', function () {
            event.preventDefault();
            var xmOf = $(this).val(); //change value
            if (xmOf == 'batch_exam')
            {
                $('#assignment').css('display', 'none');
            } else {
                $('#assignment').css('display', 'block');
            }
            $.ajax({
                url: base_url+"get-course-or-batch-exam-names/"+xmOf,
                method: "GET",
                dataType: "JSON",
                success: function (data) {
                    console.log(data);
                    var option = '';
                    option  += '<option selected disabled>Select a course</option>';
                    $.each(data, function (key, xmOf) {
                        option += '<option value="'+xmOf.id+'">'+xmOf.title+'</option>';
                    })
                    $('#xmTypeId').empty().append(option).select2();
                }
            })
        })
        $(document).on('change', '#xmTypeId', function () {
            event.preventDefault();
            var xmOf = $('#examOf').val(); //change value
            var xmTypeId = $(this).val(); //change value
            $.ajax({
                url: base_url+"get-exam-names/"+xmOf+'/'+xmTypeId,
                method: "GET",
                dataType: "JSON",
                success: function (data) {
                    // console.log(data);
                    var option = '';
                    option += '<option selected disabled>Select Section Name</option>';
                    $.each(data, function (key, xmTypeId) {
                        option += '<option value="'+xmTypeId.id+'">'+xmTypeId.title+'</option>';
                    })
                    $('#sectionId').empty().append(option).select2();
                }
            })
        })
        // $(document).on('change', '#sectionId', function () {
        $(document).on('change', '#sectionContentType', function () {
            event.preventDefault();
            var xmOf = $('#examOf').val(); //change value
            var sectionId = $('#sectionId').val(); //change value
            var sectionContentType = $(this).val(); //change value
            $.ajax({
                url: base_url+"get-written-section-contents/"+xmOf+'/'+sectionId+'/'+sectionContentType,
                method: "GET",
                dataType: "JSON",
                success: function (data) {
                    // console.log(data);
                    var option = '';
                    option += '<option value="" disabled>Select a Exam</option>';
                    $.each(data, function (key, sectionId) {
                        option += '<option value="'+sectionId.id+'">'+sectionId.title+'</option>';
                    })
                    $('#xmId').empty().append(option).select2();
                    $('.xm-name-show-hide').removeClass('d-none');
                }
            })
        })
    </script>
@endpush
