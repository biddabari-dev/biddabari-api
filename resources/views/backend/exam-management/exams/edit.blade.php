<form id="courseSectionForm" action="{{ route('exams.update', $exam->id) }}" method="post" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="">Update Exams</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
    </div>
    <div class="modal-body">
        <div class="card card-body">
            <div class="row">
                @csrf
                @method('put')
                <div class="col-sm-4">
                    <label for="">Title</label>
                    <input type="text" class="form-control" value="{{ $exam->title }}" name="title" placeholder="Title" />
                </div>
                <div class="col-sm-4 select2-div">
                    <label for="">Exam Category</label>
                    <select name="exam_category_id" id="" class="form-control select2" data-placeholder="Select Question Type">
                        <option value=""></option>
                        @foreach($examCategories as $examCategory)
                            <option value="{{ $examCategory->id }}" {{ $exam->exam_category_id == $examCategory->id ? 'selected' : '' }}>{{ $examCategory->name }}</option>
                            @if(isset($examCategory->examCategories))
                                @include('backend.exam-management.exams.include-cat-option', ['child' => 1, 'examCategory' => $examCategory])
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-4 select2-div d-none">
                    <label for="">Exam Type</label>
                    <select name="xm_type" id="examType" class="form-control select2" data-placeholder="Select Question Type">
                        <option value=""></option>
                        <option value="MCQ" {{ $exam->xm_type == 'MCQ' ? 'selected' : '' }}>MCQ</option>
                        <option value="Written" {{ $exam->xm_type == 'Written' ? 'selected' : '' }}>Written</option>
                    </select>
                </div>
                <div class="col-sm-4">
                    <label for="">Exam Price</label>
                    <input type="text" class="form-control" name="price" value="{{ $exam->price }}" placeholder="Exam Price" />
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-sm-4">
                    <label for="">Xm Start Date Time</label>
                    <input type="text" id="xmDate1" class="form-control" data-dtp="dtp_Nufud" name="xm_start_time" value="{{ $exam->xm_start_time }}" placeholder="Exam Date" />
                </div>
                <div class="col-sm-4">
                    <label for="">Xm End Date Time</label>
                    <input type="text" id="xmStartTime1" class="form-control" data-dtp="dtp_Nufud" name="xm_end_time" value="{{ $exam->xm_end_time }}" placeholder="Start Time" />
                </div>
                <div class="col-sm-4">
                    <label for="">Subscription Duration (in Days)</label>
                    <input type="Number" class="form-control" name="xm_subscription_duration" value="{{ $exam->xm_subscription_duration }}" placeholder="Exam Subscription Duration (in Days)" />
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-sm-4">
                    <label for="">Exam Duration</label>
                    <input type="number" class="form-control" name="xm_duration" value="{{ $exam->xm_duration }}" placeholder="Exam Duration in Minutes" />
                </div>
                <div class="col-sm-4">
                    <label for="">Total Mark</label>
                    <input type="number" class="form-control" name="total_mark" placeholder="Total Mark" value="{{ $exam->total_mark }}" />
                </div>
                <div class="col-sm-4">
                    <label for="">Per Question Mark</label>
                    <input type="number" class="form-control" name="per_question_mark" value="{{ $exam->per_question_mark }}" placeholder="Per Question Mark" />
                </div>
                <div class="col-sm-4">
                    <label for="">Negative Mark</label>
                    <input type="text" class="form-control" name="negative_mark" value="{{ $exam->negative_mark }}" placeholder="Negative Mark" />
                </div>
                <div class="col-sm-4">
                    <label for="">Exam Pass Mark</label>
                    <input type="number" class="form-control" name="xm_pass_mark" value="{{ $exam->xm_pass_mark }}" placeholder="Exam Pass Mark" />
                </div>
                <div class="col-sm-4 select2-div d-none">
                    <label for="">Subject Name</label>
                    <select name="subject_name" class="form-control select2" id="" data-placeholder="Select a Subject">
                        <option value="bangla" {{ $exam->subject_name == 'bangla' ? 'selected' : '' }}>Bangla</option>
                        <option value="english" {{ $exam->subject_name == 'english' ? 'selected' : '' }}>English</option>
                    </select>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-sm-4">
                    <label for="">Is Paid</label> <br>
                    <div class="material-switch">
                        <input id="someSwitchOptionWarningq" name="is_paid" type="checkbox" {{ $exam->is_paid == 1 ? 'checked' : '' }} />
                        <label for="someSwitchOptionWarningq" class="label-info"></label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <label for="">Is Featured</label> <br>
                    <div class="material-switch">
                        <input id="someSwitchOptionWarningxq" name="is_featured" type="checkbox" {{ $exam->is_featured == 1 ? 'checked' : '' }} />
                        <label for="someSwitchOptionWarningxq" class="label-info"></label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <label for="">Status</label> <br>
                    <div class="material-switch">
                        <input id="someSwitchOptionInfoq" name="status" type="checkbox" {{ $exam->status == 1 ? 'checked' : '' }} />
                        <label for="someSwitchOptionInfoq" class="label-info"></label>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-sm-4">
                    <label for="">Show Mark Result</label> <br>
                    <div class="material-switch">
                        <input id="someSwitchOptionInfox" name="mark_base_result" type="checkbox" {{ $exam->mark_base_result == 1 ? 'checked' : '' }} />
                        <label for="someSwitchOptionInfox" class="label-info"></label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <label for="">Xm Banner</label>
                    <input type="file" class="form-control" id="xmImage" name="image" />
                </div>
                <div class="col-sm-4">
                    <img id="imagePreview" src="{{ $exam->image }}" style="height: 150px" />
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary " value="save">Save</button>
    </div>
</form>
