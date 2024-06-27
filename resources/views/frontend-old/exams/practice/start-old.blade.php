@extends('frontend.master')

@section('body')

<div class="container-fluid" id="grad1">
    <div class="row">
        <div class="col-md-8 quiz-wizard mx-auto">
            <div class="card border-0">
                <div class="card-header d-flex align-items-center">
                    <div>
                        <div>
                            <h2 class="quiz-name">Exam - {{ $exam->title }}</h2>
                            <span class="course-name d-block">{{ count($exam->questionStores) }} Questions</span>
                        </div>
                    </div>
                    <div class="quiz-time">
                            <div class="flipTimer">
                                @if(isset($exam) && $exam->xm_duration > 60)
                                    <div class="hours"><span class="time-title">Hours</span></div>
                                @endif
                                <div class="minutes"><span class="time-title">Minutes</span></div>
                                <div class="seconds"><span class="time-title">Seconds</span></div>
                            </div>
                    </div>

                </div>
                <!-- $quiz->questions->take(100)->shuffle(50)->random(50); -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 px-0" id="dtBasicExample">
                            {{--                            <form id="quizForm" action="/user/quizzes/{{ $quiz->id }}/store_results-mega" method="post" class="quiz-form">--}}
                            <form id="quizForm" action="{{ route('front.student.get-exam-result', ['xm_id' => $exam->id, 'slug' => $exam->slug]) }}" method="post" class="quiz-form" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                @if($exam->xm_type == 'MCQ')
                                @foreach($exam->questionStores as $index => $question)
                                    <fieldset id="fieldset{{ $question->id }}">
                                        <input type="hidden" name="question[{{ $question->id }}]" value="{{ $question->id }}">
                                        <div class="form-card " id="fildset{{ $question->id }}">
                                            <div class="question-title" id="loop{{ $question->id }}" data-loop="{{ $loop->iteration }}" style="margin-top: 10px">
                                                <span class="float-start">{{ $loop->iteration }}.  &nbsp;</span>
                                                <span class="float-start"> {!! $question->question !!}</span>
                                            </div>
                                            @if(!empty($question->question_image))
                                                <div class="image-container">
                                                    <img src="{{ $question->question_image }}" class="fit-image" alt="">
                                                </div>

                                            @endif
                                            <div class="answer-items mt-3">
                                                @foreach($question->questionOptions as $optionIndex => $questionOption)
                                                    @if(!empty($questionOption->option_title))
                                                        <div class="form-radio">
                                                            <input id="asw{{ $questionOption->id }}" type="checkbox" name="question[{{ $question->id }}][answer]" value="{{ $questionOption->id }}">

                                                            <label class="answer-label" for="asw{{ $questionOption->id }}">
                                                                <span class="answer-title mx-0">{{$loop->iteration .' . '. $questionOption->option_title }}</span>
                                                            </label>
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
                                        <div class="card-actions d-flex align-items-center">
                                            <button type="button" class="action-button previous btn btn-custom btn-outline-primary" style="display: none">Previous Question</button>
                                            <button type="button" class="action-button next btn btn-custom btn-outline-primary">Next Question</button>
                                            <button type="button" class="action-button finish btn btn-danger">Finish Test</button>
                                        </div>

                                    </fieldset>
                                @endforeach
                                @elseif($exam->xm_type == 'Written')
                                    @foreach($exam->questionStores as $index => $question)
                                        <div class="row mt-2">
                                            <div class="col-md-12">
                                                <span class="float-start" style="font-size: 22px">{{ $loop->iteration }}. &nbsp;</span>
                                                <h4 class="float-start fw-bold">{!! $question->question !!}</h4>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="row mt-3">
                                        <div class="col-md-5">
                                            <label for="uploadFiles" class="float-start">Upload Answer Images</label>
                                            <input type="file" name="ans_files[]" class="form-control" multiple accept="image/*" />
                                        </div>
                                        <div class="col-md-3">

                                        </div>
                                        <div class="col-md-4">
                                            <input type="submit" class="btn btn-danger mt-4" value="Finish Test" />
                                        </div>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="finishModal" style="z-index: 1500">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Finish Exam</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure to finish this test?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="SubmitResult" class="btn btn-primary">Yes Sure</button>
            </div>
        </div>
    </div>
