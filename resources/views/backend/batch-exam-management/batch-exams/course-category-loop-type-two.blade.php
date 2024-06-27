@foreach($batchExamCategory->batchExamCategories as $index => $subCategory)

    <option value="{{ $subCategory->id }}" >
        @for($i = 0; $i <= $child; $i++)
            {{ '>' }}
        @endfor
        {{ $subCategory->name }}
    </option>
    @if(!empty($subCategory))
        @if(count($batchExamCategory->batchExamCategories) > 0)
            @include('backend.batch-exam-management.batch-exams.course-category-loop-type-two', ['batchExamCategory' => $subCategory, 'child' => $child + $child])
        @endif
    @endif
@endforeach



{{--@foreach($batchExamCategory->batchExamCategories as $index => $subCategory)--}}
{{--    <div class="card card-body m-l-{{ $child }} bg-transparent shadow-0 d-none childDiv{{ $batchExamCategory->id }} mb-2 p-1" id="childDiv">--}}
{{--        <ul class="nav">--}}
{{--            @if(count($subCategory->batchExamCategories) > 0)--}}
{{--                <li data-id="{{ $subCategory->id }}" style="cursor: pointer" class="drop-icon f-s-15"><i class="fa-solid fa-circle-arrow-down"></i></li>--}}
{{--            @else--}}
{{--                <li class="ms-3"></li>--}}
{{--            @endif--}}
{{--            <li><label class="ms-2 mb-0 f-s-15"><input type="checkbox" class="check" @if(isset($batchExam) && count($batchExam->batchExamCategories) > 0) @foreach($batchExam->batchExamCategories as $courseSelectedCategory) {{ $subCategory->id == $courseSelectedCategory->id ? 'checked' : '' }} @endforeach @endif value="{{ $subCategory->id }}">{{ $subCategory->name }}</label></li>--}}
{{--        </ul>--}}
{{--    </div>--}}
{{--    @if(!empty($subCategory))--}}
{{--        @if(count($subCategory->batchExamCategories) > 0)--}}
{{--            @include('backend.batch-exam-management.batch-exams.course-category-loop', ['batchExamCategory' => $subCategory, 'child' => $child + $child ?? ''])--}}
{{--        @endif--}}
{{--    @endif--}}
{{--@endforeach--}}
