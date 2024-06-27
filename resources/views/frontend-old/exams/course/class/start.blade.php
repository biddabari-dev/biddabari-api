@extends('frontend.master')

@section('body')

<div class="container-fluid" id="grad1">
    <div class="row">
        <div class="col-md-8 quiz-wizard mx-auto">
            <div class="card border-0">
                <div class="card-header d-flex align-items-center position-sticky" style="top: 105px!important; z-index: 10;">
                    <div>
                        <div>
                            <h2 class="quiz-name">Exam - {{ $exam->title }}</h2>
                            <span class="course-name d-block">{{ count($exam->questionStoresForClassXm) }} Questions</span>

                        </div>
                    </div>
                    <div class="mx-auto">
                        <a href="" class="btn sticky-submit-btn btn-outline-warning d-none">Submit</a>
                    </div>
                    <div class="ms-auto">
                        <a href="javascript:void(0)" class="btn btn-lg start-btn btn-success">Start</a>
                    </div>
                    <div class="quiz-time d-none" id="quizDiv">

                            <div class="flipTimer">
                                @if(isset($exam) && $exam->content_type == 'exam' ? $exam->exam_duration_in_minutes : $exam->written_exam_duration_in_minutes > 60)
                                    <div class="hours"><span class="time-title">Hours</span></div>
                                @endif
                                <div class="minutes"><span class="time-title">Minutes</span></div>
                                <div class="seconds"><span class="time-title">Seconds</span></div>
                            </div>
                    </div>

                </div>
                <!-- $quiz->questions->take(100)->shuffle(50)->random(50); -->
                <div class="card-body d-none" id="questionsCard">
                    <div class="row">
                        <div class="col-md-12 px-0" id="dtBasicExample">
                            {{--                            <form id="quizForm" action="/user/quizzes/{{ $quiz->id }}/store_results-mega" method="post" class="quiz-form">--}}
                            <form id="quizForm" action="{{ route('front.student.get-course-class-exam-result', ['content_id' => $exam->id, 'slug' => str_replace(' ', '-', $exam->title)]) }}" method="post" class="quiz-form" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="required_time">
                                @foreach($exam->questionStoresForClassXm as $index => $question)
                                    <div class="mt-2 que-ele-div" id="questionDiv{{ $question->id }}">
                                        <div class="form-card " id="fildset{{ $question->id }}">
                                            <div class="question-title" id="loop{{ $question->id }}" data-loop="{{ $loop->iteration }}" style="margin-top: 10px">
                                                <span class="float-start f-s-26">{{ $loop->iteration }}.  &nbsp;</span>
                                                <span class="float-start f-s-26"> {!! $question->question !!}</span>
                                            </div>
                                            @if(!empty($question->question_image))
                                                <div class="{{--image-container--}}">
                                                    <img src="{{ $question->question_image }}" class="fit-image" alt="" style="max-height: 350px" />
                                                </div>
                                            @endif

                                            <div class="answer-items mt-3" id="queRadio{{ $question->id }}">
                                                @foreach($question->questionOptions as $optionIndex => $questionOption)
                                                    @if(!empty($questionOption->option_title))
                                                        <div class="form-radio" >
                                                            <input class="asw{{ $questionOption->id }}" type="checkbox" name="question[{{ $question->id }}][answer]" value="{{ $questionOption->id }}">

                                                            <label class="answer-label" id="ali{{ $questionOption->id }}" data-que-id="{{ $question->id }}" data-ans-id="{{ $questionOption->id }}" for="asw{{ $questionOption->id }}">
                                                                <span class="answer-title mx-0">{{$loop->iteration .' . '. $questionOption->option_title }}</span>
                                                            </label>
                                                            <span class="ps-1 d-none cont" id="ansCheck{{ $questionOption->id }}">
                                                                    <span class="check-ans" data-option-id="{{ $questionOption->id }}" style="cursor: pointer; color: black"><i class="fa-solid fa-check"></i></span>
                                                                    <span class="text-danger cancel-ans" style="cursor: pointer; color: black"><i class="fa-solid fa-xmark"></i></span>
                                                                </span>
                                                        </div>
                                                    @else
                                                        <div class="form-radio">
                                                            <input id="asw{{ $questionOption->id }}" type="checkbox" name="question[{{ $question->id }}][answer]" value="{{ $questionOption->id }}">

                                                            <label class="" for="asw{{ $questionOption->id }}">
                                                                <img src="{{ $questionOption->option_image }}" class="fit-image" alt="">
                                                            </label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="card-actions d-flex align-items-center finish-div d-none">
                                    <button type="submit" class="action-button finish btn btn-danger">Finish Test</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('style')

