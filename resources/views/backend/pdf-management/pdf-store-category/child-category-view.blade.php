@if(!empty($category->pdfStoreCategories))
    <ol class="dd-list list-group">
        @foreach($category->pdfStoreCategories as $kk => $sub_category)
            <li class="dd-item list-group-item" data-id="{{ $sub_category['id'] }}" >
                <div class="dd-handle" >{{ $sub_category['title'] }}</div>
                <div class="dd-option-handle">
                    <a href="{{ route('pdf-stores.index', ['cat-id' => $sub_category['id']]) }}" class="btn btn-warning btn-sm" >Pdf</a>
                    @can('create-pdf-category')
                        <a href="" data-category-id="{{ $sub_category['id'] }}" class="btn btn-primary btn-sm category-add-btn" >Add</a>
                    @endcan
                    @can('edit-pdf-category')
                        <a href="{{ route('pdf-store-categories.edit', $sub_category['id']) }}" data-category-id="{{ $sub_category['id'] }}" class="btn btn-success btn-sm category-edit-btn" >Edit</a>
                        @endcan
                    @can('delete-pdf-category')
                        <form action="{{ route('pdf-store-categories.destroy', $sub_category['id']) }}" method="post" class="d-inline" >
                            @csrf
                            @method('delete')
                            <button type="submit" data-category-id="{{ $sub_category['id'] }}" class="btn btn-danger btn-sm data-delete-form" >Delete</button>
                        </form>
                        @endcan
{{--                    <a href="{{ route('course-categories.edit', ['category_id' => $sub_category['category_id'] ]) }}" class="btn btn-success btn-sm" >Edit</a>--}}
{{--                    <a href="{{ route('course-categories.remove', ['category_id' => $sub_category['category_id'] ]) }}" class="btn btn-danger btn-sm" >Delete</a>--}}
                </div>

                @include('backend.pdf-management.pdf-store-category.child-category-view', [ 'category' => $sub_category])
            </li>
        @endforeach
    </ol>
@endif
