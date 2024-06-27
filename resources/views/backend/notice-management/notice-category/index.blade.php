@extends('backend.master')

@section('title', 'Notice Categories')

@section('body')
    <div class="row py-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">Notice Categories</h4>
                    @can('create-notice-category')
                        <button type="button" data-bs-toggle="modal" data-bs-target="#noticeCategoryModal" class="rounded-circle open-modal text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4"><i class="fa-solid fa-circle-plus"></i></button>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="py-5">
                        <div class="accordion" id="accordionExample">
                            @if(isset($noticeCategories))
                                @foreach($noticeCategories as $key => $noticeCategory)
                                    <div class="accordion-item card p-3 mb-0">
                                        <div class="accordian_header" style="cursor: pointer">
                                            <div class="row">
                                                <h3 class="col-sm-9" data-bs-toggle="collapse" data-bs-target="#collapse{{ $key }}">
                                                    @if(count($noticeCategory->noticeCategories) > 0)
                                                        <i class="fa-solid fa-arrow-circle-down f-s-16"></i>
                                                    @endif
                                                    <span class="f-s-18">{{ $noticeCategory->name }}</span>
                                                </h3>
                                                <div class="col-sm-3">
                                                    <div class="float-end">
                                                        @can('add-sub-cat-to-notice-category')
                                                            <button type="button" data-notice-category-id="{{ $noticeCategory->id }}" class="btn btn-sm btn-info add-sub-category-btn" title="Add Sub Category">
                                                                <i class="fa-solid fa-plus"></i>
                                                            </button>
                                                        @endcan
                                                        @can('edit-notice-category')
                                                            <button type="button" data-notice-category-id="{{ $noticeCategory->id }}" class="btn btn-sm btn-warning edit-notice-category-btn" title="Edit Notice Category">
                                                                <i class="fa-solid fa-edit"></i>
                                                            </button>
                                                            @endcan
                                                        @can('delete-notice-category')
                                                            <form class="d-inline" action="{{ route('notice-categories.destroy', $noticeCategory->id) }}" method="post">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit" class="btn btn-sm btn-danger data-delete-form" title="Delete Notice Category">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                </button>
                                                            </form>
                                                            @endcan
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="collapse{{ $key }}" class="accordion-collapse collapse " aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                @if(isset($noticeCategory->noticeCategories))
                                                    @include('backend.notice-management.notice-category.show-nested-cats', ['noticeCategories' => $noticeCategory->noticeCategories, 'child' => 1])
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>`
                    </div>
{{--                    <table class="table" id="file-datatable">--}}
{{--                        <thead>--}}
{{--                        <tr>--}}
{{--                            <th>#</th>--}}
{{--                            <th>Name</th>--}}
{{--                            <th>Sub Category Of</th>--}}
{{--                            <th>Image</th>--}}
{{--                            <th>Status</th>--}}
{{--                            <th>Actions</th>--}}
{{--                        </tr>--}}
{{--                        </thead>--}}
{{--                        <tbody>--}}
{{--                        @if(isset($noticeCategories))--}}
{{--                            @foreach($noticeCategories as $noticeCategory)--}}
{{--                                <tr>--}}
{{--                                    <td>{{ $loop->iteration }}</td>--}}
{{--                                    <td style="cursor: pointer" data-notice-id="{{ $noticeCategory->id }}" class="notice-name">{{ $noticeCategory->name }}</td>--}}
{{--                                    <td>{{ $noticeCategory->notice_category_id != 0 ? $noticeCategory->noticeCategory->name : 'Root' }}</td>--}}
{{--                                    <td>--}}
{{--                                        <img src="{{ asset($noticeCategory->image) }}" alt="" style="height: 70px" />--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        <a href="" class="badge badge-sm bg-primary">{{ $noticeCategory->status == 1 ? 'Published' : 'Unpublished' }}</a>--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        <button type="button" data-notice-category-id="{{ $noticeCategory->id }}" class="btn btn-sm btn-info add-sub-category-btn" title="Add Sub Category">--}}
{{--                                            <i class="fa-solid fa-plus"></i>--}}
{{--                                        </button>--}}
{{--                                        <button type="button" data-notice-category-id="{{ $noticeCategory->id }}" class="btn btn-sm btn-warning edit-notice-category-btn" title="Edit Notice Category">--}}
{{--                                            <i class="fa-solid fa-edit"></i>--}}
{{--                                        </button>--}}
{{--                                        <form class="d-inline" action="{{ route('notice-categories.destroy', $noticeCategory->id) }}" method="post" onsubmit="return confirm('Are you sure to delete this? Once deleted, It can not be undone.')">--}}
{{--                                            @csrf--}}
{{--                                            @method('delete')--}}
{{--                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete Notice Category">--}}
{{--                                                <i class="fa-solid fa-trash"></i>--}}
{{--                                            </button>--}}
{{--                                        </form>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                                @if(isset($noticeCategory->noticeCategories))--}}
{{--                                    @include('backend.notice-management.notice-category.show-nested-cats', ['child' =>1, 'noticeCategories' => $noticeCategory->noticeCategories])--}}
{{--                                @endif--}}
{{--                            @endforeach--}}
{{--                        @endif--}}
{{--                        </tbody>--}}
{{--                    </table>--}}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-div" id="noticeCategoryModal" data-bs-backdrop="static" data-modal-parent="coursesModal" >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" id="modalForm">
                @include('backend.notice-management.notice-category.form')
            </div>
        </div>
    </div>
@endsection

@push('script')
    {{--    datatable--}}
    @include('backend.includes.assets.plugin-files.datatable')

    @if($errors->any())
        <script>
            $(function () {
                $('#noticeCategoryModal').modal('show');
            })
        </script>
    @endif
    <script>
        // image preview
        $(document).ready(function () {
            $('#imagex').change(function () {
                var imageURL = URL.createObjectURL(event.target.files[0]);
                $('#imagePreview').attr('src', imageURL).css({
                    height: '150px',
                    width: '150px',
                    marginTop: '5px',
                })
            })
        })
    </script>

    <script>
        // edit notice category
        $(document).on('click', '.edit-notice-category-btn', function () {
            var noticeCategoryId = $(this).attr('data-notice-category-id');
            $.ajax({
                url: "/notice-categories/"+noticeCategoryId+"/edit",
                method: "GET",
                success: function (data) {
                    console.log(data);
                    $('#modalForm').empty().append(data);
                    $('#image').change(function () {
                        var imageURL = URL.createObjectURL(event.target.files[0]);
                        $('#imagePreview').attr('src', imageURL).css({
                            height: '150px',
                            width: '150px',
                            marginTop: '0px',
                        })
                    });
                    $('#noticeCategoryModal').modal('show');
                }
            })
        })
    </script>

    <script>
        // add sub category
        $(document).on('click', '.add-sub-category-btn', function () {
            var noticeCategoryId = $(this).attr('data-notice-category-id');
            $.ajax({
                url: "/notice-categories/add-sub-categories/"+noticeCategoryId,
                method: "GET",
                success: function (data) {
                    console.log(data);
                    $('#modalForm').empty().append(data);
                    $('#image').change(function () {
                        var imageURL = URL.createObjectURL(event.target.files[0]);
                        $('#imagePreview').attr('src', imageURL).css({
                            height: '150px',
                            width: '150px',
                            marginTop: '0px',
                        })
                    });
                    $('#noticeCategoryModal').modal('show');
                }
            })
        })
    </script>
    <script>
        $(document).on('click', '.notice-name', function () {
            var noticeCategoryId = $(this).attr('data-notice-id');
            if ($('.tr-'+noticeCategoryId).hasClass('d-none'))
            {
                $('.tr-'+noticeCategoryId).removeClass('d-none').css('transition', '1s');
            } else {
                $('.tr-'+noticeCategoryId).addClass('d-none');
            }
        })
    </script>
@endpush
