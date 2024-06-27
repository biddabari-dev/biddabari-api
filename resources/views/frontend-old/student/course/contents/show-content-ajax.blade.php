<div class="card card-body ajax-content-id" data-content-id="{{ $content->id }}" data-has-class-xm="{{ $content->has_class_xm }}" data-complete-class-xm="{{ $content->is_class_xm_complete }}">
    <h3 class="text-center">{{ $content->title }}</h3>
    @if($content->content_type == 'note')
        <div class="mt-2">
            {!! $content->note_content !!}
        </div>
    @endif
    @if($content->content_type == 'link')
        <div class="mt-2">
            <p>Please click the button to view this content.</p>
            <div class="mt-2">
                <a href="{{ $content->regular_link }}" class="btn btn-success rounded-0" target="_blank">View</a>
            </div>
        </div>
    @endif
    @if($content->content_type == 'live')
        <div class="mt-2">
            <p>Our today's live class will held through {{ $content->live_source_type == 'meet' ? 'Google Meet' : '' }} {{ $content->live_source_type == 'others' ? 'Live Vendor' : '' }} {{ $content->live_source_type == 'youtube' ? 'Youtube Live' : '' }} {{ $content->live_source_type == 'zoom' ? 'Zoom Meeting' : '' }} {{ $content->live_source_type == 'facebook' ? 'Facebook' : '' }}</p>
            <span>{!! $content->live_msg !!}</span>
            <div class="mt-2">
                <a href="{{ $content->live_link }}" class="btn btn-success rounded-0" target="_blank">Go Live</a>
            </div>
        </div>
    @endif
    @if($content->content_type == 'assignment')
        <div class="mt-2">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Assignment Title</th>
                        <td>{{ $content->title }}</td>
                    </tr>
                    <tr>
                        <th>Total Mark</th>
                        <td>{{ $content->assignment_total_mark }}</td>
                    </tr>
                    <tr>
                        <th>Pass Mark</th>
                        <td>{{ $content->assignment_pass_mark }}</td>
                    </tr>
                    <tr>
                        <th>Assignment Starts At</th>
                        <td>{{ \Illuminate\Support\Carbon::parse($content->assignment_start_time)->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <th>Assignment Ends At</th>
                        <td>{{ \Illuminate\Support\Carbon::parse($content->assignment_end_time)->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <th>Assignment Result Publish Time</th>
                        <td>{{ \Illuminate\Support\Carbon::parse($content->assignment_end_time)->format('d-m-Y') }}</td>
                    </tr>
                </thead>
            </table>
            <div class="mt-1">
                <p class="f-s-22">Assignment Instructions</p>
                <span>{!! $content->assignment_instruction !!}</span>
            </div>
            <div>
                <a href="{{ asset($content->assignment_question) }}" class="text-center btn btn-warning " download="download">Download Question</a>
            </div>

            @if($content->assignment_end_time_timestamp >= strtotime(currentDateTimeYmdHi()))
                @php
                    $existAssignment = \App\Models\Backend\ExamManagement\AssignmentFile::where(['user_id' => auth()->user()->id, 'course_section_content_id' => $content->id])->first();
                @endphp
                @if(isset($existAssignment))
                    <div class="callout-danger py-2 " style="border-left: 3px solid red">
                        <span class="f-s-22 py-0">You already submitted assignment file.</span>
                    </div>
                @else
                <div class="mt-3">
                    <p>Done Your assignment? Submit Your Answers Now</p>
                    <form action="{{ route('front.student.upload-assignment-files') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="course_content_id" value="{{ $content->id }}">
                        <div class="row">
                            <label for="">Upload Files</label>
                            <input type="file" name="files[]" class="float-start" multiple accept="image/*" />
                        </div>
                        <input type="submit" class="btn btn-success float-start mt-3 btn-sm" value="Upload"/>
                    </form>
                </div>
                @endif
            @endif

            @if($content->assignment_result_publish_time_timestamp <= strtotime(currentDateTimeYmdHi()) )
                <div class="mt-3">
                    <p>View Your Assignment Script.</p>
                    <a href="{{ route('front.student.show-pdf', ['content_id' => $content->id, 'type' => 'assignment']) }}" class="btn btn-sm btn-success">View Script</a>
                </div>
            @endif
        </div>
    @endif

    @if($content->content_type == 'exam')
        <div class="mt-2">
            <table class="table table-bordered mcq-xm">
                <thead>
                    <tr>
                        <th>Exam Title</th>
                        <td>{{ $content->title }}</td>
                    </tr>
                    <tr>
                        <th>Exam Type</th>
                        <td>MCQ</td>
                    </tr>
                    <tr>
                        <th>Exam Mode</th>
                        <td>{{ $content->exam_mode }}</td>
                    </tr>
                    <tr>
                        <th>Exam Duration</th>
                        <td>{{ $content->exam_duration_in_minutes }} Min</td>
                    </tr>
                    <tr>
                        <th>Total Questions</th>
                        <td>{{ $content->exam_total_questions }}</td>
                    </tr>
                    <tr>
                        <th>Per Question Mark</th>
                        <td>{{ $content->exam_per_question_mark }}</td>
                    </tr>
                    <tr>
                        <th>Exam Negative Mark</th>
                        <td>{{ $content->exam_negative_mark }}</td>
                    </tr>
                    <tr>
                        <th>Exam Pass Mark</th>
                        <td>{{ $content->exam_pass_mark }}</td>
                    </tr>
                    <tr>
                        <th>Exam Start Time</th>
                        <td>{{ $content->content_type == 'exam' ? showDateTime($content->exam_start_time) : showDateTime($content->written_start_time) }}</td>
                    </tr>
                    <tr>
                        <th>Exam End Time</th>
                        <td>{{ $content->content_type == 'exam' ? showDateTime($content->exam_end_time) : showDateTime($content->written_end_time) }}</td>
                    </tr>
{{--                    <tr>--}}
{{--                        <th>Result Publish TIme</th>--}}
{{--                        <td>{{ $content->content_type == 'exam' ? showDateTime($content->exam_result_publish_time) : showDateTime($content->written_publish_time) }}</td>--}}
{{--                    </tr>--}}
                    @if(!$content->exam_mode == 'practice')
                        <tr>
                            <th>Exam Starts At</th>
                            <td>{{ showDateTime($content->exam_start_time) }}</td>
                        </tr>
                        <tr>
                            <th>Exam Ends At</th>
                            <td>{{ showDateTime($content->exam_end_time) }}</td>
                        </tr>
                        <tr>
                            <th>Exam Result Publish Time</th>
                            <td>{{ showDateTime($content->exam_result_publish_time) }}</td>
                        </tr>
                    @endif
                    @if($content->exam_mode == 'group')
                        <tr>
                            <th>Exam Total Subject</th>
                            <td>{{ $content->exam_total_subject }}</td>
                        </tr>
                    @endif
                </thead>
            </table>
            <div class="row mt-3">
                @php
                    $participateStatus = \App\helper\ViewHelper::checkCourseExamParticipateStatus($content->id);
                @endphp
{{--                @if(\Illuminate\Support\Carbon::parse($content->exam_start_time)->format('Y-m-d H:i') < \Illuminate\Support\Carbon::now()->format('Y-m-d H:i') && \Illuminate\Support\Carbon::parse($content->exam_end_time)->format('Y-m-d H:i') > \Illuminate\Support\Carbon::now()->format('Y-m-d H:i'))--}}
                @if( \Illuminate\Support\Carbon::now()->between(dateTimeFormatYmdHi($content->exam_start_time), dateTimeFormatYmdHi($content->exam_end_time)))
                    @if($participateStatus == 'false' && $content->exam_end_time_timestamp >= strtotime(currentDateTimeYmdHi()))
                        <div class="mb-3">
                            <p class="f-s-22">Start your exam NOW!</p>
                            <a href="{{ route('front.student.start-course-exam', ['content_id' => $content->id, 'slug' => str_replace(' ', '-', $content->title)]) }}" class="btn btn-success">Enter Exam</a>
                        </div>
                    @else
                        <div>
                            <p class="f-s-22 text-success">You already participated in this exam.</p>
                        </div>
                    @endif
                @endif
{{--                @if( \Illuminate\Support\Carbon::parse($content->exam_end_time)->format('Y-m-d H:i') < \Illuminate\Support\Carbon::now()->format('Y-m-d H:i'))--}}
                @if( dateTimeFormatYmdHi($content->exam_end_time) < currentDateTimeYmdHi())
                    <div class="callout-danger py-2 " style="border-left: 3px solid red">
                        <span class="f-s-22 py-0">Exam Has ended</span>
                    </div>
{{--                    <div class="mt-3">--}}
{{--                            <a href="{{ route('front.student.show-course-exam-answers', ['content_id' => $content->id, 'slug' => str_replace(' ', '-', $content->title)]) }}" class="btn btn-warning border" style="background-color: #f18345!important; border: 1px solid #F18345!important; color: white">See Answers</a>--}}
{{--                    </div>--}}
                @endif
                <div>
{{--                    @if(dateTimeFormatYmdHi($content->exam_result_publish_time) < currentDateTimeYmdHi())--}}
                    @if($participateStatus == 'true' || $content->exam_result_publish_time_timestamp < strtotime(currentDateTimeYmdHi()))
                        <a href="{{ route('front.student.show-course-exam-answers', ['content_id' => $content->id, 'slug' => str_replace(' ', '-', $content->title)]) }}" class="btn btn-primary">See Answers</a>
{{--                        <a href="{{ route('front.student.show-course-exam-ranking', ['content_id' => $content->id, 'slug' => str_replace(' ', '-', $content->title)]) }}" class="btn btn-primary">See Ranking</a>--}}
                    @endif
                    @if($content->exam_result_publish_time_timestamp <= strtotime(currentDateTimeYmdHi()))
{{--                        <a href="{{ route('front.student.show-course-exam-answers', ['content_id' => $content->id, 'slug' => str_replace(' ', '-', $content->title)]) }}" class="btn btn-primary">See Answers</a>--}}
                        <a href="{{ route('front.student.show-course-exam-ranking', ['content_id' => $content->id, 'slug' => str_replace(' ', '-', $content->title)]) }}" class="btn btn-primary">See Ranking</a>
                    @endif
                </div>
            </div>
        </div>
    @endif
    @if($content->content_type == 'written_exam')
        <div class="mt-2">
            <table class="table table-bordered written-xm">
                <thead>
                    <tr>
                        <th>Exam Title</th>
                        <td>{{ $content->title }}</td>
                    </tr>
                    <tr>
                        <th>Exam Type</th>
                        <td>Written</td>
                    </tr>
                    <tr>
                        <th>Exam Duration</th>
                        <td>{{ $content->written_exam_duration_in_minutes }} Min</td>
                    </tr>
                    <tr>
                        <th>Total Questions</th>
                        <td>{{ $content->written_total_questions }}</td>
                    </tr>
                    <tr>
                        <th>Exam Starts At</th>
                        <td>{{ showDateTime($content->written_start_time) }}</td>
                    </tr>
                    <tr>
                        <th>Exam Ends At</th>
                        <td>{{ showDateTime($content->written_end_time) }}</td>
                    </tr>
                    <tr>
                        <th>Exam Result Publish Time</th>
                        <td>{{ showDateTime($content->written_publish_time) }}</td>
                    </tr>
                </thead>
            </table>
            <div class="row mt-3">
                @php
                    $participateStatus = \App\helper\ViewHelper::checkCourseExamParticipateStatus($content->id);
                @endphp
{{--                @if(\Illuminate\Support\Carbon::parse($content->written_start_time)->format('Y-m-d H:i') < \Illuminate\Support\Carbon::now()->format('Y-m-d H:i') && \Illuminate\Support\Carbon::parse($content->written_end_time)->format('Y-m-d H:i') > \Illuminate\Support\Carbon::now()->format('Y-m-d H:i'))--}}
                @if( \Illuminate\Support\Carbon::now()->between(dateTimeFormatYmdHi($content->written_start_time), dateTimeFormatYmdHi($content->written_end_time)))
                    @if($participateStatus == 'false' && $content->written_end_time_timestamp >= strtotime(currentDateTimeYmdHi()))
                    <div>
                        <p class="f-s-22">Start your exam NOW!</p>
                        <a href="{{ route('front.student.start-course-exam', ['content_id' => $content->id, 'slug' => str_replace(' ', '-', $content->title)]) }}" class="btn btn-success">Enter Exam</a>
                    </div>
                    @else
                        <div class="bg-danger py-4">
                            <p class="text-white ">You already participated in this exam.</p>
                        </div>
                    @endif
                @endif
{{--                @if( \Illuminate\Support\Carbon::parse($content->written_end_time)->format('Y-m-d H:i') < \Illuminate\Support\Carbon::now()->format('Y-m-d H:i'))--}}
                @if( dateTimeFormatYmdHi($content->written_end_time) < currentDateTimeYmdHi())
                    <div class="bg-danger py-4">
                        <p class="text-white ">Exam Has ended</p>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('front.student.show-course-exam-answers', ['content_id' => $content->id]) }}" class="btn btn-warning border" style="background-color: #f18345!important; border: 1px solid #F18345!important; color: white">See Answers</a>
                        @if($content->written_publish_time_timestamp < strtotime(currentDateTimeYmdHi()))
{{--                            <a href="{{ route('front.student.show-course-exam-answers', ['content_id' => $content->id, 'slug' => str_replace(' ', '-', $content->title)]) }}" class="btn btn-primary">See Ranking</a>--}}
                            <a href="{{ route('front.student.show-course-exam-ranking', ['content_id' => $content->id, 'slug' => str_replace(' ', '-', $content->title)]) }}" class="btn btn-primary">See Ranking</a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>


