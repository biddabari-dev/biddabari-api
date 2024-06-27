<form action="{{ isset($sectionContent) ? route('batch-exam-section-contents.update', $sectionContent->id) : route('batch-exam-section-contents.store') }}" method="post" enctype="multipart/form-data" id="coursesForm">
    @csrf
    @if(isset($sectionContent))
        @method('put')
    @endif
        <input type="hidden" name="batch_exam_id" value="{{ request()->input('batch_exam_id') }}" />
    @csrf
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Batch Exam Section Content</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
    </div>
    {{--                    <input type="hidden" name="category_id" >--}}
    <div class="modal-body">
        <div class="card card-body">
            <div class="row mt-2 pb-4 border-dark border-bottom">
                <div class="col-md-6 mt-2 select2-div">
                    <label for="">Content Type</label>
                    <input type="hidden" name="batch_exam_section_id" value="{{ $sectionContent->batch_exam_section_id }}">
                    <select name="content_type" id="contentType" class="form-control select2" data-placeholder="Select Content Type">
                        <option value=""></option>
                        <option value="pdf" {{ $sectionContent->content_type == 'pdf' ? 'selected' : '' }} >pdf</option>
                        <option value="note" {{ $sectionContent->content_type == 'note' ? 'selected' : '' }}>note</option>
                        <option value="exam" {{ $sectionContent->content_type == 'exam' ? 'selected' : '' }}>MCQ exam</option>
                        <option value="written_exam" {{ $sectionContent->content_type == 'written_exam' ? 'selected' : '' }}>written-exam</option>
                    </select>
                    <span class="text-danger" id="content_type">{{ $errors->has('content_type') ? $errors->first('content_type') : '' }}</span>
                </div>
{{--                <div class="col-md-6 mt-2 select2-div">--}}
{{--                    <label for="">Content Type</label>--}}
{{--                    <select name="parent_id" class="form-control select-2" data-placeholder="Select Content Type">--}}
{{--                        <option value=""></option>--}}
{{--                        <option value="1">course title one</option>--}}
{{--                        <option value="2">course title two</option>--}}
{{--                    </select>--}}
{{--                </div>--}}
                <div class="col-sm-6 mt-2">
                    <label for="">Title</label>
                    <input type="text" class="form-control" name="title" value="{{ $sectionContent->title }}" placeholder="Title" />
                    <span class="text-danger" id="title">{{ $errors->has('title') ? $errors->first('title') : '' }}</span>
                </div>
                <div class="col-sm-6 mt-2">
                    <label for="">Available At</label>
                    <input type="text" class="form-control" id="datetimepicker" data-dtp="dtp_Nufud" value="{{ $sectionContent->available_at }}" name="available_at" placeholder="Available Date Time" />
                    <span class="text-danger" id="available_at">{{ $errors->has('available_at') ? $errors->first('available_at') : '' }}</span>
                </div>
                <div class="col-sm-3 mt-2">
                    <label for="">Paid</label>
                    <div class="material-switch">
                        <input id="someSwitchOptionInfo" name="is_paid" type="checkbox" {{ $sectionContent->is_paid == 1 ? 'checked' : '' }}>
                        <label for="someSwitchOptionInfo" class="label-info"></label>
                    </div>
                </div>
                <div class="col-sm-3 mt-2">
                    <label for="">Status</label>
                    <div class="material-switch">
                        <input id="someSwitchOptionWarning" name="status" type="checkbox" {{ $sectionContent->status == 0 ? '' : 'checked' }}>
                        <label for="someSwitchOptionWarning" class="label-info"></label>
                    </div>
                </div>
            </div>

            <div class="{{ $sectionContent->content_type == 'pdf' ? '' : 'd-none' }}" id="typePdf">
                <div class="row mt-2">
                    <div class="col-sm-6 mt-2">
                        <label for="">Link</label>
                        <input type="text" class="form-control" name="pdf_link" value="{{ $sectionContent->pdf_link }}" placeholder="Link" />
                    </div>
                    <div class="col-sm-4 mt-2 select2-div">
                        <label for="">Upload PDF From</label>
                        <select name="pdf_select_form" id="selectPdfFrom" class="form-control select-2" data-placeholder="Select Where to upload pdf">
                            <option disabled selected>Select Where to upload pdf</option>
                            <option value="1">Manual</option>
                            <option value="2">PDF Store</option>
                        </select>
                    </div>
                    <div class="col-md-2 mt-2">
                        <span class="mt-2"><a href="{{ $sectionContent->pdf_file }}" target="_blank">View PDF</a></span>
                    </div>
                </div>
                <div class="row mt-2 d-none" id="manualPdf">
                    <div class="col-sm-6 mt-2">
                        <label for="">PDF File</label>
                        <input type="file" class="form-control" name="pdf_file" accept="application/pdf" placeholder="PDF File" />
                    </div>
                </div>
                <div class="row mt-2 d-none" id="fromPdfStore">
                    <div class="col-sm-6 mt-2 select2-div">
                        <label for="">PDF Store Category</label>
                        <select name="" id="pdfStoreCategory" class="form-control select2" data-placeholder="Select a Pdf Category">
                            <option disabled selected>Select a Pdf Category</option>
{{--                            @foreach($pdfStoreCategories as $pdfStoreCategory)--}}
{{--                                <option value="{{ $pdfStoreCategory->id }}">{{ $pdfStoreCategory->title }}</option>--}}
{{--                            @endforeach--}}
                            @foreach($pdfStoreCategories as $pdfStoreCategory)
                                <option value="{{ $pdfStoreCategory->id }}">{{ $pdfStoreCategory->title }}</option>
                                @if(!empty($pdfStoreCategory->pdfStoreCategories))
                                    @if(count($pdfStoreCategory->pdfStoreCategories) > 0)
                                        @include('backend.course-management.course.section-contents.pdf-category-loop', ['courseCategory' => $pdfStoreCategory, 'child' => 1])
                                    @endif
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6 mt-2 select2-div">
                        <label for="">PDF File</label>
                        <select name="pdf_store_url" id="pdfStore" class="form-control select2" data-placeholder="Select a Pdf file">
                            <option disabled selected></option>

                        </select>
                    </div>
                </div>
            </div>

            <div class="{{ $sectionContent->content_type == 'note' ? '' : 'd-none' }}" id="typeNote">
                <div class="row mt-2">
                    <div class="col-sm-12 mt-2">
                        <label for="">Body</label>
                        <textarea name="note_content" class="form-control" id="summernote1" placeholder="Body" cols="30" rows="10">{!! $sectionContent->note_content !!}</textarea>
                    </div>
                </div>
            </div>

            <div class="{{ $sectionContent->content_type == 'exam' ? '' : 'd-none' }}" id="typeExam">
                <div class="row mt-2">
                    <div class="col-sm-6 mt-2 select2-div">
                        <label for="">Exam Mode</label>
                        <select name="exam_mode" id="examMode" class="form-control select2" data-placeholder="Select A Exam Mode">
                            <option value=""></option>
                            <option value="exam" {{ $sectionContent->exam_mode == 'exam' ? 'selected' : '' }}>exam</option>
                            <option value="practice" {{ $sectionContent->exam_mode == 'practice' ? 'selected' : '' }}>practice</option>
                            <option value="group" {{ $sectionContent->exam_mode == 'group' ? 'selected' : '' }}>group</option>
                        </select>
                    </div>
                    <div class="col-sm-6 mt-2 common">
                        <label for="">Exam Duration in Minutes</label>
                        <input type="text" name="exam_duration_in_minutes" value="{{ $sectionContent->exam_duration_in_minutes }}" placeholder="Exam Duration in Minutes" class="form-control" />
                    </div>
                    <div class="col-sm-6 mt-2 common">
                        <label for="">Total Questions</label>
                        <input type="text" placeholder="Total Questions" value="{{ $sectionContent->exam_total_questions }}" name="exam_total_questions" class="form-control" />
                    </div>
                    <div class="col-sm-6 mt-2 common">
                        <label for="">Per Question Mark</label>
                        <input type="number" placeholder="Per Question Mark" value="{{ $sectionContent->exam_per_question_mark }}" name="exam_per_question_mark" class="form-control" />
                    </div>
                    <div class="col-sm-4 mt-2 common">
                        <label for="">Negative Mark</label>
                        <input type="text" placeholder="Negative Mark" name="exam_negative_mark" value="{{ $sectionContent->exam_negative_mark }}" class="form-control" />
                    </div>
                    <div class="col-sm-4 mt-2 common">
                        <label for="">Pass Mark</label>
                        <input type="number" placeholder="Pass Mark" name="exam_pass_mark" value="{{ $sectionContent->exam_pass_mark }}" class="form-control" />
                    </div>
                    <div class="col-sm-4 mt-2 xm-group {{ $sectionContent->exam_mode == 'group' || $sectionContent->exam_mode == 'exam' ? '' : 'd-none' }}">
                        <label for="">Strict</label>
                        <div class="material-switch">
                            <input id="someSwitchOptionInfox" name="exam_is_strict" type="checkbox" {{ $sectionContent->exam_is_strict == 1 ? 'checked' : '' }}>
                            <label for="someSwitchOptionInfox" class="label-info"></label>
                        </div>
                    </div>
                    <div class="col-sm-6 mt-2 xm-group {{ $sectionContent->exam_mode == 'group' || $sectionContent->exam_mode == 'exam' ? '' : 'd-none' }}">
                        <label for="">Start Time</label>
                        <input type="text" id="datetimepicker8" data-dtp="dtp_Nufud" placeholder="Exam Start Time" name="exam_start_time" value="{{ $sectionContent->exam_start_time }}" class="form-control" />
                    </div>
                    <div class="col-sm-6 mt-2 xm-group {{ $sectionContent->exam_mode == 'group' || $sectionContent->exam_mode == 'exam' ? '' : 'd-none' }}">
                        <label for="">End Time</label>
                        <input type="text" name="exam_end_time" value="{{ $sectionContent->exam_end_time }}" id="datetimepicker9" data-dtp="dtp_Nufud" placeholder="Exam End Time" class="form-control" />
                    </div>
                    <div class="col-sm-6 mt-2 xm-group {{ $sectionContent->exam_mode == 'group' || $sectionContent->exam_mode == 'exam' ? '' : 'd-none' }}">
                        <label for="">Result Publish Time</label>
                        <input type="text" name="exam_result_publish_time" value="{{ $sectionContent->exam_result_publish_time }}" id="datetimepicker10" data-dtp="dtp_Nufud" placeholder="Result Publish Time" class="form-control" />
                    </div>
                    <div class="col-sm-6 mt-2 group {{ $sectionContent->exam_mode == 'group' ? '' : 'd-none' }}">
                        <label for="">Total Subject</label>
                        <input type="text" name="exam_total_subject" value="{{ $sectionContent->exam_total_subject }}" class="form-control" placeholder="Total Subject" />
                    </div>
                </div>
            </div>

            <div class="{{ $sectionContent->content_type == 'written_exam' ? '' : 'd-none' }}" id="typeWrittenExam">
                <div class="row mt-2">
                    <div class="col-sm-6 mt-2">
                        <label for="">Exam Duration in Minutes</label>
                        <input type="text" placeholder="Exam Duration in Minutes" name="written_exam_duration_in_minutes" value="{{ $sectionContent->written_exam_duration_in_minutes }}" class="form-control" />
                    </div>
                    <div class="col-sm-6 mt-2">
                        <label for="">Total Questions</label>
                        <input type="text" placeholder="Total Questions" name="written_total_questions" value="{{ $sectionContent->written_total_questions }}" class="form-control" />
                    </div>
                    <div class="col-sm-6 mt-2">
                        <label for="">Total Marks</label>
                        <input type="text" placeholder="Total Marks" name="written_total_marks" value="{{ $sectionContent->written_total_marks }}" class="form-control" />
                    </div>
                    <div class="col-sm-6 mt-2">
                        <label for="">Pass Mark</label>
                        <input type="text" placeholder="Pass Mark" name="written_pass_mark" value="{{ $sectionContent->written_pass_mark }}" class="form-control" />
                    </div>
                    <div class="col-sm-12 mt-2">
                        <label for="">Exam Description</label>
                        <textarea name="written_description" placeholder="Exam Description" class="form-control" id="summernote3" cols="30" rows="10">{!! $sectionContent->written_description !!}</textarea>
                    </div>
                    <div class="col-sm-6 mt-2">
                        <label for="">Start Time</label>
                        <input type="text" placeholder="Exam Start Time" id="datetimepicker11" data-dtp="dtp_Nufud" name="written_start_time" value="{{ $sectionContent->written_start_time }}" class="form-control" />
                    </div>
                    <div class="col-sm-6 mt-2">
                        <label for="">End Time</label>
                        <input type="text" placeholder="Exam End Time" id="datetimepicker12" data-dtp="dtp_Nufud" name="written_end_time" value="{{ $sectionContent->written_end_time }}" class="form-control" />
                    </div>
                    <div class="col-sm-6 mt-2">
                        <label for="">Result Publish Time</label>
                        <input type="text" name="written_publish_time" value="{{ $sectionContent->written_publish_time }}" class="form-control" id="datetimepicker13" data-dtp="dtp_Nufud" placeholder="Result Publish Time" />
                    </div>
                    <div class="col-sm-4 mt-2">
                        <label for="">Strict</label>
                        <div class="material-switch">
                            <input id="someSwitchOptionInfos" name="written_is_strict" type="checkbox" {{ $sectionContent->written_is_strict == 1 ? 'checked' : '' }} />
                            <label for="someSwitchOptionInfos" class="label-info"></label>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary " value="save">Save</button>
    </div>
</form>

