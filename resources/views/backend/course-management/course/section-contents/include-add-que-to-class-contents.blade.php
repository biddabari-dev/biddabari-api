<div class="row">
    <div class="col-md-6">
        <div class="card card-body">
            <h4>Title: <span id="sectionContentTitle">{{ $content->title }}</span></h4>
        </div>
    </div>
</div>
<form action="{{ route('assign-question-to-class-content') }}" method="post" id="" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="xm_type" value="exam">
    <input type="hidden" name="section_content_id" value="{{ $content->id }}">
    <div class="" id="">
        <div class="row mt-3">
            <div class="col-md-5 select2-div">
                <label for="">Question Topics</label>
                <input type="text" class="form-control" id="questionTopicInputField">
                <input type="hidden" class="form-control" id="questionTopic">
{{--                <select name="" id="questionTopic" multiple class="form-control select2" data-placeholder="Select a Question Type">--}}
{{--                    <option disabled >Select a Question Type</option>--}}
{{--                    @foreach($questionTopics as $questionTopic)--}}
{{--                        <option value="{{ $questionTopic->id }}">{{ $questionTopic->name }}</option>--}}
{{--                        @if(!empty($questionTopic))--}}
{{--                            @if(count($questionTopic->questionTopics) > 0)--}}
{{--                                @include('backend.course-management.course.section-contents.question-topic-loop', ['questionTopic' => $questionTopic, 'child' => 1])--}}
{{--                            @endif--}}
{{--                        @endif--}}
{{--                    @endforeach--}}
{{--                </select>--}}
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-primary mt-5 check-topics">Apply</button>
            </div>
            <div class="col-md-12" id="questionListDiv">
                <div class="card" id="queCard">

                </div>
            </div>
        </div>
    </div>
</form>

{{--@if(!empty($content->questionStores))--}}
{{--    <div class="card card-body">--}}
{{--        <h2 class="text-center">Assigned Questions</h2>--}}
{{--        <div class="row">--}}
{{--            @foreach($content->questionStores as $questionStore)--}}
{{--                <div class="col-md-6 mt-2 border  p-3 shadow" style="cursor: pointer">--}}
{{--                    <input type="checkbox" id="que{{ $questionStore->id }}" class="" name="" value="{{ $questionStore->id }}" style="display: none">--}}
{{--                    <label for="que{{ $questionStore->id }}" class="que-check"  style="cursor: pointer" data-question-id="{{ $questionStore->id }}">--}}
{{--                        <span class="float-start">#{{ $loop->iteration }}&nbsp;</span> <span class="float-start">{!! $questionStore->question !!}</span>--}}
{{--                    </label>--}}
{{--                </div>--}}
{{--            @endforeach--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endif--}}

@if(!empty($content->questionStoresForClassXm))
    <div class="card card-body">
        <h2 class="text-center">Assigned Questions ({{ count($content->questionStoresForClassXm) }} Ques)</h2>
        <div class="row">
            @foreach($content->questionStoresForClassXm as $questionStore)
                <div class="col-md-6 mt-2 border  p-3 shadow" id="question{{ $questionStore->id }}" style="cursor: pointer">
                    <div class="row">
                        <div class="col-sm-10">
                            <label for="que{{ $questionStore->id }}" class="que-check"  style="cursor: pointer" data-question-id="{{ $questionStore->id }}">
                                <span class="float-start">{{--#{{ $loop->iteration }}--}}&nbsp;</span> <span class="float-start">{!! $questionStore->question !!}</span>
                            </label>
                        </div>
                        <div class="col-sm-2">
                            <label class="float-end"><button type="button" class="btn btn-danger detach-class-question btn-sm" data-content-id="{{ $content->id }}" data-question-id="{{ $questionStore->id }}"><i class="fa-solid fa-trash"></i></button></label>
                        </div>
                    </div>
                    @if(!empty($questionStore->questionOptions) && count($questionStore->questionOptions) > 0)
                        <div class="">
                            <div>
                                <ol type="A">
                                    @foreach($questionStore->questionOptions as $questionOption)
                                        <li class="{{ $questionOption->is_correct == 1 ? 'text-success' : '' }}"><p class="{{ $questionOption->is_correct == 1 ? 'fw-bold' : '' }}">{{ $questionOption->option_title }}</p></li>
                                    @endforeach
                                </ol>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endif


<div class="modal fade" id="questionTopicModal" data-bs-backdrop="static" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Select Question Topic</h1>
                <button type="button" class="btn-close close-topic-modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="" id="">
                    @foreach($questionTopics as $key => $questionTopic)
                        <div class="parent-div">
                            <div class="card card-body bg-transparent shadow-0 mb-2 p-1">
                                <ul class="nav mb-0">
                                    @if(count($questionTopic->questionTopics) > 0)
                                        <li class="drop-icon f-s-15" style="cursor: pointer" data-id="{{ $questionTopic->id }}"><i class="fa-solid fa-circle-arrow-down"></i></li>
                                    @endif
                                    <li><label class="mb-0 f-s-15 ms-2"><input type="checkbox" class="check" value="{{ $questionTopic->id }}">{{ $questionTopic->name }}</label></li>
                                </ul>
                            </div>
                            @if(!empty($questionTopic))
                                @if(count($questionTopic->questionTopics) > 0)
                                    @include('backend.course-management.course.section-contents.question-topic-loop', ['questionTopic' => $questionTopic, 'child' => 15])
                                @endif
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-topic-modal" >Close</button>
                <button type="button" class="btn btn-primary" id="okDone">Save</button>
            </div>
        </div>
    </div>
</div>
