<div class="card card-body">
    <h3 class="text-center">{{ $content->title }}</h3>
    @if($content->content_type == 'note')
        <div class="mt-2">
            {!! $content->note_content !!}
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
                    <tr>
                        <th>Exam Result Publish Time</th>
                        <td>{{ showDateTime($content->exam_result_publish_time) }}</td>
                    </tr>
                    @if(!$content->exam_mode == 'practice')
                        <tr>
                            <th>Exam Starts At</th>
                            <td>{{ showDateTime($content->exam_start_time) }}</td>
                        </tr>
                        <tr>
                            <th>Exam Ends At</th>
                            <td>{{ showDateTime($content->exam_end_time) }}</td>
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
                    $participateStatus = \App\helper\ViewHelper::checkBatchExamParticipateStatus($content->id);
                @endphp
{{--                @if(dateTimeFormatYmdHi($content->exam_start_time) < \Illuminate\Support\Carbon::now()->format('Y-m-d H:i') && dateTimeFormatYmdHi($content->exam_end_time) > \Illuminate\Support\Carbon::now()->format('Y-m-d H:i'))--}}
                @if( \Illuminate\Support\Carbon::now()->between(dateTimeFormatYmdHi($content->exam_start_time), dateTimeFormatYmdHi($content->exam_end_time)))
                    @if($participateStatus == 'false')
                        <div class="mb-3">
                            <p class="f-s-22">Start your exam NOW!</p>
                            <a href="{{ route('front.student.start-batch-exam', ['content_id' => $content->id, 'slug' => str_replace(' ', '-', $content->title)]) }}" class="btn btn-success">Enter Exam</a>
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
{{--                        <a href="{{ route('front.student.show-batch-exam-answers', ['content_id' => $content->id, 'slug' => str_replace(' ', '-', $content->title)]) }}" class="btn btn-warning border" style="background-color: #f18345!important; border: 1px solid #F18345!important; color: white">See Answers</a>--}}
{{--                    </div>--}}
                @endif
{{--                @if(dateTimeFormatYmdHi($content->exam_result_publish_time) < currentDateTimeYmdHi())--}}
               <div class="mt-2">
{{--                   @if($participateStatus == 'true'|| $content->exam_result_publish_time_timestamp < strtotime(currentDateTimeYmdHi()))--}}
                   @if($content->exam_end_time_timestamp < strtotime(currentDateTimeYmdHi()))
                       <a href="{{ route('front.student.show-batch-exam-answers', ['content_id' => $content->id, 'slug' => str_replace(' ', '-', $content->title)]) }}" class="btn btn-secondary">See Answers</a>
{{--                       <a href="{{ route('front.student.show-batch-exam-ranking', ['content_id' => $content->id, 'slug' => str_replace(' ', '-', $content->title)]) }}" class="btn btn-primary">See Ranking</a>--}}
                   @endif

{{--                   @if($content->exam_result_publish_time_timestamp <= strtotime(currentDateTimeYmdHi()))--}}
                   @if($content->exam_end_time_timestamp <= strtotime(currentDateTimeYmdHi()))
{{--                       <a href="{{ route('front.student.show-batch-exam-answers', ['content_id' => $content->id, 'slug' => str_replace(' ', '-', $content->title)]) }}" class="btn btn-primary">See Ranking</a>--}}
                       <a href="{{ route('front.student.show-batch-exam-ranking', ['content_id' => $content->id, 'slug' => str_replace(' ', '-', $content->title)]) }}" class="btn btn-primary">See Ranking</a>
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
                    $participateStatus = \App\helper\ViewHelper::checkBatchExamParticipateStatus($content->id);
                @endphp
{{--                @if(\Illuminate\Support\Carbon::parse($content->written_start_time)->format('Y-m-d H:i') < \Illuminate\Support\Carbon::now()->format('Y-m-d H:i') && \Illuminate\Support\Carbon::parse($content->written_end_time)->format('Y-m-d H:i') > \Illuminate\Support\Carbon::now()->format('Y-m-d H:i'))--}}
                @if( \Illuminate\Support\Carbon::now()->between(dateTimeFormatYmdHi($content->written_start_time), dateTimeFormatYmdHi($content->written_end_time)))
                    @if($participateStatus == 'false' && $content->written_end_time_timestamp >= strtotime(currentDateTimeYmdHi()))
                        <div>
                            <p class="f-s-22">Start your exam NOW!</p>
                            <a href="{{ route('front.student.start-batch-exam', ['content_id' => $content->id, 'slug' => str_replace(' ', '-', $content->title)]) }}" class="btn btn-success">Enter Exam</a>
                        </div>
                    @else
                        <div>
                            <p class="f-s-22 text-success">You already participated in this exam.</p>
                        </div>
                    @endif
                @endif
{{--                @if( \Illuminate\Support\Carbon::parse($content->written_end_time)->format('Y-m-d H:i') < \Illuminate\Support\Carbon::now()->format('Y-m-d H:i'))--}}
                @if( dateTimeFormatYmdHi($content->written_end_time) < currentDateTimeYmdHi())
                    <div class="bg-danger py-4">
                        <p class="text-white ">Exam Has ended</p>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('front.student.show-batch-exam-answers', ['content_id' => $content->id]) }}" class="btn btn-warning border" style="background-color: #f18345!important; border: 1px solid #F18345!important; color: white">See Answers</a>
{{--                        @if(dateTimeFormatYmdHi($content->written_publish_time) < currentDateTimeYmdHi())--}}
{{--                        @if(dateTimeFormatYmdHi($content->written_end_time) < currentDateTimeYmdHi())--}}
                            <a href="{{ route('front.student.show-batch-exam-ranking', ['content_id' => $content->id, 'slug' => str_replace(' ', '-', $content->title)]) }}" class="btn btn-primary">See Ranking</a>
{{--                        @endif--}}
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>


