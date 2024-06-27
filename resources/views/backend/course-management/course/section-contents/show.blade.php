<form action="" method="post" enctype="multipart/form-data" id="coursesForm">

    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">View Course Section Content</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
    </div>
    <div class="modal-body">
        <div class="card card-body">
            <div class="row mt-2 pb-4 border-dark border-bottom">
                <div class="col-md-6 mt-2 select2-div">
                    <label for="">Content Type</label>
                    <input type="hidden" name="course_section_id" value="{{ $sectionContent->course_section_id }}">
                    <select name="content_type" id="contentType" class="form-control select2" disabled data-placeholder="Select Content Type">
                        <option value=""></option>
                        <option value="pdf" {{ $sectionContent->content_type == 'pdf' ? 'selected' : '' }} >pdf</option>
                        <option value="video" {{ $sectionContent->content_type == 'video' ? 'selected' : '' }}>video</option>
                        <option value="note" {{ $sectionContent->content_type == 'note' ? 'selected' : '' }}>note</option>
                        <option value="live" {{ $sectionContent->content_type == 'live' ? 'selected' : '' }}>live</option>
                        <option value="link" {{ $sectionContent->content_type == 'link' ? 'selected' : '' }}>link</option>
                        <option value="assignment" {{ $sectionContent->content_type == 'assignment' ? 'selected' : '' }}>assignment</option>
                        <option value="testmoj" {{ $sectionContent->content_type == 'testmoj' ? 'selected' : '' }}>testmoj</option>
                        <option value="exam" {{ $sectionContent->content_type == 'exam' ? 'selected' : '' }}>MCQ exam</option>
                        <option value="written_exam" {{ $sectionContent->content_type == 'written_exam' ? 'selected' : '' }}>written-exam</option>
                    </select>
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
                <div class="col-sm-3 mt-2">
                    <label for="">Has Class Xm</label>
                    <div class="material-switch">
                        <input id="classXm" name="has_class_xm" disabled type="checkbox" {{ $sectionContent->has_class_xm == 1 ? 'checked' : '' }} />
                        <label for="classXm" id="xx" class="label-info"></label>
                    </div>
                    <span class="text-danger" id="has_class_xm">{{ $errors->has('has_class_xm') ? $errors->first('has_class_xm') : '' }}</span>
                </div>
                <div class="col-sm-7 select2-div {{ $sectionContent->has_class_xm == 0 ? 'd-none' : '' }} mt-2" id="classContentOf">
                    <label for="">Class Xm of?</label>
                    <select name="course_section_content_id" disabled required id="classXmOf" class="form-control select2" data-placeholder="Select a class">
                        <option value=""></option>
                        @foreach($sectionContents as $sectionContentSelect)
                            <option value="{{ $sectionContentSelect->id }}" {{ $sectionContent->course_section_content_id == $sectionContentSelect->id ? 'selected' : '' }}>{{ $sectionContentSelect->title }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger" id="course_section_content_id">{{ $errors->has('course_section_content_id') ? $errors->first('course_section_content_id') : '' }}</span>
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
{{--                    <div class="col-md-12 mt-2">--}}
{{--                        <div class="my-box px-3 mx-auto mt-5" style="position: relative!important; height: auto;">--}}
{{--                            <div id="pdf-container"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
                <div class="row mt-2">
                    <div class="col-sm-6 mt-2">
                        <label for="">Is Downloadable</label>
                        <div class="material-switch">
                            <input id="someSwitchOptionWarningx" disabled name="can_download_pdf" type="checkbox" {{ $sectionContent->can_download_pdf == 0 ? '' : 'checked' }} />
                            <label for="someSwitchOptionWarningx" class="label-info"></label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="{{ $sectionContent->content_type == 'video' ? '' : 'd-none' }}" id="typeVideo">
                <div class="row mt-2">
                    <div class="col-sm-6 mt-2 select2-div">
                        <label for="">Video Vendor</label>
                        <select name="video_vendor" id="" disabled class="form-control select2" data-placeholder="Select a Vendor">
                            <option value=""></option>
                            <option value="youtube" {{ $sectionContent->video_vendor == 'youtube' ? 'selected' : '' }}>youtube</option>
                            <option value="vimeo" {{ $sectionContent->video_vendor == 'vimeo' ? 'selected' : '' }}>vimeo</option>
                            <option value="private" {{ $sectionContent->video_vendor == 'private' ? 'selected' : '' }}>private</option>
                        </select>
                    </div>
                    <div class="col-sm-6 mt-2">
                        <label for="">Video Link</label>
                        <input type="text" class="form-control" disabled name="video_link" value="{{ $sectionContent->video_link }}" placeholder="Video Link" />
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-3 mt-2">
                        <label for="">Has Class Xm</label>
                        <div class="material-switch">
                            <input id="classXm" name="has_class_xm" disabled type="checkbox" {{ $sectionContent->has_class_xm == 1 ? 'checked' : '' }} />
                            <label for="classXm" id="xx" class="label-info"></label>
                        </div>
                        <span class="text-danger" id="has_class_xm">{{ $errors->has('has_class_xm') ? $errors->first('has_class_xm') : '' }}</span>
                    </div>
                    <div class="col-sm-6 select2-div {{ $sectionContent->has_class_xm == 0 ? 'd-none' : '' }} mt-2" id="classContentOf">
                        <label for="">Class Xm of?</label>
                        <select name="course_section_content_id" disabled  id="classXmOf" class="form-control select2" data-placeholder="Select a class">
                            <option value=""></option>
                            @foreach($sectionContents as $sectionContentSelect)
                                <option value="{{ $sectionContentSelect->id }}" {{ $sectionContent->course_section_content_id == $sectionContentSelect->id ? 'selected' : '' }}>{{ $sectionContentSelect->title }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger" id="course_section_content_id">{{ $errors->has('course_section_content_id') ? $errors->first('course_section_content_id') : '' }}</span>
                    </div>
                    <div class="col-sm-3  mt-2" id="">
                        <label for="">Xm Duration</label>
                        <input type="number" disabled name="class_xm_duration_in_minutes" value="{{ $sectionContent->class_xm_duration_in_minutes }}" class="form-control" />
                        <span class="text-danger" id="class_xm_duration_in_minutes">{{ $errors->has('class_xm_duration_in_minutes') ? $errors->first('class_xm_duration_in_minutes') : '' }}</span>
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

            <div class="{{ $sectionContent->content_type == 'live' ? '' : 'd-none' }}" id="typeLive">
                <div class="row mt-2">
                    <div class="col-sm-6 mt-2 select2-div">
                        <label for="">Video Source</label>
                        <select name="live_source_type" id="" disabled class="form-control select2" data-placeholder="Select a Source">
                            <option value=""></option>
                            <option value="facebook" {{ $sectionContent->live_source_type == 'facebook' ? 'selected' : '' }}>facebook</option>
                            <option value="meet" {{ $sectionContent->live_source_type == 'meet' ? 'selected' : '' }}>meet</option>
                            <option value="zoom" {{ $sectionContent->live_source_type == 'zoom' ? 'selected' : '' }}>zoom</option>
                            <option value="youtube" {{ $sectionContent->live_source_type == 'youtube' ? 'selected' : '' }}>youtube</option>
                            <option value="others" {{ $sectionContent->live_source_type == 'others' ? 'selected' : '' }}>others</option>
                        </select>
                    </div>
                    <div class="col-sm-6 mt-2">
                        <label for="">Live Link</label>
                        <input type="text" class="form-control" disabled name="live_link" value="{{ $sectionContent->live_link }}" placeholder="Live Link" />
                    </div>
                    <div class="col-sm-6 mt-2">
                        <label for="">Start Time</label>
                        <input type="text" class="form-control" disabled id="datetimepicker1" data-dtp="dtp_Nufud" name="live_start_time" value="{{ $sectionContent->live_start_time }}" placeholder="Start Time" />
                    </div>
                    <div class="col-sm-6 mt-2">
                        <label for="">End Time</label>
                        <input type="text" class="form-control" disabled id="datetimepicker2" data-dtp="dtp_Nufud" name="live_end_time" value="{{ $sectionContent->live_end_time }}" placeholder="End Time" />
                    </div>
                    <div class="col-sm-12 mt-2">
                        <label for="">Extra Message</label>
                        <span class="mt-2 bg-light">
                            {!! $sectionContent->live_msg !!}
                        </span>
                    </div>
                </div>
            </div>

            <div class="{{ $sectionContent->content_type == 'link' ? '' : 'd-none' }}" id="typeLink">
                <div class="row mt-2">
                    <div class="col-sm-6 mt-2">
                        <label for="">Link</label>
                        <input type="text" placeholder="Link" disabled value="{{ $sectionContent->regular_link }}" name="regular_link" class="form-control" />
                    </div>
                </div>
            </div>

            <div class="{{ $sectionContent->content_type == 'assignment' ? '' : 'd-none' }}" id="typeAssignment">
                <div class="row mt-2">
                    <div class="col-sm-12 mt-2">
                        <label for="">Assignment instructions</label>
                        <span class="mt-2">
                            {!! $sectionContent->assignment_instruction !!}
                        </span>
                    </div>
                    <div class="col-sm-6 mt-2">
                        <label for="">Question file</label>
                        <input type="file" name="assignment_question" disabled value="{{ $sectionContent->assignment_question }}" class="form-control" accept="application/pdf"/>
                    </div>
                    <div class="col-sm-6 mt-2">
                        <label for="">Total Mark</label>
                        <input type="text" placeholder="Total Mark" disabled value="{{ $sectionContent->assignment_total_mark }}" name="assignment_total_mark" class="form-control" />
                    </div>
                    <div class="col-sm-6 mt-2">
                        <label for="">Pass Mark</label>
                        <input type="text" placeholder="Pass Mark" disabled value="{{ $sectionContent->assignment_pass_mark }}" name="assignment_pass_mark" class="form-control" />
                    </div>
                    <div class="col-sm-6 mt-2">
                        <label for="">Start Time</label>
                        <input type="text" id="datetimepicker3" disabled data-dtp="dtp_Nufud" placeholder="Start Time" value="{{ $sectionContent->assignment_start_time }}" name="assignment_start_time" class="form-control" />
                    </div>
                    <div class="col-sm-6 mt-2">
                        <label for="">End Time</label>
                        <input type="text" placeholder="End Time" disabled id="datetimepicker4" data-dtp="dtp_Nufud" value="{{ $sectionContent->assignment_end_time }}" name="assignment_end_time" class="form-control" />
                    </div>
                    <div class="col-sm-6 mt-2">
                        <label for="">Result Publish Time</label>
                        <input type="text" placeholder="Result Publish Time" disabled value="{{ $sectionContent->assignment_result_publish_time }}" id="datetimepicker5" data-dtp="dtp_Nufud" name="assignment_result_publish_time" class="form-control" />
                    </div>
                </div>
            </div>

            <div class="{{ $sectionContent->content_type == 'testmoj' ? '' : 'd-none' }}" id="typeTestmoj">
                <div class="row mt-2">
                    <div class="col-sm-6 mt-2">
                        <label for="">Testmoj Link</label>
                        <input type="text" name="testmoj_link" disabled placeholder="Testmoj Link" value="{{ $sectionContent->testmoj_link }}" class="form-control" />
                    </div>
                    <div class="col-sm-6 mt-2">
                        <label for="">Testmoj Result Link</label>
                        <input type="text" name="testmoj_result_link" disabled value="{{ $sectionContent->testmoj_result_link }}" placeholder="Testmoj Result Link" class="form-control" />
                    </div>
                    <div class="col-sm-6 mt-2">
                        <label for="">Exam Duration in Minutes</label>
                        <input type="text" name="testmoj_xm_duration_in_minutes" disabled value="{{ $sectionContent->testmoj_xm_duration_in_minutes }}" placeholder="Exam Duration in Minutes" class="form-control" />
                    </div>
                    <div class="col-sm-6 mt-2">
                        <label for="">Total Questions</label>
                        <input type="text" name="testmoj_total_questions" disabled value="{{ $sectionContent->testmoj_total_questions }}" placeholder="Total Questions" class="form-control" />
                    </div>
                    <div class="col-sm-6 mt-2">
                        <label for="">Start Time</label>
                        <input type="text" name="testmoj_start_time" disabled value="{{ $sectionContent->testmoj_start_time }}" id="datetimepicker6" data-dtp="dtp_Nufud" placeholder="Start Time" class="form-control" />
                    </div>
                    <div class="col-sm-6 mt-2">
                        <label for="">Result Publish Time</label>
                        <input type="text" name="testmoj_result_publish_time" disabled value="{{ $sectionContent->testmoj_result_publish_time }}" id="datetimepicker7" data-dtp="dtp_Nufud" placeholder="Result Publish Time" class="form-control" />
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

