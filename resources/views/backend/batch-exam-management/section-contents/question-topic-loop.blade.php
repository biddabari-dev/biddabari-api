@foreach($questionTopic->questionTopics as $index => $subCategory)
    <div class="card card-body m-l-{{ $child }} bg-transparent shadow-0 d-none childDiv{{ $questionTopic->id }} mb-2 p-1" id="childDiv">
        <ul class="nav">
            @if(count($subCategory->questionTopics) > 0)
                <li data-id="{{ $subCategory->id }}" style="cursor: pointer" class="drop-icon f-s-15"><i class="fa-solid fa-circle-arrow-down"></i></li>
            @endif
            <li><label class="ms-2 mb-0 f-s-15"><input type="checkbox" class="check" value="{{ $subCategory->id }}">{{ $subCategory->name }}</label></li>
        </ul>
    </div>
    @if(!empty($subCategory))
        @if(count($subCategory->questionTopics) > 0)
            @include('backend.batch-exam-management.section-contents.question-topic-loop', ['questionTopic' => $subCategory, 'child' => $child + $child ?? ''])
        @endif
    @endif
@endforeach
