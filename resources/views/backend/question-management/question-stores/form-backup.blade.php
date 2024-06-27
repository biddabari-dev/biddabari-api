<form action="" method="post" enctype="multipart/form-data">
    @csrf
    <div class="card mt-4">
        <div class="card-header">
            <h2 class="text-center float-start">Question Form</h2>
            <button type="button" class="btn btn-warning position-absolute end-0 me-4 full-form-append-btn"><i class="fa-solid fa-plus"></i></button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 select2-div">
                    <label for="" class="">Question Type</label>
                    <select name="question_type" id="questionType" class="form-control select2" data-placeholder="Select a Question Type">
                        <option value=""></option>
                        <option value="MCQ">MCQ</option>
                        <option value="Written">Written</option>
                    </select>
                </div>
                <div class="col-md-6 select2-div">
                    <label for="" class="">Question Topic</label>
                    <select name="question_topics[]" multiple class="form-control select2" data-placeholder="Select a Question Topics">
                        <option value=""></option>
                        @foreach($questionTopics as $questionTopic)
                            <option value="{{ $questionTopic->id }}">{{ $questionTopic->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12 mt-3">
                    <label for="">Question</label>
                    <textarea name="question" id="summernote" class="form-control" placeholder="Question " cols="30" rows="10"></textarea>
                </div>
                <div class="col-md-12 mt-3">
                    <label for="">Question Description</label>
                    <textarea name="question_description" id="summernote1" placeholder="Question Description" class="form-control" cols="30" rows="10"></textarea>
                </div>
                <div class="col-md-3 mt-3">
                    <label for="">Que Image</label>
                    <input type="file" class="form-control" name="question_image" accept="image/*" />
                </div>
                <div class="col-md-3 mt-3">
                    <label for="">Que Video Description</label>
                    <input type="text" class="form-control" name="question_video_link" placeholder="Question Video Description" />
                </div>
                <div class="col-md-3 mt-3">
                    <label for="">Mark Per Question</label>
                    <input type="text" class="form-control" name="question_mark" placeholder="Mark Per Question" />
                </div>
                <div class="col-md-3 mt-3">
                    <label for="">Negative Mark</label>
                    <input type="text" class="form-control" name="negative_mark" placeholder="Mark Per Question" />
                </div>
            </div>
        </div>
    </div>

    <div class="card d-none" id="mcqAnsSection">
        <div class="card-header">
            <h3 class="float-start">MCQ Options</h3>
            <button type="button" class="btn append-div position-absolute end-0 me-4 btn-outline-success "><i class="fa-solid fa-circle-plus"></i></button>
        </div>
        <div class="card-body" id="mcqOptionSection">
            <div class="row">
                <div class="col-md-12">
                    <label for="">Option Title</label>
                    <div class="input-group">
                        <input type="text" name="option_title[]" class="form-control" placeholder="Option" />
                        {{--                                    <button type="button" class="btn btn-danger input-group-text delete-option-btn"><i class="fa-solid fa-trash"></i></button>--}}
                    </div>
                    <label for="" class="mt-2">Is Correct?</label>
                    <div class="material-switch">
                        <input id="someSwitchOptionInfo" name="is_correct" type="checkbox" checked="">
                        <label for="someSwitchOptionInfo" class="label-info"></label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card d-none" id="writtenAnsSection">
        <div class="card-header">
            <h3>Written Question Answer</h3>
        </div>
        <div class="card-body">
            <div class="row mt-2" >
                <div class="col-md-12 mt-3">
                    <label for="">Written Question Answer</label>
                    <textarea name="written_que_ans" id="summernote2" class="form-control" cols="30" rows="5"></textarea>
                </div>
                <div class="col-md-12 mt-3">
                    <label for="">Written Question Answer Description</label>
                    <textarea name="written_que_ans_description" id="summernote3" class="form-control" cols="30" rows="5"></textarea>
                </div>
                <div class="col-md-4 mt-3">
                    <label for="">Written Question Answer Upload</label>
                    <input type="file" name="written_que_file" class="form-control" />
                </div>
            </div>
        </div>
    </div>

    <div id="fullFormAppend"></div>
</form>


















<div class="question-wrapper">
    <div class="card mt-4">
        <div class="card-header">
            <h2 class="text-center float-start">New Question</h2>
            <button type="button" class="btn btn-danger btn-sm rounded-0 position-absolute me-4 end-0 delete-full-append-btn"><i class="fa-solid fa-trash"></i></button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 mt-3">
                    <label for="summernote">Question</label>
                    <textarea name="question[0]" id="summernote" class="form-control" placeholder="Question " cols="30" rows="10"></textarea>
                </div>
                <div class="col-md-12 mt-3">
                    <label for="summernote1">Question Description</label>
                    <textarea name="question_description[0]" id="summernote1" placeholder="Question Description" class="form-control" cols="30" rows="10"></textarea>
                </div>
                <div class="col-md-6 mt-3">
                    <label for="questionImage">Que Image</label>
                    <input type="file" class="form-control" id="questionImage" name="question_image[0]" accept="image/*" />
                </div>
                <div class="col-md-6 mt-3">
                    <label for="queVidDes">Que Video Description</label>
                    <input type="text" class="form-control" id="queVidDes" name="question_video_link[0]" placeholder="Question Video Description" />
                </div>
                <div class="col-md-6 mt-3">
                    <label for="markPerQue">Mark Per Question</label>
                    <input type="text" class="form-control" id="markPerQue" name="question_mark[0]" value="1" placeholder="Mark Per Question" />
                </div>
            </div>
        </div>
        <div class=" " data-key-id="1" id="mcqAnsSection">
            <div class="card-header">
                <h3 class="float-start">MCQ Options</h3>
                <button type="button" class="btn append-div position-absolute end-0 me-4 btn-outline-success "><i class="fa-solid fa-circle-plus"></i></button>
            </div>
            <div class="card-body" id="mcqOptionSection">
                <div class="row">
                    <div class="col-md-12">
                        <label for="">Option Title</label>
                        <div class="input-group">
                            <input type="text" name="option_title[0][]" class="form-control" placeholder="Option" />
                            {{--                                        <button type="button" class="btn btn-danger input-group-text delete-option-btn"><i class="fa-solid fa-trash"></i></button>--}}
                        </div>
                        <label for="" class="mt-2">Is Correct?</label>
                        <div class="material-switch">
                            <input id="someSwitchOptionInfo" name="is_correct[0][]" type="checkbox" checked="">
                            <label for="someSwitchOptionInfo" class="label-info"></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0 border-top-0">
                <div class="row">
                    <div class="col-md-6">
                        <label for="negativeMark">Negative Mark</label>
                        <input type="text" class="form-control" id="negativeMark" name="negative_mark[0]" value="0" placeholder="Mark Per Question" />
                    </div>
                    <div class="col-md-6">
                        <label for="wrongAns">All Wrong Answers?</label>
                        <div class="material-switch">
                            <input id="someSwitchOptionWarning" name="has_all_wrong_ans[0]" type="checkbox" >
                            <label for="someSwitchOptionWarning" class="label-warning"></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="" data-key-id="1" id="writtenAnsSection">
            <div class="card-header">
                <h3>Written Question Answer</h3>
            </div>
            <div class="card-body">
                <div class="row mt-2" >
                    <div class="col-md-12 mt-3">
                        <label for="">Written Question Answer</label>
                        <textarea name="written_que_ans[0]" id="summernote2" class="form-control" cols="30" rows="5"></textarea>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="">Written Question Answer Description</label>
                        <textarea name="written_que_ans_description[0]" id="summernote3" class="form-control" cols="30" rows="5"></textarea>
                    </div>
                    <div class="col-md-4 mt-3">
                        <label for="">Written Question Answer Upload</label>
                        <input type="file" name="written_que_file[0]" class="form-control" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

