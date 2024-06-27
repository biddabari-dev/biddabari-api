@foreach($courseCategory->courseCategories as $index => $subCategory)

    <option value="{{ $subCategory->id }}" {{ isset($_GET['category_id']) && $_GET['category_id'] == $subCategory->id ? 'selected' : '' }} >
        @for($i = 0; $i <= $child; $i++)
            {{ '>' }}
        @endfor
        {{ $subCategory->name }}
    </option>
    @if(!empty($courseCategory))
        @if(count($courseCategory->courseCategories) > 0)
            @include('backend.course-management.course.courses.course-category-loop-type-two', ['courseCategory' => $subCategory, 'child' => $child + $child, 'course' => $course ?? ''])
        @endif
    @endif
@endforeach
