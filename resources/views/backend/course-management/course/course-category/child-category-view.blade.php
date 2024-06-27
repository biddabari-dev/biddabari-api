@if(!empty($category->courseCategoriesByOrderAsc))
    <ol class="dd-list list-group">
        @foreach($category->courseCategoriesByOrderAsc as $kk => $sub_category)
            <li class="dd-item list-group-item" data-id="{{ $sub_category['id'] }}" >
                <div class="dd-handle" >{{ $sub_category['name'] }}</div>
                <div class="dd-option-handle">
                    <a href="{{ route('courses.index', ['category_id' => $sub_category['id']]) }}" class="btn btn-sm  btn-secondary" title="View Course"><i class="fa-solid fa-book"></i></a>
                    @can('create-course-category')
                        <a href="" data-category-id="{{ $sub_category['id'] }}" class="btn btn-primary btn-sm category-add-btn" ><i class="fa-solid fa-plus"></i></a>
                    @endcan
                    @can('edit-course-category')
                        <a href="{{ route('course-categories.edit', $sub_category['id']) }}" data-category-id="{{ $sub_category['id'] }}" class="btn btn-success btn-sm category-edit-btn" ><i class="fa-solid fa-edit"></i></a>
                    @endcan
                    @can('delete-course-category')
                        <form action="{{ route('course-categories.destroy', $sub_category['id']) }}" method="post" class="d-inline" {{--onsubmit="return confirm('Are you sure to delete this?')"--}} >
                            @csrf
                            @method('delete')
                            <button type="submit" data-category-id="{{ $sub_category['id'] }}" class="btn btn-danger btn-sm data-delete-form" ><i class="fa-solid fa-trash"></i></button>
                        </form>
                    @endcan
{{--                    <a href="{{ route('course-categories.edit', ['category_id' => $sub_category['category_id'] ]) }}" class="btn btn-success btn-sm" >Edit</a>--}}
{{--                    <a href="{{ route('course-categories.remove', ['category_id' => $sub_category['category_id'] ]) }}" class="btn btn-danger btn-sm" >Delete</a>--}}
                </div>

                @include('backend.course-management.course.course-category.child-category-view', [ 'category' => $sub_category])
            </li>
        @endforeach
    </ol>
@endif
