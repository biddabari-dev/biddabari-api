{{--@if(!empty($noticeCategory->noticeCategories))--}}
{{--    @foreach($noticeCategories as $noticeCategoryx)--}}
{{--        <tr class="tr-{{ $noticeCategory->id }} d-none">--}}
{{--            --}}{{--                                    <td>{{ $loop->iteration }}</td>--}}
{{--            <td>{{ $noticeCategoryx->name }}</td>--}}
{{--            <td>{{ $noticeCategoryx->notice_category_id != 0 ? $noticeCategoryx->noticeCategory->name : 'Root' }}</td>--}}
{{--            <td>--}}
{{--                <img src="{{ asset($noticeCategoryx->image) }}" alt="" style="height: 70px" />--}}
{{--            </td>--}}
{{--            <td>--}}
{{--                <a href="" class="badge badge-sm bg-primary">{{ $noticeCategoryx->status == 1 ? 'Published' : 'Unpublished' }}</a>--}}
{{--            </td>--}}
{{--            <td>--}}
{{--                <button type="button" data-notice-category-id="{{ $noticeCategoryx->id }}" class="btn btn-sm btn-info add-sub-category-btn" title="Add Sub Category">--}}
{{--                    <i class="fa-solid fa-plus"></i>--}}
{{--                </button>--}}
{{--                <button type="button" data-notice-category-id="{{ $noticeCategoryx->id }}" class="btn btn-sm btn-warning edit-notice-category-btn" title="Edit Notice Category">--}}
{{--                    <i class="fa-solid fa-edit"></i>--}}
{{--                </button>--}}
{{--                <form class="d-inline" action="{{ route('notice-categories.destroy', $noticeCategoryx->id) }}" method="post" onsubmit="return confirm('Are you sure to delete this? Once deleted, It can not be undone.')">--}}
{{--                    @csrf--}}
{{--                    @method('delete')--}}
{{--                    <button type="submit" class="btn btn-sm btn-danger" title="Delete Notice Category">--}}
{{--                        <i class="fa-solid fa-trash"></i>--}}
{{--                    </button>--}}
{{--                </form>--}}
{{--            </td>--}}
{{--        </tr>--}}
{{--        @if(isset($noticeCategoryx->noticeCategories))--}}
{{--            @include('backend.notice-management.notice-category.show-nested-cats', ['child' => $child + $child, 'noticeCategories' => $noticeCategoryx->noticeCategories])--}}
{{--        @endif--}}
{{--    @endforeach--}}
{{--@endif--}}

@foreach($noticeCategories as $index => $subCategory)
    <div class="row card-body py-1" >
        <h3 class="col-sm-9">
            @if(count($subCategory->noticeCategories) > 0)
                <i class="fa-solid fa-arrow-circle-down f-s-16"></i>
            @endif
            <span class="f-s-18">{{ $subCategory->name }}</span>
        </h3>
        <div class="col-sm-3">
            <div class="float-end">
                @can('add-sub-cat-to-notice-category')
                    <button type="button" data-notice-category-id="{{ $subCategory->id }}" class="btn btn-sm btn-info add-sub-category-btn" title="Add Sub Category">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                @endcan
                @can('edit-notice-category')
                    <button type="button" data-notice-category-id="{{ $subCategory->id }}" class="btn btn-sm btn-warning edit-notice-category-btn" title="Edit Notice Category">
                        <i class="fa-solid fa-edit"></i>
                    </button>
                    @endcan
                @can('delete-notice-category')
                    <form class="d-inline" action="{{ route('notice-categories.destroy', $subCategory->id) }}" method="post" onsubmit="return confirm('Are you sure to delete this? Once deleted, It can not be undone.')">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-sm btn-danger" title="Delete Notice Category">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                    @endcan
            </div>
        </div>
    </div>
    @if(isset($subCategory->noticeCategories))
        <div class="ps-5">
            @include('backend.notice-management.notice-category.show-nested-cats', ['noticeCategories' => $subCategory->noticeCategories, 'child' => $child + $child])
        </div>
    @endif
@endforeach
