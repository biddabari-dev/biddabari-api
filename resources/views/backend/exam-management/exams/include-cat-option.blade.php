@foreach($examCategory->examCategories as $index => $examSubCategory)
    <option value="{{ $examSubCategory->id }}" {{ isset($exam) ? ($exam->exam_category_id == $examSubCategory->id ? 'selected' : '') : '' }}>
        @for($i = 0; $i <= $child; $i++)
            {{ '>' }}
        @endfor
        {{ $examSubCategory->name }}
    </option>
    @if(isset($examSubCategory->examCategories))
        @include('backend.exam-management.exams.include-cat-option', ['child' => $child + $child, 'examCategory' => $examSubCategory])
    @endif
@endforeach
