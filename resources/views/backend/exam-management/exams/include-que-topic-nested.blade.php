@foreach($questionTopic->questionTopics as $index => $questionSubTopic)
    <option value="{{ $questionSubTopic->id }}" {{--{{ isset($exam) ? ($exam->exam_category_id == $examSubCategory->id ? 'selected' : '') : '' }}--}} >
        @for($i = 0; $i <= $child; $i++)
            {{ '>' }}
        @endfor
        {{ $questionSubTopic->name }}
    </option>
    @if(isset($questionSubTopic->questionTopics))
        @include('backend.exam-management.exams.include-que-topic-nested', ['child' => $child + $child, 'questionTopic' => $questionSubTopic])
    @endif
@endforeach
