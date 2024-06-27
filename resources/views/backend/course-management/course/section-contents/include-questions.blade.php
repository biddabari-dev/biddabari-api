@forelse($questionTopics as $questionTopic)
    @if(count($questionTopic->questionStores) > 0)
        <div class="card-header bg-light mt-2">
            <h3 class="me-auto" id="">{{ $questionTopic->name }}</h3>
            <label for="selectAll-{{ $questionTopic->id }}" class="ms-auto select-all" data-question-topic-id="{{ $questionTopic->id }}"><input type="checkbox" id="selectAll-{{ $questionTopic->id }}" data-question-topic-id="{{ $questionTopic->id }}" class="check-all"> Select All</label>
        </div>
        <div class="card-body">
            <div class="row" >
                @foreach($questionTopic->questionStores as $questionStore)
                    <div class="col-md-6 mt-2 border  p-3 shadow" style="cursor: pointer">
                        <input type="checkbox" id="que{{ $questionStore->id }}" class="que-top-{{ $questionTopic->id }}" name="question_ids[]" value="{{ $questionStore->id }}" style="display: none">
                        <label for="que{{ $questionStore->id }}" class="que-check que-check-id-{{ $questionTopic->id }}" data-topic-id="{{ $questionTopic->id }}" style="cursor: pointer" data-question-id="{{ $questionStore->id }}">
                            <span class="float-start">#{{ $loop->iteration }}&nbsp;</span> <span class="float-start">{!! $questionStore->question !!}</span>
                            @if(isset($question->question_image))
                                <br>
                                <span class="float-start">
                                    <img src="{{ asset($question->question_image) }}" alt="" class="img-fluid" style="max-height: 60px" />
                                </span>
                            @endif
                        </label>


                        @if(!empty($questionStore->questionOptions) && count($questionStore->questionOptions) > 0)
                            <div class="">
                                @if(isset($question->question_option_image))
                                    <div>
                                        <img src="{{ asset($question->question_option_image) }}" alt="" class="img-fluid" style="max-height: 60px" />
                                    </div>
                                @endif
                                <div>
                                    <ol type="A">
                                        @foreach($questionStore->questionOptions as $questionOption)
                                            <li class="{{ $questionOption->is_correct == 1 ? 'text-success' : '' }}"><p class="{{ $questionOption->is_correct == 1 ? 'fw-bold' : '' }}">{{ $questionOption->option_title }}</p></li>
                                        @endforeach
                                    </ol>
                                </div>
                                @if(isset($questionStore->mcq_ans_description))
                                    <div>
                                        {!! $questionStore->mcq_ans_description !!}
                                    </div>
                                @endif
                            </div>
                        @endif

                    </div>
                @endforeach
            </div>
        </div>
    @endif
@empty
    <div class="card card-body">
        <p>No Questions available in this category.</p>
    </div>
@endforelse
<div class="card-body">
    <div class="row">
        <div class="col-md-6">
            <button type="submit" class="btn btn-success">Submit</button>
        </div>
    </div>
</div>