<link rel="stylesheet" href="{{ asset('/') }}backend/assets/plugins/step-form-simulator/view-custom.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<link rel="stylesheet" href="{{ asset('/') }}backend/assets/plugins/clock-counter/flipTimer.css">
<style>
    /*.quiz-form .form-card .form-radio label .answer-title {*/
    /*    padding: 5px!important;*/
    /*    width: 100%;*/
    /*    text-align: left;*/
    /*}*/
    /*input[type='checkbox'] + label > span {*/

    /*}*/
    .now-active {
        /*display: block!important;*/
        /*background: #01a3a4!important;*/
        background: #ffe4d6!important;
        color: black!important;
    }
    .que-ele-div { padding: 10px 2px 20px 25px; border-radius: 10px}

    .check-ans  {
        border: 1px solid green;
        padding: 4px 3px 0px 4px;
        border-radius: 10px;
    }
    .cancel-ans  {
        border: 1px solid red;
        padding: 4px 3px 0px 4px;
        border-radius: 10px;
    }
</style>
<script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
<script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>

@endpush
@push('script')

<script type="application/javascript" src="{{ asset('/') }}backend/assets/plugins/clock-counter/jquery.flipTimer.js"></script>


{{--    <script> var sliderTimer = 6000;</script>--}}
    <script>
        $(document).on('click', '.start-btn', function () {
            event.preventDefault()
            Swal.fire({
                title: 'Are you sure to start the exam?',
                html:
                    '<ol type="i" align="left">' +
                    '<li>Make sure you have a stable internet connection.</li>'+
                    '<li>Do not Close or refresh tab before submitting the Exam.</li>'+
                    '<li>Do not Click the Back button on the ok browser while giving.</li>'+
                    '</ol>',
                text: "You won't be able to participate again!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Confirm!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Swal.fire(
                    //     'Deleted!',
                    //     'Your file has been deleted.',
                    //     'success'
                    // )
                    $(this).addClass('d-none');
                    $('#quizDiv').removeClass('d-none');
                    $('#questionsCard').removeClass('d-none');
                    $('.finish-div').removeClass('d-none');
                    $('.sticky-submit-btn').removeClass('d-none');
// timmer calling start


                    var currentTime = new Date();
                    currentTime.setMinutes(currentTime.getMinutes() + {!! isset($exam) ? $exam->class_xm_duration_in_minutes : 1 !!}); //set custom time instead 60

                    $('.flipTimer').flipTimer({
                        direction: 'down',
                        date: currentTime,
                        callback: function () {
                            $('body .action-button.finish').remove();
                            $('#quizForm').submit();
                        },
                    });
                    // timmer calling end
                    var seconds = 1;
                    setInterval(function () {
                        $('input[name="required_time"]').val(seconds++);
                    }, 1000)
                }

            })
        })

    </script>

    <script>


        $(document).on('click', '.answer-label', function () {
            var questionOptionId = $(this).attr('data-ans-id');
            var questionId = $(this).attr('data-que-id');
            var hasDisableClass = false;
            $('#queRadio'+questionId+ ' .form-radio').each(function () {
                if ($(this).hasClass('disabled-it'))
                {

                    hasDisableClass = true;
                }
            })
            if(hasDisableClass)
            {
                // alert('true');
                return false;
            }

            $('#queRadio'+questionId+ ' .answer-label').each(function () {
                if ($(this).hasClass('now-active'))
                {
                    $(this).removeClass('now-active');
                }
            })
            $('#queRadio'+questionId+ ' .cont').each(function () {
                if (!$(this).hasClass('d-none'))
                {
                    $(this).addClass('d-none');
                }
            })
            $(this).addClass('now-active');
            // $('#ansCheck'+questionOptionId).css('cssText', 'display: block!important;');
            $('#ansCheck'+questionOptionId).removeClass('d-none');
        })
        $(document).on('click', '.check-ans', function () {
            $(this).parent().addClass('d-none');
            $($(this).parent().parent()).addClass('disabled-it');
            var questionParentDivId = $($(this).parent().parent().parent().parent().parent()).attr('id');
            $(this).parent().parent().parent().parent().parent().css({
                backgroundColor : '#8efaa4',
                // color           : 'white',
            });
            $('.asw'+$(this).attr('data-option-id')).prop( "checked", true );
        })
        $(document).on('click', '.cancel-ans', function () {
            if($($(this).parent().parent()).hasClass('disabled-it'))
            {
                $($(this).parent().parent()).removeClass('disabled-it');
            }
            var parentId = $(this).parent().attr('id').split('ansCheck').join('');
            if($('label[for="asw'+parentId+'"]').hasClass('now-active'))
            {
                $('label[for="asw'+parentId+'"]').removeClass('now-active')
            }
            $(this).parent().addClass('d-none');
        })

        function isset(iVal){
            return (iVal!=="" && iVal!=null && iVal!==undefined && typeof(iVal) != "undefined") ? 1 : 0;
        }

    </script>
<script>
    $(document).on('click', '.sticky-submit-btn', function () {
        event.preventDefault();
        document.getElementById('quizForm').submit();
    })
</script>
@endpush