</div>

@endsection
@push('style')

<link rel="stylesheet" href="{{ asset('/') }}backend/assets/plugins/step-form-simulator/view-custom.css">


<link rel="stylesheet" href="{{ asset('/') }}backend/assets/plugins/clock-counter/flipTimer.css">
<style>
    /*.quiz-form .form-card .form-radio label .answer-title {*/
    /*    padding: 5px!important;*/
    /*    width: 100%;*/
    /*    text-align: left;*/
    /*}*/
    /*input[type='checkbox'] + label > span {*/

    /*}*/
</style>
<style>
    .btn-custom {
        border: 2px solid #ffcf00;
        background: #ffcf00;
        color: #000;
        border-radius: 25px;
        transition: 0.2s;
    }
    .btn-custom:hover {
        color: white;
        background-color: #01a3a4;
        transition: 0.2s;
        border-color: #01a3a4;
    }
    input[type='checkbox'] + label:hover, input[type='checkbox']:focus + label {
        /*color: #01a3a4;*/
        color: red;
    }
    .quiz-wizard .quiz-name {
        color: #01a3a4;
        font-size: 24px;
    }

    .quiz-form fieldset .form-card {
        text-align: center;
        color: #9E9E9E;
        padding: 32px 48px;
    }
    .quiz-form fieldset .form-card .question-title {
        margin-bottom: 16px;
        font-size: 30px;
        font-weight: 500;
        line-height: 1.19;
        text-align: left;
        color: #6b6b6b;
        margin-left: 45px;
    }

    .quiz-form .form-card .form-radio label .answer-title {
        padding: 6px 15px;
        text-align: left;
        margin-left: 15px;
        font-size: 20px;
    }

    .quiz-form .form-card .answer-items {
        padding: 0 48px;
        margin-top: 32px;
        margin-bottom: 30px;
        display:flex;
        flex-direction:column;
        /*width: 70%;*/
    }
    input.btn.btn-orange.pull-left {
        border: 2px solid #01a3a4;
        color: #000000;
    }
    input.btn.btn-orange.pull-left:hover {
        background-color: #01a3a4;
    }
    input.btn.btn-custom {
        box-shadow: 0 0 0 2px #01a3a4;
    }

    input.btn.btn-custom:hover {
        background: #01a3a4;
    }
    .quiz-form .form-card .form-radio input[type=radio]:checked + label {
        background: #01a3a4;
        color: #fff;
    }
    input[type='checkbox'] + label > span {
        margin-right: 5px;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100% !important;
        height: 100% !important;
        background: transparent;
        border: none;
        border-radius: 2px;
        cursor: pointer;
        transition: all 250ms cubic-bezier(.4, .0, .23, 1);
        margin-left: 6px;
    }


    input[type='checkbox']:checked + label > span {
        border: none;
        animation: none;
        color: white;
    }
    .form-radio input[type='checkbox']:checked + label {
        background: #01a3a4 !important;
    }

    input[type='checkbox']:checked + label > span:before {
        content: "";
        position: absolute;
        top: .6em;
        left: 0.1em;
        font-size: 1.5em;
        border-right: 3px solid transparent;
        border-bottom: 3px solid transparent;
        transform: rotate(45deg);
        transform-origin: 0% 100%;
        animation: checkbox-check 125ms 250ms cubic-bezier(.8, .0, .89, 1) forwards;
    }

    @keyframes checkbox-check {
        0% {
            width: 0;
            height: 0;
            border-color: #01a3a4;
            transform: translate3d(0, 0, 0) rotate(45deg);
        }
        33% {
            width: .2em;
            height: 0;
            transform: translate3d(0, 0, 0) rotate(45deg);
        }
        100% {
            width: .2em;
            height: .5em;
            border-color: #01a3a4;
            transform: translate3d(0, -.5em, 0) rotate(45deg);
        }
    }
    button.btn.btn-custom.pull-left {
        border: 2px solid #01a3a4;
    }

    button.btn.btn-custom.pull-left:hover {
        background-color: #01a3a4;
        color: white;
        transition: 0.2s;
    }
    body > div:nth-child(2) > div.container.text-center > div > div.box.registerBox > form > div.form-group > label:hover {
        color: #01a3a4;
    }


    .header-login-button span {
        color: #01a3a4;
        position: absolute;
        left: 20%;
        transform: translateX(-50%);
        top: 0;
    }
    .quiz-form .form-card .answer-items11 {
        padding: 0px 38px;
        margin-top: 32px;
        display: flex;
        flex-direction: column;
        width: 70%;
        margin-left: -32px;
    }
    .quiz-form .btn {
        padding: 9px 26px;
        font-weight: 600;
    }
    .btn-custom {
        border: 2px solid #01a3a4;
        background: #01a3a4;
        color: #fff;
    }

    .btn-custom:hover {
        background-color: #ffcb00;
        border-color: #ffcb00;
    }
    .quiz-wizard .card-header {
        margin-top: -58px;
    }
    .quiz-wizard .card-header {
        padding: 16px 24px;
    }
    .quiz-form fieldset .form-card, .quiz-result .result-card {
        padding: 0px 24px;
        padding-right: 60px;
    }

    .quiz-form .form-card .image-container {
        position: relative;
        cursor: pointer;

        border-radius: 10px;
    }
