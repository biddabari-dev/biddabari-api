@extends('backend.master')

@section('title', 'Question Store')

@section('body')
    <div class="row py-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
{{--                    {{ $questionTopic }}--}}
                    <h4 class="float-start text-white">{{ $questionTopic->name }}, {{ $questionTopic->type == 'mcq' ? 'MCQ' : 'Written' }} - ({{ count($questionTopic->questionStores) }})</h4>
                    <a href="{{ route('export-questions', ['topic_id' => $_GET['topic_id'], 'type' => $_GET['q-type']]) }}" class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 m-r-80" title="Export File"><i class="fa-solid fa-arrow-circle-down"></i></a>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#questionStoreImportModal" class="rounded-circle text-white border-5 text-light f-s-22 btn ms-auto m-r-25" title="Import File"><i class="fa-solid fa-paperclip"></i></button>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#questionStoreModal" class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 ms-2 me-3"><i class="fa-solid fa-circle-plus"></i></button>
                </div>
                <div class="card-body">

{{--                    <table class="table table-borderless" id="file-datatable">--}}
{{--                        <thead>--}}
{{--                            <tr>--}}
{{--                                <th>#</th>--}}
{{--                                <th>Q. Type</th>--}}
{{--                                <th>Ques</th>--}}
{{--                                <th>Ques Des.</th>--}}
{{--                                <th>Ques Image</th>--}}
{{--                                <th>Ques Mark</th>--}}
{{--                                <th>Negative Mark</th>--}}
{{--                                <th>Mcq Ans</th>--}}
{{--                                <th>Written Ques. Ans</th>--}}
{{--                                <th>Written Ques. Ans Desc</th>--}}
{{--                                <th>Features</th>--}}
{{--                                <th>Action</th>--}}
{{--                            </tr>--}}
{{--                        </thead>--}}
{{--                        <tbody>--}}
{{--                            @foreach($questions as $question)--}}
{{--                                <tr>--}}
{{--                                    <td>{{ $loop->iteration }}</td>--}}
{{--                                    <td>{{ $question->question_type }}</td>--}}
{{--                                    <td>{!! $question->question !!}</td>--}}
{{--                                    <td>{!! str()->words($question->question_description, 10) !!}</td>--}}
{{--                                    <td>--}}
{{--                                        <img src="{{ asset($question->question_image) }}" alt="" style="height: 60px">--}}
{{--                                    </td>--}}
{{--                                    <td>{{ $question->question_mark }}</td>--}}
{{--                                    <td>{{ $question->negative_mark }}</td>--}}
{{--                                    <td>--}}
{{--                                        @if(!empty($question->questionOptions))--}}
{{--                                            @foreach($question->questionOptions as $questionOption)--}}
{{--                                                @if($questionOption->is_correct == 1) {{ $questionOption->option_title }} @endif--}}
{{--                                            @endforeach--}}
{{--                                        @endif--}}
{{--                                    </td>--}}
{{--                                    <td>{!! str()->words($question->written_que_ans, 15) !!}</td>--}}
{{--                                    <td>{!! str()->words($question->written_que_ans_description, 10) !!}</td>--}}
{{--                                    <td>--}}
{{--                                        <span class="badge badge-sm bg-primary">{{ $question->has_all_wrong_ans == 1 ? 'All Wrong' : '' }}</span>--}}
{{--                                        <span class="badge badge-sm bg-primary">{{ $question->status == 1 ? 'Published' : 'Unpublished' }}</span>--}}
{{--                                    </td>--}}
{{--                                    <td class="">--}}
{{--                                        <a href="" class="btn btn-sm btn-primary mt-1" data-topic-id="{{ $question->id }}"><i class="fa-solid fa-eye"></i></a>--}}
{{--                                        <br>--}}
{{--                                        <a href="{{ route('question-stores.edit', $question->id) }}" data-topic-id="{{ $question->id }}" class="btn btn-sm btn-warning topic-edit-btn mt-1">--}}
{{--                                            <i class="fa-solid fa-edit"></i>--}}
{{--                                        </a>--}}

{{--                                        <form action="{{ route('question-stores.destroy', $question->id) }}" method="post" onsubmit="return confirm('Are you sure to delete this? Once deleted, It can not be undone.')">--}}
{{--                                            @csrf--}}
{{--                                            @method('delete')--}}
{{--                                            <button type="submit" class="btn btn-sm btn-danger mt-1">--}}
{{--                                                <i class="fa-solid fa-trash"></i>--}}
{{--                                            </button>--}}
{{--                                        </form>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
{{--                        </tbody>--}}
{{--                    </table>--}}
                    <div class="mcq" id="mcqDiv">
                        <div class="row">
                            @if(!empty($questionTopic->questionStores))
                                @forelse($questionTopic->questionStores as $question)
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="me-auto">
                                                    <span class="float-start">{{ $loop->iteration }}. &nbsp; </span>
                                                    <span class="float-start">{!! $question->question !!}</span>
                                                    @if(isset($question->question_image))
                                                        <br>
                                                        <div class="float-start">
                                                            @if($question->question_file_type == 'pdf' && $_GET['q-type'] == 'written')
                                                                <span><a href="{{ asset($question->question_image) }}" download="" class="nav-link text-warning">PDF File</a></span>
                                                            @else
                                                                <img src="{{ asset($question->question_image) }}" alt="" class="img-fluid" style="max-height: 60px" />
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ms-auto" style="width: 50px">
                                                    <a href="" class="btn btn-success btn-sm topic-edit-btn" data-topic-id="{{ $question->id }}"><i class="fas fa-edit"></i></a>
                                                    <form action="{{ route('question-stores.destroy', $question->id) }}" method="post" >
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-danger m-t-1 btn-sm data-delete-form" data-topic-id="{{ $question->id }}"><i class="fas fa-trash"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                            @if(!empty($question->questionOptions) && count($question->questionOptions) > 0)
                                                    <div class="card-body">
                                                        @if(isset($question->question_option_image))
                                                            <div>
                                                                <img src="{{ asset($question->question_option_image) }}" alt="" class="img-fluid" style="max-height: 60px" />
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <ol type="A">
                                                                @foreach($question->questionOptionsAscOrder as $questionOption)
                                                                    <li class="{{ $questionOption->is_correct == 1 ? 'text-success' : '' }}"><p class="{{ $questionOption->is_correct == 1 ? 'fw-bold' : '' }}">{{ $questionOption->option_title }}</p></li>
                                                                @endforeach
                                                            </ol>
                                                        </div>
                                                        @if(isset($question->mcq_ans_description))
                                                            <div>
                                                                {!! $question->mcq_ans_description !!}
                                                            </div>
                                                        @endif
                                                    </div>

                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-md-12">No Questions Available</div>
                                @endforelse
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-div" id="questionStoreModal" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form action="{{ route('question-stores.store', ['topic_id' => $_GET['topic_id'],'q-type' => $_GET['q-type']]) }}" method="post" enctype="multipart/form-data" id="questionStoreForm">
                    <div class="modal-header">
                        <h5 class="modal-title">Create Question</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="card mt-4">
                            <div class="card-header">
                                <h2 class="text-center float-start">Question Form</h2>
{{--                                <button type="button" class="btn btn-warning position-absolute end-0 me-4"><i class="fa-solid fa-plus"></i></button>--}}
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @csrf
                                    <input type="hidden" name="question_topics[]" value="{{ $_GET['topic_id'] }}">
                                    <input type="hidden" name="question_type" id="questionType" value="{{ $_GET['q-type'] == 'mcq' ? 'MCQ' : 'Written' }}">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="totalQuestions">Generate Total Form</label>
                                                <div class="input-group">
                                                    <input type="number" id="totalForm" class="form-control" placeholder="Total Question Append" />
                                                    <span class="input-group-text full-form-append-btn" style="cursor: pointer"><i class="fa-solid fa-check"></i></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6"></div>
                                            <div class="col-md-3">
                                                <a href="https://demo.wiris.com/mathtype/en/developers.php#mathml-latex" class="btn btn-sm btn-primary mt-4" target="_blank">Generate Equation</a>
                                            </div>
                                        </div>
                                    </div>
{{--                                    <div class="col-md-3 select2-div">--}}
{{--                                        <label for="questionType" class="">Question Type</label>--}}
{{--                                        <select name="question_type" id="questionType" class="form-control select2" data-placeholder="Select a Question Type">--}}
{{--                                            <option value=""></option>--}}
{{--                                            <option value="MCQ">MCQ</option>--}}
{{--                                            <option value="Written">Written</option>--}}
{{--                                        </select>--}}
{{--                                        @csrf--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-6 select2-div">--}}
{{--                                        <label for="questionTopic" class="">Question Topic</label>--}}

{{--                                    </div>--}}

                                    <div class="col-md-12 mt-3">
                                        <label for="summernote">Question</label>
                                        <textarea name="question[0][question]" id="summernote" required class="form-control" placeholder="Question " cols="30" rows="10"></textarea>
                                        <span class="text-danger" id="name">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <label for="questionImage">Que Image</label>
                                        <input type="file" class="form-control" id="questionImage" name="question[0][question_image]" {{--accept="application/pdf,image/*"--}} accept="image/*" />
                                    </div>
{{--                                    <div class="col-md-6 mt-3">--}}
{{--                                        <label for="queVidDes">Que Video Description</label>--}}
{{--                                        <input type="text" class="form-control" id="queVidDes" name="question[0][question_video_link]" placeholder="https://youtu.be/xxxxxxxxx" />--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-6 mt-3">--}}
{{--                                        <label for="markPerQue">Mark Per Question</label>--}}
{{--                                        <input type="text" class="form-control" id="markPerQue" name="question[0][question_mark]" value="1" placeholder="Mark Per Question" />--}}
{{--                                    </div>--}}
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="currentAppendNumber" value="0" />

                        <div class="card mcq-ans-sec d-none" data-key-id="0" id="mcqAnsSection">
                            <div class="card-header">
                                <h3 class="float-start">MCQ Options</h3>
                                <button type="button" data-key-id="0" class="btn append-div position-absolute end-0 me-4 btn-outline-success "><i class="fa-solid fa-circle-plus"></i></button>
                            </div>
                            <div class="card-body" >
                                <div class="row mt-2" id="mcqOptionSection0">
                                    <div class="col-md-6 mt-1">
                                        <label for="optionTitle">Option Title</label>
                                        <div class="input-group">
                                            <input type="text" name="question[0][answer][0][option_title]" id="optionTitle" class="form-control" placeholder="Option" />
                                            {{--                                        <button type="button" class="btn btn-danger input-group-text delete-option-btn"><i class="fa-solid fa-trash"></i></button>--}}
                                        </div>
                                        <label for="" class="mt-2">Is Correct?</label>
                                        <div class="material-switch">
                                            <input id="someSwitchOptionInfo" name="question[0][answer][0][is_correct]" type="checkbox" data-array-index="0" />
                                            <label for="someSwitchOptionInfo" class="label-info"></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <label for="optionTitle">Option Title</label>
                                        <div class="input-group">
                                            <input type="text" name="question[0][answer][1][option_title]" id="optionTitle" class="form-control" placeholder="Option" />
                                            {{--                                        <button type="button" class="btn btn-danger input-group-text delete-option-btn"><i class="fa-solid fa-trash"></i></button>--}}
                                        </div>
                                        <label for="" class="mt-2">Is Correct?</label>
                                        <div class="material-switch">
                                            <input id="someSwitchOptionInfo0" name="question[0][answer][1][is_correct]" type="checkbox" data-array-index="0" />
                                            <label for="someSwitchOptionInfo0" class="label-info"></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <label for="optionTitle">Option Title</label>
                                        <div class="input-group">
                                            <input type="text" name="question[0][answer][2][option_title]" id="optionTitle" class="form-control" placeholder="Option" />
                                            {{--                                        <button type="button" class="btn btn-danger input-group-text delete-option-btn"><i class="fa-solid fa-trash"></i></button>--}}
                                        </div>
                                        <label for="" class="mt-2">Is Correct?</label>
                                        <div class="material-switch">
                                            <input id="someSwitchOptionInfo01" name="question[0][answer][2][is_correct]" type="checkbox" data-array-index="0" />
                                            <label for="someSwitchOptionInfo01" class="label-info"></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <label for="optionTitle">Option Title</label>
                                        <div class="input-group">
                                            <input type="text" name="question[0][answer][3][option_title]" id="optionTitle" class="form-control" placeholder="Option" />
                                            {{--                                        <button type="button" class="btn btn-danger input-group-text delete-option-btn"><i class="fa-solid fa-trash"></i></button>--}}
                                        </div>
                                        <label for="" class="mt-2">Is Correct?</label>
                                        <div class="material-switch">
                                            <input id="someSwitchOptionInfo02" name="question[0][answer][3][is_correct]" type="checkbox" data-array-index="0" />
                                            <label for="someSwitchOptionInfo02" class="label-info"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0 border-top-0">
                                <div class="row">
{{--                                    <div class="col-md-6">--}}
{{--                                        <label for="negativeMark">Negative Mark</label>--}}
{{--                                        <input type="text" class="form-control" id="negativeMark" name="question[0][negative_mark]" value="0" placeholder="Mark Per Question" />--}}
{{--                                    </div>--}}
                                    <div class="col-md-6">
                                        <label for="wrongAns">All Wrong Answers?</label>
                                        <div class="material-switch">
                                            <input id="someSwitchOptionWarning" name="question[0][has_all_wrong_ans]" type="checkbox" >
                                            <label for="someSwitchOptionWarning" class="label-warning"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body pt-0 border-top-0">
                                <div class="row mt-3 question-option-img-div">
                                    <div class="col-md-6">
                                        <label for="questionOptionsImage">Question Option Image</label>
                                        <input type="file" class="form-control show-option-image" data-loop="0" id="questionOptionsImage" name="question[0][question_option_image]" accept="image/*" />
                                    </div>
                                    <div class="col-md-6">
                                        <img src="" id="showOptionImage0" style="height: 60px;" alt="">
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label for="summernote1">Answer Description</label>
                                        <textarea name="question[0][mcq_ans_description]" id="summernote1" placeholder="Answer Description" class="form-control" cols="30" rows="10"></textarea>
                                    </div>
                                </div>
                            </div>
{{--                            <div class="card-body pt-0 border-top-0">--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-md-12">--}}
{{--                                        <label for="summernoteMcq">Answer Description</label>--}}
{{--                                        <textarea name="question[0][mcq_ans_description]" class="" id="summernoteMcq" cols="30" rows="10"></textarea>--}}

{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </div>
{{--                        <div class="card written-ans-sec d-none" data-key-id="0" id="writtenAnsSection">--}}
{{--                            <div class="card-header">--}}
{{--                                <h3>Written Question Answer</h3>--}}
{{--                            </div>--}}
{{--                            <div class="card-body">--}}
{{--                                <div class="row mt-2" >--}}
{{--                                    <div class="col-md-12 mt-3">--}}
{{--                                        <label for="">Written Question Answer</label>--}}
{{--                                        <textarea name="question[0][written_que_ans]" id="summernote2" class="form-control" cols="30" rows="5"></textarea>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-12 mt-3">--}}
{{--                                        <label for="">Written Question Answer Description</label>--}}
{{--                                        <textarea name="question[0][written_que_ans_description]" id="summernote3" class="form-control" cols="30" rows="5"></textarea>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-4 mt-3">--}}
{{--                                        <label for="">Written Question Answer Upload</label>--}}
{{--                                        <input type="file" name="question[0][written_que_file]" class="form-control" />--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        <div id="fullFormAppendDiv"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary submit-btn" value="save">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade modal-div" id="questionStoreEditModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form action="" method="post" enctype="multipart/form-data" id="questionUpdateForm">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Question</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        @method('put')
                        <div id="editModalBody"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary submit-btn" value="save">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade modal-div" id="questionStoreImportModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <form action="{{ route('question-import', ['type' => ($_GET['q-type'] == 'mcq' ? 'MCQ' : 'Written'), 'topic_id' => $_GET['topic_id']]) }}" method="post" enctype="multipart/form-data" id="">
                    <div class="modal-header">
                        <h5 class="modal-title">Import Question</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div>
                            <a href="{{ $_GET['q-type'] == 'mcq' ? asset('backend/import-file-samples/mcq-question-import-sample.xlsx') : asset('backend/import-file-samples/written-question-import-sample.xlsx') }}" download="" class="btn btn-success">Download Sample</a>
                        </div>
                        <div class="mt-3">
                            <label for="">Input File</label>
                            <input type="file" name="import_file" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary submit-btn" value="save">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <!-- DataTables -->
{{--    <link href="{{ asset('/') }}backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />--}}
{{--    <link href="{{ asset('/') }}backend/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />--}}
    <style>
        input[switch]+label {
            margin-bottom: 0px;
        }
        #summernote {
            height: 30px!important;
        }
    </style>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
@endpush

@push('script')
    @include('backend.includes.assets.plugin-files.datatable')
    @include('backend.includes.assets.plugin-files.editor')
    <!-- Register plugins onload start -->
    <script>
        $(function () {
            $('#summernote1').summernote({minHeight:150,inheritPlaceholder: true});
            $('#summernote2').summernote({minHeight:150,inheritPlaceholder: true});
            $('#summernote3').summernote({minHeight:150,inheritPlaceholder: true});
            $('#summernoteMcq').summernote({minHeight:150,inheritPlaceholder: true});
        })
    </script>
    <!-- Register plugins onload end -->


    <!-- append full form start -->
    <script>
        function randNumberFun() {
            return Math.floor((Math.random() * 200) + 50);
        }
        var serial = 1;
        var ansOption = 4;
        // var randNumber = Math.floor((Math.random() * 200) + 50);
        var randNumber = randNumberFun();
        var firstSummernote = 11;
        var secondSummernote = 22;
        var thirdSummernote = 33;
        var fourthSummernote = 44;
        var fifthSummerNote = 55;
        $(document).on('click', '.full-form-append-btn', function () {
            var questionType = $('#questionType').val();
            if (questionType == '')
            {
                toastr.error('Please select a Question Type first.')
                return false;
            }
            var totalAppendForm = $('#totalForm').val();
            if (totalAppendForm < 0 || totalAppendForm == '')
            {
                toastr.error('Please Input Total Question Number.')
                return false;
            }

            for (var b = 1; b <= totalAppendForm; b++)
            {
                var randNumber = randNumberFun();
                var div = '';
                div += '<div class="question-wrapper">\n' +
                    '                        <div class="card mt-4">\n' +
                    '                            <div class="card-header">\n' +
                    '                                <h2 class="text-center float-start">New Question</h2>\n' +
                    '                                <button type="button" class="btn btn-danger btn-sm rounded-0 position-absolute me-4 end-0 delete-full-append-btn"><i class="fa-solid fa-trash"></i></button>\n' +
                    '                            </div>\n' +
                    '                            <div class="card-body">\n' +
                    '                                <div class="row">\n' +
                    '                                    <div class="col-md-12 mt-3">\n' +
                    '                                        <label for="summernote">Question</label>\n' +
                    '                                        <textarea name="question['+serial+'][question]" id="summernote'+firstSummernote+'" class="form-control" placeholder="Question " cols="30" rows="10"></textarea>\n' +
                    '                                    </div>\n' +
                    // '                                    <div class="col-md-12 mt-3">\n' +
                    // '                                        <label for="summernote1">Question Description</label>\n' +
                    // '                                        <textarea name="question['+serial+'][question_description]" id="summernote'+secondSummernote+'" placeholder="Question Description" class="form-control" cols="30" rows="10"></textarea>\n' +
                    // '                                    </div>\n' +
                    '                                    <div class="col-md-6 mt-3">\n' +
                    '                                        <label for="questionImage">Que Image</label>\n' +
                    '                                        <input type="file" class="form-control" id="questionImage" name="question['+serial+'][question_image]" accept="image/*" />\n' +
                    '                                    </div>\n' +
                    // '                                    <div class="col-md-6 mt-3">\n' +
                    // '                                        <label for="queVidDes">Que Video Description</label>\n' +
                    // '                                        <input type="text" class="form-control" id="queVidDes" name="question['+serial+'][question_video_link]" placeholder="Question Video Description" />\n' +
                    // '                                    </div>\n' +
                    // '                                    <div class="col-md-6 mt-3">\n' +
                    // '                                        <label for="markPerQue">Mark Per Question</label>\n' +
                    // '                                        <input type="text" class="form-control" id="markPerQue" name="question['+serial+'][question_mark]" value="1" placeholder="Mark Per Question" />\n' +
                    // '                                    </div>\n' +
                    '                                </div>\n' +
                    '                            </div>';
                if (questionType == 'MCQ')
                {
                    div += '                            <div class="mcq-ans-sec" data-key-id="'+serial+'" id="mcqAnsSection">';
                } else {
                    div += '                            <div class="mcq-ans-sec d-none" data-key-id="'+serial+'" id="mcqAnsSection">';
                }
                div += '                                <div class="card-header">\n' +
                    '                                    <h3 class="float-start">MCQ Options</h3>\n' +
                    '                                    <button type="button" data-key-id="'+serial+'" class="btn append-div position-absolute end-0 me-4 btn-outline-success "><i class="fa-solid fa-circle-plus"></i></button>\n' +
                    '                                </div>\n' +
                    '                                <div class="card-body" id="mcqOptionSection'+serial+'">\n';
                div += '                                    <div class="row">\n';
                    for(var tt = 0; tt < 4; tt++) {
                        div += '                                 <div class="col-md-6 mt-1">\n' +
                        '                                            <label for="">Option Title</label>\n' +
                        '                                            <div class="input-group">\n' +
                        '                                                <input type="text" name="question[' + serial + '][answer][' + ansOption + '][option_title]" class="form-control" placeholder="Option" />\n' +
                        '                                            </div>\n' +
                        '                                            <label for="" class="mt-2">Is Correct?</label>\n' +
                        '                                            <div class="material-switch">\n' +
                        '                                                <input id="someSwitchOptionInfo' + (++randNumber) + '" name="question[' + serial + '][answer][' + (ansOption++) + '][is_correct]" type="checkbox" >\n' +
                        '                                                <label for="someSwitchOptionInfo' + (randNumber) + '" class="label-info"></label>\n' +
                        '                                            </div>\n' +
                        '                                        </div>\n';
                    }
                div += '                                </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="card-body pt-0 border-top-0">\n' +
                    '                                    <div class="row">\n' +
                    // '                                        <div class="col-md-6">\n' +
                    // '                                            <label for="negativeMark">Negative Mark</label>\n' +
                    // '                                            <input type="text" class="form-control" id="negativeMark" name="question['+serial+'][negative_mark]" value="0" placeholder="Mark Per Question" />\n' +
                    // '                                        </div>\n' +
                    '                                        <div class="col-md-6">\n' +
                    '                                            <label for="wrongAns">All Wrong Answers?</label>\n' +
                    '                                            <div class="material-switch">\n' +
                    '                                                <input id="someSwitchOptionWarning'+randNumber+'" name="question['+serial+'][has_all_wrong_ans]" type="checkbox" >\n' +
                    '                                                <label for="someSwitchOptionWarning'+randNumber+'" class="label-warning"></label>\n' +
                    '                                            </div>\n' +
                    '                                        </div>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '<div class="card-body pt-0 border-top-0">\n' +
                    '<div class="row question-option-img-div">\n' +
                    '                                    <div class="col-md-6">\n' +
                    '                                        <label for="questionOptionsImage">Question Option Image</label>\n' +
                    '                                        <input type="file" class="form-control show-option-image" data-loop="'+serial+'" id="questionOptionsImage" name="question['+serial+'][question_option_image]" accept="image/*" />\n' +
                    '                                    </div>\n' +
                    '                                    <div class="col-md-6">\n' +
                    '                                        <img src="" id="showOptionImage'+serial+'" style="height: 60px;" alt="">\n' +
                    '                                    </div>'+
                    // '                                </div>' +
                    // '                                <div class="row">\n' +
                    '                                    <div class="col-md-12">\n' +
                    '                                        <label for="wrongAns">Answer Description</label>\n' +
                    '                                        <textarea name="question['+serial+'][mcq_ans_description]" placeholder="Answer Description" class="form-control" id="summernoteMcq'+fifthSummerNote+'" cols="30" rows="10"></textarea>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                            </div>\n' +
                    '                            </div>';
                // if (questionType == 'Written')
                // {
                //     div += '                            <div class="written-ans-sec" data-key-id="'+serial+'" id="writtenAnsSection">';
                // } else {
                //     div += '                            <div class="written-ans-sec d-none" data-key-id="'+serial+'" id="writtenAnsSection">';
                // }
                // div += '                                <div class="card-header">\n' +
                //     '                                    <h3>Written Question Answer</h3>\n' +
                //     '                                </div>\n' +
                    // '                                <div class="card-body">\n' +
                    // '                                    <div class="row mt-2" >\n' +
                    // '                                        <div class="col-md-12 mt-3">\n' +
                    // '                                            <label for="">Written Question Answer</label>\n' +
                    // '                                            <textarea name="question['+serial+'][written_que_ans]" id="summernote'+thirdSummernote+'" class="form-control" cols="30" rows="5"></textarea>\n' +
                    // '                                        </div>\n' +
                    // '                                        <div class="col-md-12 mt-3">\n' +
                    // '                                            <label for="">Written Question Answer Description</label>\n' +
                    // '                                            <textarea name="question['+serial+'][written_que_ans_description]" id="summernote'+fourthSummernote+'" class="form-control" cols="30" rows="5"></textarea>\n' +
                    // '                                        </div>\n' +
                    // '                                        <div class="col-md-4 mt-3">\n' +
                    // '                                            <label for="">Written Question Answer Upload</label>\n' +
                    // '                                            <input type="file" name="question['+serial+'][written_que_file]" class="form-control" />\n' +
                    // '                                        </div>\n' +
                    // '                                    </div>\n' +
                    // '                                </div>\n' +
                    // '                            </div>\n' +
                div +='                        </div>\n' +
                    '                    </div>';
                $('#fullFormAppendDiv').append(div);
                $('#currentAppendNumber').val(serial);
                $('#summernote'+firstSummernote).summernote({minHeight:150,inheritPlaceholder: true});
                $('#summernote'+secondSummernote).summernote({minHeight:150,inheritPlaceholder: true});
                $('#summernote'+thirdSummernote).summernote({minHeight:150,inheritPlaceholder: true});
                $('#summernote'+fourthSummernote).summernote({minHeight:150,inheritPlaceholder: true});
                $('#summernoteMcq'+fifthSummerNote).summernote({minHeight:150,inheritPlaceholder: true});
                serial++;
                firstSummernote++;
                secondSummernote++;
                thirdSummernote++;
                fourthSummernote++;
                fifthSummerNote++;
            }
            toastr.success('Question Form Created Successfully.');
        });
    </script>
    <!-- append full form end -->

    <!-- delete full form start -->
    <script>
        $(document).on('click', '.delete-full-append-btn', function () {
            event.preventDefault();
            $(this).closest('.question-wrapper').remove();
        })
    </script>
    <!-- delete full form end -->

    <!-- show hide chap start -->
    <script>
        // show hide mcq/written section
        $(function () {
            var questionOption = $('#questionType').val();
            if (questionOption == 'MCQ')
            {
                if ($('.mcq-ans-sec').hasClass('d-none'))
                {
                    $('.mcq-ans-sec').removeClass('d-none');
                }
                $('.written-ans-sec').addClass('d-none');
            } else if (questionOption == 'Written')
            {
                if ($('.written-ans-sec').hasClass('d-none'))
                {
                    $('.written-ans-sec').removeClass('d-none');
                }
                $('.mcq-ans-sec').addClass('d-none');
            }
        })
        $(document).on('change', '#questionType', function () {
            var questionOption = $(this).val();
            if (questionOption == 'MCQ')
            {
                if ($('.mcq-ans-sec').hasClass('d-none'))
                {
                    $('.mcq-ans-sec').removeClass('d-none');
                }
                $('.written-ans-sec').addClass('d-none');
            } else if (questionOption == 'Written')
            {
                if ($('.written-ans-sec').hasClass('d-none'))
                {
                    $('.written-ans-sec').removeClass('d-none');
                }
                $('.mcq-ans-sec').addClass('d-none');
            }
            $('#fullFormAppendDiv').empty();
        })
    </script>
    <!-- show hide chap End -->

    <!-- append delete start -->
    <script>
        var switchBtnId = 11;

        $(document).on('click', '.append-div', function () {
            var numberSerial = $(this).attr('data-key-id');
            var div = '';
            // div = '<div class="row mt-2">\n' +
            div = '                            <div class="col-md-6">\n' +
                '                                <label for="">Option Title</label>\n' +
                '                                <div class="input-group">\n' +
                '                                    <input type="text" name="question['+numberSerial+'][answer]['+ansOption+'][option_title]" class="form-control" placeholder="Option" />\n' +
                '                                    <button type="button" class="btn btn-danger input-group-text delete-option-btn"><i class="fa-solid fa-trash"></i></button>\n' +
                '                                </div>\n' +
                '                                <label for="" class="mt-2">Is Correct?</label>\n' +
                '                                <div class="material-switch">\n' +
                '                                    <input id="someSwitchOptionInfo'+switchBtnId+'" name="question['+numberSerial+'][answer]['+ansOption+'][is_correct]" type="checkbox" >\n' +
                '                                    <label for="someSwitchOptionInfo'+switchBtnId+'" class="label-info"></label>\n' +
                '                                </div>\n' +
                '                            </div>\n' ;
                // '                        </div>';

            $('#mcqOptionSection'+numberSerial).append(div);
            switchBtnId++;
            ansOption++;
        })
        var switchBtnIdx = 121;

        $(document).on('click', '.edit-append-div', function () {
            var numberSerial = $(this).attr('data-key-id');
            var div = '';
            // div = '<div class="row mt-2">\n' +
            div = '                            <div class="col-md-6">\n' +
                '                                <label for="">Option Title</label>\n' +
                '                                <div class="input-group">\n' +
                '                                    <input type="text" name="question['+numberSerial+'][answer]['+ansOption+'][option_title]" class="form-control" placeholder="Option" />\n' +
                '                                    <button type="button" class="btn btn-danger input-group-text delete-option-btn"><i class="fa-solid fa-trash"></i></button>\n' +
                '                                </div>\n' +
                '                                <label for="" class="mt-2">Is Correct?</label>\n' +
                '                                <div class="material-switch">\n' +
                '                                    <input id="someSwitchOptionInfo'+switchBtnIdx+'" name="question['+numberSerial+'][answer]['+ansOption+'][is_correct]" type="checkbox" >\n' +
                '                                    <label for="someSwitchOptionInfo'+switchBtnIdx+'" class="label-info"></label>\n' +
                '                                </div>\n' +
                '                            </div>\n' ;
                // '                        </div>';

            $('#editmcqOptionSection'+numberSerial).append(div);
            switchBtnIdx++;
            ansOption++;
        })

        $(document).on('click', '.delete-option-btn', function () {
            $(this).closest('.col-md-6').remove();
        })
    </script>
    <!-- append delete end -->

    <script>
        {{--    edit data--}}
        $(document).on('click', '.topic-edit-btn', function () {
            event.preventDefault();
            var categoryId = $(this).attr('data-topic-id');
            $.ajax({
                url: base_url+"question-stores/"+categoryId+"/edit",
                method: "GET",
                success: function (data) {
                    $('#editModalBody').empty().append(data);
                    $(".select2").select2({
                        minimumResultsForSearch: "",
                        width: "100%",
                    })
                    $('#questionUpdateForm').attr('action', base_url+'question-stores/'+categoryId);
                    $('#summernote111').summernote({minHeight:150,inheritPlaceholder: true});
                    $('#summernote222').summernote({minHeight:150,inheritPlaceholder: true});
                    $('#summernote333').summernote({minHeight:150,inheritPlaceholder: true});
                    $('#summernote444').summernote({minHeight:150,inheritPlaceholder: true});
                    $('#summernoteMcq555').summernote({minHeight:150,inheritPlaceholder: true});
                    $('#questionStoreEditModal').modal('show');
                }
            })
        })
    </script>
    <script>
        $(document).on('change', '.show-option-image', function () {
            var dataloop = $(this).attr('data-loop');
            var imgURL = URL.createObjectURL(event.target.files[0]);
            $('#showOptionImage'+dataloop).attr('src', imgURL).css({
                height: 60+'px',
                width: 60+'px',
                marginTop: '5px'
            });
        })
    </script>


@endpush
