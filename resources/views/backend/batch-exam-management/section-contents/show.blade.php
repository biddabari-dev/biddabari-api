<form action="" method="post" enctype="multipart/form-data" id="coursesForm">

    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">View Batch Exam Section Content</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
    </div>
    <div class="modal-body">
        <div class="card card-body">
            <div class="row mt-2 pb-4 border-dark border-bottom">
                <div class="col-md-6 mt-2 select2-div">
                    <label for="">Content Type</label>
                    <select name="content_type" id="contentType" class="form-control select2" disabled data-placeholder="Select Content Type">
                        <option value=""></option>
                        <option value="pdf" {{ $sectionContent->content_type == 'pdf' ? 'selected' : '' }} >pdf</option>
                        <option value="note" {{ $sectionContent->content_type == 'note' ? 'selected' : '' }}>note</option>
                        <option value="exam" {{ $sectionContent->content_type == 'exam' ? 'selected' : '' }}>MCQ exam</option>
                        <option value="written_exam" {{ $sectionContent->content_type == 'written_exam' ? 'selected' : '' }}>written-exam</option>
                    </select>
                </div>
                <div class="col-sm-6 mt-2">
                    <label for="">Title</label>
                    <input type="text" class="form-control" readonly name="title" value="{{ $sectionContent->title }}" placeholder="Title" />
                </div>
                <div class="col-sm-6 mt-2">
                    <label for="">Available At</label>
                    <input type="text" class="form-control" readonly id="datetimepicker" data-dtp="dtp_Nufud" value="{{ $sectionContent->available_at }}" name="available_at" placeholder="Available Date Time" />
                </div>
                <div class="col-sm-3 mt-2">
                    <label for="">Paid</label>
                    <div class="material-switch">
                        <input id="someSwitchOptionInfo" disabled name="is_paid" type="checkbox" {{ $sectionContent->is_paid == 1 ? 'checked' : '' }}>
                        <label for="someSwitchOptionInfo" class="label-info"></label>
                    </div>
                </div>
                <div class="col-sm-3 mt-2">
                    <label for="">Status</label>
                    <div class="material-switch">
                        <input id="someSwitchOptionWarning" disabled name="status" type="checkbox" {{ $sectionContent->status == 0 ? '' : 'checked' }}>
                        <label for="someSwitchOptionWarning" class="label-info"></label>
                    </div>
                </div>
            </div>

            <div class="{{ $sectionContent->content_type == 'pdf' ? '' : 'd-none' }}" id="typePdf">
                <div class="row mt-2">
                    <div class="col-sm-6 mt-2">
                        <label for="">Link</label>
                        <input type="text" class="form-control" disabled name="pdf_link" value="{{ $sectionContent->pdf_link }}" placeholder="Link" />
                    </div>
                </div>
                <div class="row mt-2 d-none" id="manualPdf">
                    <div class="col-md-2 mt-2">
                        <span class="mt-2"><a href="{{ $sectionContent->pdf_file }}" target="_blank">View PDF</a></span>
                    </div>
                </div>
            </div>

            <div class="{{ $sectionContent->content_type == 'note' ? '' : 'd-none' }}" id="typeNote">
                <div class="row mt-2">
                    <div class="col-sm-12 mt-2">
                        <label for="">Body</label>
                        <span class="mt-2">
                            {!! $sectionContent->note_content !!}
                        </span>
                    </div>
                </div>
            </div>

            <div class="{{ $sectionContent->content_type == 'exam' ? '' : 'd-none' }}" id="typeExam">
                <div class="row mt-2">
                    <div class="col-sm-6 mt-2 select2-div">
                        <label for="">Exam Mode</label>
                        <select name="exam_mode" id="examMode" disabled class="form-control select2" data-placeholder="Select A Exam Mode">
                            <option value=""></option>
                            <option value="exam" {{ $sectionContent->exam_mode == 'exam' ? 'selected' : '' }}>exam</option>
                            <option value="practice" {{ $sectionContent->exam_mode == 'practice' ? 'selected' : '' }}>practice</option>
                            <option value="group" {{ $sectionContent->exam_mode == 'group' ? 'selected' : '' }}>group</option>
                        </select>
                    </div>
                    <div class="col-sm-6 mt-2 common">
                        <label for="">Exam Duration in Minutes</label>
                        <input type="text" name="exam_duration_in_minutes" disabled value="{{ $sectionContent->exam_duration_in_minutes }}" placeholder="Exam Duration in Minutes" class="form-control" />
                    </div>
                    <div class="col-sm-6 mt-2 common">
                        <label for="">Total Questions</label>
                        <input type="text" placeholder="Total Questions" disabled value="{{ $sectionContent->exam_total_questions }}" name="exam_total_questions" class="form-control" />
                    </div>
                    <div class="col-sm-6 mt-2 common">
                        <label for="">Per Question Mark</label>
                        <input type="number" placeholder="Per Question Mark" disabled value="{{ $sectionContent->exam_per_question_mark }}" name="exam_per_question_mark" class="form-control" />
                    </div>
                    <div class="col-sm-4 mt-2 common">
                        <label for="">Negative Mark</label>
                        <input type="text" placeholder="Negative Mark" disabled name="exam_negative_mark" value="{{ $sectionContent->exam_negative_mark }}" class="form-control" />
                    </div>
                    <div class="col-sm-4 mt-2 common">
                        <label for="">Pass Mark</label>
                        <input type="number" placeholder="Pass Mark" disabled name="exam_pass_mark" value="{{ $sectionContent->exam_pass_mark }}" class="form-control" />
                    </div>
                    <div class="col-sm-4 mt-2 xm-group {{ $sectionContent->exam_mode == 'group' || $sectionContent->exam_mode == 'exam' ? '' : 'd-none' }}">
                        <label for="">Strict</label>
                        <div class="material-switch">
                            <input id="someSwitchOptionInfox" name="exam_is_strict" disabled type="checkbox" {{ $sectionContent->exam_is_strict == 1 ? 'checked' : '' }}>
                            <label for="someSwitchOptionInfox" class="label-info"></label>
                        </div>
                    </div>
                    <div class="col-sm-6 mt-2 xm-group {{ $sectionContent->exam_mode == 'group' || $sectionContent->exam_mode == 'exam' ? '' : 'd-none' }}">
                        <label for="">Start Time</label>
                        <input type="text" id="datetimepicker8" disabled data-dtp="dtp_Nufud" placeholder="Exam Start Time" name="exam_start_time" value="{{ $sectionContent->exam_start_time }}" class="form-control" />
                    </div>
                    <div class="col-sm-6 mt-2 xm-group {{ $sectionContent->exam_mode == 'group' || $sectionContent->exam_mode == 'exam' ? '' : 'd-none' }}">
                        <label for="">End Time</label>
                        <input type="text" name="exam_end_time" disabled value="{{ $sectionContent->exam_end_time }}" id="datetimepicker9" data-dtp="dtp_Nufud" placeholder="Exam End Time" class="form-control" />
                    </div>
                    <div class="col-sm-6 mt-2 xm-group {{ $sectionContent->exam_mode == 'group' || $sectionContent->exam_mode == 'exam' ? '' : 'd-none' }}">
                        <label for="">Result Publish Time</label>
                        <input type="text" name="exam_result_publish_time" disabled value="{{ $sectionContent->exam_result_publish_time }}" id="datetimepicker10" data-dtp="dtp_Nufud" placeholder="Result Publish Time" class="form-control" />
                    </div>
                    <div class="col-sm-6 mt-2 group {{ $sectionContent->exam_mode == 'group' ? '' : 'd-none' }}">
                        <label for="">Total Subject</label>
                        <input type="text" name="exam_total_subject" disabled value="{{ $sectionContent->exam_total_subject }}" class="form-control" placeholder="Total Subject" />
                    </div>
                </div>
            </div>

            <div class="{{ $sectionContent->content_type == 'written_exam' ? '' : 'd-none' }}" id="typeWrittenExam">
                <div class="row mt-2">
                    <div class="col-sm-6 mt-2">
                        <label for="">Exam Duration in Minutes</label>
                        <input type="text" placeholder="Exam Duration in Minutes" disabled name="written_exam_duration_in_minutes" value="{{ $sectionContent->written_exam_duration_in_minutes }}" class="form-control" />
                    </div>
                    <div class="col-sm-6 mt-2">
                        <label for="">Total Questions</label>
                        <input type="text" placeholder="Total Questions" disabled name="written_total_questions" value="{{ $sectionContent->written_total_questions }}" class="form-control" />
                    </div>
                    <div class="col-sm-6 mt-2">
                        <label for="">Total Marks</label>
                        <input type="text" placeholder="Total Marks" disabled name="written_total_marks" value="{{ $sectionContent->written_total_marks }}" class="form-control" />
                    </div>
                    <div class="col-sm-6 mt-2">
                        <label for="">Pass Mark</label>
                        <input type="text" placeholder="Pass Mark" disabled name="written_pass_mark" value="{{ $sectionContent->written_pass_mark }}" class="form-control" />
                    </div>
                    <div class="col-sm-12 mt-2">
                        <label for="">Exam Description</label>
                        <span class="mt-2">
                            {!! $sectionContent->written_description !!}
                        </span>
                    </div>
                    <div class="col-sm-6 mt-2">
                        <label for="">Start Time</label>
                        <input type="text" placeholder="Exam Start Time" disabled id="datetimepicker11" data-dtp="dtp_Nufud" name="written_start_time" value="{{ $sectionContent->written_start_time }}" class="form-control" />
                    </div>
                    <div class="col-sm-6 mt-2">
                        <label for="">End Time</label>
                        <input type="text" placeholder="Exam End Time" disabled id="datetimepicker12" data-dtp="dtp_Nufud" name="written_end_time" value="{{ $sectionContent->written_end_time }}" class="form-control" />
                    </div>
                    <div class="col-sm-6 mt-2">
                        <label for="">Result Publish Time</label>
                        <input type="text" name="written_publish_time" disabled value="{{ $sectionContent->written_publish_time }}" class="form-control" id="datetimepicker13" data-dtp="dtp_Nufud" placeholder="Result Publish Time" />
                    </div>
                    <div class="col-sm-4 mt-2">
                        <label for="">Strict</label>
                        <div class="material-switch">
                            <input id="someSwitchOptionInfos" name="written_is_strict" disabled type="checkbox" {{ $sectionContent->written_is_strict == 1 ? 'checked' : '' }} />
                            <label for="someSwitchOptionInfos" class="label-info"></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

