@extends('backend.master')

@section('title', 'PDF Store Categories')

@section('body')
    <div class="row py-5">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">PDF Store Category</h4>
                    @can('create-pdf-category')
                        <button type="button" data-bs-toggle="modal" data-bs-target="#courseCategoryModal" class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4 open-modal"><i class="fa-solid fa-circle-plus"></i></button>
                    @endcan
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12 dd" id="nestable-wrapper">
                            <ol class="dd-list list-group">
                                @foreach($categories as $k => $category)
                                    <li class="dd-item list-group-item" data-id="{{ $category['id'] }}" >
                                        <div class="dd-handle" >{{ $category['title'] }}</div>
                                        <div class="dd-option-handle">
                                            <a href="{{ route('pdf-stores.index', ['cat-id' => $category['id']]) }}" class="btn btn-warning btn-sm" >Pdf</a>
                                            @can('create-pdf-category')
                                                <a href="" data-category-id="{{ $category['id'] }}" class="btn btn-primary btn-sm category-add-btn" >Add</a>
                                            @endcan
                                            @can('edit-pdf-category')
                                                <a href="{{ route('pdf-store-categories.edit', $category['id']) }}" data-category-id="{{ $category['id'] }}" class="btn btn-success btn-sm category-edit-btn" >Edit</a>
                                                @endcan
                                            @can('delete-pdf-category')
                                                <form action="{{ route('pdf-store-categories.destroy', $category['id']) }}" method="post" class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" data-category-id="{{ $category['id'] }}" class="btn btn-danger btn-sm data-delete-form" >Delete</button>
                                                </form>
                                                @endcan
{{--                                            <a href="{{ route('course-categories.edit', ['id' => $category['id'] ]) }}" class="btn btn-success btn-sm" >Edit</a>--}}
{{--                                            <a href="{{ route('course-categories.destroy', ['category_id' => $category['category_id'] ]) }}" class="btn btn-danger btn-sm" >Delete</a>--}}
                                        </div>

                                        @if(!empty($category->pdfStoreCategories))
                                            @include('backend.pdf-management.pdf-store-category.child-category-view', [ 'category' => $category])
                                        @endif
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>

                    <div class="row">
                        <form action="{{ route('pdfCategories.saveNestedCategories') }}" method="post" id="nestedCategoryOrderForm">
                            @csrf
                            <textarea style="display: none;" name="nested_category_array" id="nestable-output"></textarea>
                            <button type="submit" class="btn btn-success" style="margin-top: 15px;display: none" >Update Order</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-div" data-bs-backdrop="static" id="courseCategoryModal">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable-body">
            <div class="modal-content">
                <form action="" method="post" enctype="multipart/form-data" id="courseCategoryForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Course Category</h5>
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                    </div>

                    <div class="modal-body" id="formModalBody">
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label for="">Title</label>
                                <input type="text" name="title" required class="form-control" placeholder="Name" />
                                <span id="title" class="text-danger">{{ $errors->has('title') ? $errors->first('title') : '' }}</span>
                            </div>
                            <div class="col-md-6 position-relative">
{{--                                <input type="checkbox" id="switch5" name="status" switch="warning" />--}}
{{--                                <label for="switch5" class="f-s-16"></label>--}}

                                <div class="float-start">
                                    <div class="material-switch">
                                        <input id="someSwitchOptionInfo" name="status" type="checkbox" checked />
                                        <label for="someSwitchOptionInfo" class="label-info"></label>
                                    </div>
                                    <label for="" class="switch-label">Active</label>
                                </div>