</style>
@endpush
@push('script')

<script type="application/javascript" src="{{ asset('/') }}backend/assets/plugins/clock-counter/jquery.flipTimer.js"></script>


{{--    <script> var sliderTimer = 6000;</script>--}}
    <script>
        "use strict";
        $(document).ready(function () {
            // timmer calling start
            var currentTime = new Date();
            currentTime.setMinutes(currentTime.getMinutes() + {!! isset($exam->xm_duration) ? $exam->xm_duration : 1 !!}); //set custom time instead 60


            $('.flipTimer').flipTimer({
                direction: 'down',
                date: currentTime,
                callback: function () {
                    $('body .action-button.finish').remove();
                    $('#quizForm').submit();
                },
            });
            // timmer calling end

            var current_fs, next_fs,  previous_fs, previous_previous_fs; //fieldsets
            var opacity;

            $(".next").on('click',function () {

                current_fs = $(this).parent().parent();
                next_fs = $(this).parent().parent().next();
                var next_next_fs = next_fs.next();
                // console.log(next_next_fs);
                if (next_next_fs.length == 0)
                {
                    $('.next').hide();
                }
                if (next_fs.length == 1)
                {
                    next_fs.show();

                    current_fs.animate({opacity: 0}, {
                        step: function (now) {
                            opacity = 1 - now;
                            current_fs.css({
                                'display': 'none',
                                'position': 'relative'
                            });
                            next_fs.css({'opacity': opacity});
                        },
                        duration: 600
                    });
                    $('.previous').show();
                }


                // $('.checkAns').css('display', 'none');
                // $('#description').css('display','none');
                // $('.explanation').css('display','none');
            });

            $(".previous").on('click',function () {

                current_fs = $(this).parent().parent();
                previous_fs = $(this).parent().parent().prev();
                previous_previous_fs = previous_fs.prev().prev();
                previous_fs.show();
                // $('.checkAns').css('display', 'none');
                // $('#description').css('display','none');
                // $('.explanation').css('display','none');
                console.log(previous_previous_fs);
                current_fs.animate({opacity: 0}, {
                    step: function (now) {
                        opacity = 1 - now;
                        current_fs.css({
                            'display': 'none',
                            'position': 'relative'
                        });
                        previous_fs.css({'opacity': opacity});
                    },
                    duration: 600
                });
                $('.next').show();
                if(previous_previous_fs.length == 0)
                {
                    $('.previous').hide();
                }
            });
{{--            let baseurl = {!! json_encode(url('/')) !!}+'/';--}}
            $('body').on('click', '.action-button.finish', function (e) {
                e.preventDefault();
                $('#finishModal').modal('show');
            });

            $('body').on('click', '#SubmitResult', function (e) {
                e.preventDefault();
                $('#quizForm').submit(); /*xm result show 2-1-22*/
                // window.location.href = baseurl+'user/simulator';
            });
        });
    </script>
    {{--    sweet alert 2--}}
    {{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.2/sweetalert2.min.css" integrity="sha512-rogivVAav89vN+wNObUwbrX9xIA8SxJBWMFu7jsHNlvo+fGevr0vACvMN+9Cog3LAQVFPlQPWEOYn8iGjBA71w==" crossorigin="anonymous" referrerpolicy="no-referrer" />--}}
    {{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.2/sweetalert2.min.js" integrity="sha512-2sjxi4MoP9Gn7QE0NhJdxOFVMK/qYsZO6JnO6pngGvck8p5UPwFX2LV5AsAMOQYgvbzMmki6sIqJ90YO3STAnA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>--}}
{{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.all.min.js"></script>--}}
    {{--    toaster js--}}
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />--}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>--}}
    <script>
{{--        let baseurl = {!! json_encode(url('/')) !!}+'/';--}}
        // $('.ans').on('click', function (){
        //     $('.checkAns').css('display', 'block');
        // });

        // function checkQueAns(questionId)
        // {
        //     event.preventDefault();
        //     // $questionId = $('.ans').attr('question-id');
        //     $.ajax({
        //         url: baseurl+'user/get-ans/'+questionId,
        //         method: 'GET',
        //         dataType: 'JSON',
        //         success: function (data){
        //             console.log(data);
        //             var variable = data.question.description;
        //             $('.explanation').css('display','block');
        //             // $('.desPrint').empty().append(isset(data.question.description) ? data.question.description : 'No Explanation Available.');
        //             // $('#description').empty().html((typeof(variable) != "undefined" && variable !== null) ? data.description : 'No Explanation Available.');
        //             if (typeof(variable) != "undefined" && variable !== null)
        //             {
        //                 $('.desPrint').empty().html(data.question.description);
        //             } else {
        //                 $('.desPrint').empty().html('No Explanation Available.');
        //             }
        //
        //             // toaster js
        //             // toastr.success(data.title, 'Answer is :', {timeOut: 5000});
        //             // sweet alert 2
        //             var ansId   = $('#ansId').val();
        //             if (data.answer.id == ansId)
        //             {
        //                 Swal.fire({
        //                     title: "This Question's answer is correct.",
        //                     icon: 'warning',
        //                 })
        //             } else {
        //                 Swal.fire({
        //                     icon: 'error',
        //                     title: "This Question's answer is wrong.",
        //                     text: 'Try again!',
        //                 })
        //             }
        //
        //         },
        //         error: function (){
        //             Swal.fire({
        //                 icon: 'error',
        //                 title: 'Oops...',
        //                 text: 'Something went wrong!',
        //             })
        //         }
        //     });
        // }
        // $('.checkAns').on('click', function (){
        //
        // });
        // function showDescription(question_id)
        // {
        //     $('#desToggle'+question_id).toggle(500);
        //
        // }
        //
        // function checkAns(ans)
        // {
        //     $('#ansId').val(ans);
        // }

        // $(document).on('click', '.answer-label', function () {
        //     $(this).each(function () {
        //         $(this).css('background', 'white');
        //         if ($('#'+$(this).attr('for')).is(':checked'))
        //         {
        //             $(this).css({
        //                 background: '#01a3a4',
        //             });
        //         }
        //     });
        //
        // })

        function isset(iVal){
            return (iVal!=="" && iVal!=null && iVal!==undefined && typeof(iVal) != "undefined") ? 1 : 0;
        }

    </script>
@endpush
