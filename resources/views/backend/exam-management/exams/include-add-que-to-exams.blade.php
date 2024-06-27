<div class="row">
    <div class="col-md-6">
        <div class="card card-body">
            <h4>Title: <span id="sectionContentTitle">{{ $exam->title }}</span></h4>
        </div>
    </div>
</div>
<form action="{{ route('assign-question-to-exam') }}" method="post" id="" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="xm_type" value="{{ $examType }}">
    <input type="hidden" name="exam_id" value="{{ $exam->id }}">
    <div class="" id="">
        <div class="row mt-3">
            <div class="col-md-5 select2-div">
                <label for="">Question Topics</label>
                <select name="" id="questionTopic" multiple class="form-control select2" data-placeholder="Select a Question Type">
                    <option disabled >Select a Question Type</option>
                    @foreach($questionTopics as $questionTopic)
                        <option value="{{ $questionTopic->id }}">{{ $questionTopic->name }}</option>
                    @endforeach
                </select>
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

@if(!empty($exam->questionStores))
    <div class="card card-body">
        <h2 class="text-center">Assigned Questions</h2>
        <div class="row">
            @foreach($exam->questionStores as $questionStore)
                <div class="col-md-6 mt-2 border  p-3 shadow" style="cursor: pointer">
                    <input type="checkbox" id="que{{ $questionStore->id }}" class="" name="" value="{{ $questionStore->id }}" style="display: none">
                    <label for="que{{ $questionStore->id }}" class="que-check"  style="cursor: pointer" data-question-id="{{ $questionStore->id }}">
                        <span class="float-start">#{{ $loop->iteration }}&nbsp;</span> <span class="float-start">{!! $questionStore->question !!}</span>
                    </label>
                </div>
            @endforeach
        </div>
    </div>
@endif