{{--                                <div class="float-start ms-3">--}}
{{--                                    <div class="material-switch">--}}
{{--                                        <input id="someSwitchOptionWarning" name="is_featured" type="checkbox" checked />--}}
{{--                                        <label for="someSwitchOptionWarning" class="label-info"></label>--}}
{{--                                    </div>--}}
{{--                                    <label for="" class="switch-label">Featured</label>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 mt-2">
                                <label for="">Image</label>
                                <input type="file" name="image" id="categoryImage" accept="images/*">
                                <span id="image" class="text-danger">{{ $errors->has('image') ? $errors->first('image') : '' }}</span>
                            </div>
                            <div class="col-md-4 mt-2">
                                <div>
                                    <img src="" id="imagePreview" style=""/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
{{--                        <button type="reset" class="btn btn-warning">Reset</button>--}}
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary submit-btn" value="save">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <!-- DragNDrop Css -->
    <link href="{{ asset('/') }}backend/assets/css/dragNdrop.css" rel="stylesheet" type="text/css" />
    <style>
        input[switch]+label {
            margin-bottom: 0px;
        }
        #imagePreview {
            display: none;
        }
    </style>
@endpush

@push('script')
    <!-- INTERNAL Summernote Editor js -->
    <script src="{{ asset('/') }}backend/assets/plugins/summernote-editor/summernote1.js"></script>
    <script src="{{ asset('/') }}backend/assets/js/summernote.js"></script>
    <!-- DragNDrop js -->
    <script src="{{ asset('/') }}backend/assets/plugins/dragNdrop/jquery.nestable.js"></script>
    <script src="{{ asset('/') }}backend/assets/plugins/dragNdrop/init.js"></script>

    <script>
        {{--    store course category--}}
        $(document).on('click', '.submit-btn', function () {
            event.preventDefault();
            var form = $('#courseCategoryForm')[0];
            var formData = new FormData(form);
            // $.ajax({
            //     url: "{{ route('pdf-store-categories.store') }}",
            //     method: "POST",
            //     data: formData,
            //     dataType: "JSON",
            //     contentType: false,
            //     processData: false,
            //     success: function (message) {
            //         toastr.success(message);
            //         $('#courseCategoryModal').modal('hide');
            //         window.location.reload();
            //     },
            //     error: function (errors) {
            //         if (errors.responseJSON)
            //         {
            //             $('span[class="text-danger"]').empty();
            //             var allErrors = errors.responseJSON.errors;
            //             for (key in allErrors)
            //             {
            //                 $('#'+key).empty().append(allErrors[key]);
            //             }
            //         }
            //     }
            // })
        })
    </script>
    <script>
        {{--    edit course category--}}
        $(document).on('click', '.category-edit-btn', function () {
            event.preventDefault();
            var categoryId = $(this).attr('data-category-id');
            $.ajax({
                url: base_url+"pdf-store-categories/"+categoryId+"/edit",
                method: "GET",
                dataType: "JSON",
                success: function (data) {
                    console.log(data.note)
                    $('input[name="title"]').val(data.title);
                    if (data.status == 1)
                    {
                        $('input[name="status"]').attr('checked', true);
                    } else {
                        $('input[name="status"]').attr('checked', false);
                    }
                    $('.submit-btn').addClass('update-btn').removeClass('submit-btn');
                    if (data.image != null)
                    {
                        $('#imagePreview').attr('src', data.image).css({height: '150px', width: '150px', marginTop: '5px', display: 'block'});
                    }
                    $('#courseCategoryForm').attr('action', base_url+'pdf-store-categories/update/'+data.id);
                    $('#courseCategoryModal').modal('show');
                }
            })
        })
    </script>

    <script>
        // show nested add modal
        $(document).on('click', '.category-add-btn', function () {
            event.preventDefault();
            var categoryId = $(this).attr('data-category-id');
            if ($('input[name="category_id"]').length > 0)
            {
                $('input[name="category_id"]').val(categoryId);
            } else if($('input[name="category_id"]').length == 0)
            {
                $('#formModalBody').append('<input type="hidden" name="parent_id" value="'+categoryId+'">');
            }
            $('#courseCategoryModal').modal('show');
        })
        // show main modal
        $(document).on('click', '.open-modal', function () {
            event.preventDefault();
            if ($('input[name="category_id"]').length > 0)
            {
                $('input[name="category_id"]').remove();
            }
            $('#courseCategoryModal').modal('show');
        })
    </script>
    <script>
        $(document).on('change', '#nestable-wrapper', function () {
            setTimeout(function () {
                var data = $('#nestedCategoryOrderForm').serialize();
                $.ajax({
                    url: "{{ route('pdfCategories.saveNestedCategories') }}",
                    method: "POST",
                    data: data,
                    dataType: "JSON",
                    success: function (message) {
                        toastr.success(message);
                    }
                })
            }, 800)
        })
    </script>
    <script>
        $(document).on('keyup', 'input:not(#discountAmount),textarea', function () {
            var selectorId = $(this).attr('name');
            if ($('#'+selectorId).text().length)
            {
                $('#'+selectorId).text('');
            }
        })
        $(document).on('change', 'select', function () {
            var selectorId = $(this).attr('name');
            if ($('#'+selectorId).text().length)
            {
                $('#'+selectorId).text('');
            }
        })
    </script>


    <script>
        $(document).ready(function() {
            $('#categoryImage').change(function() {
                var imgURL = URL.createObjectURL(event.target.files[0]);
                $('#imagePreview').attr('src', imgURL).css({
                    height: 150+'px',
                    width: 150+'px',
                    marginTop: '5px',
                    display: 'block'
                });
            });
        });
    </script>
@endpush
