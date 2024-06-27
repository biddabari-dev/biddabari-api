@extends('backend.master')

@section('title', 'Course Categories')

@section('body')
    <div class="row py-5">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">Course Category</h4>
                    @can('create-course-category')
                        <button type="button" data-bs-toggle="modal" data-bs-target="#courseCategoryModal" class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4 open-modal"><i class="fa-solid fa-circle-plus"></i></button>
                    @endcan
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12 dd" id="nestable-wrapper">
                            <ol class="dd-list list-group">
                                @foreach($categories as $k => $category)
                                    <li class="dd-item list-group-item" data-id="{{ $category['id'] }}" >
                                        <div class="dd-handle" >{{ $category['name'] }}</div>
                                        <div class="dd-option-handle">
                                            <a href="{{ route('courses.index', ['category_id' => $category['id']]) }}" class="btn btn-sm  btn-secondary" title="View Course"><i class="fa-solid fa-book"></i></a>
                                            @can('create-course-category')
                                                <a href="" data-category-id="{{ $category['id'] }}" class="btn btn-primary btn-sm category-add-btn" title="Add Course Category"><i class="fa-solid fa-plus"></i></a>
                                            @endcan
                                            @can('edit-course-category')
                                                <a href="{{ route('course-categories.edit', $category['id']) }}" data-category-id="{{ $category['id'] }}" class="btn btn-success btn-sm category-edit-btn" title="Edit Category" ><i class="fa-solid fa-edit"></i></a>
                                            @endcan
                                            @can('delete-course-category')
                                                <form action="{{ route('course-categories.destroy', $category['id']) }}" method="post" class="d-inline " {{--onsubmit="return confirm('Are you sure to delete this?')"--}} >
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" data-category-id="{{ $category['id'] }}" class="btn btn-danger btn-sm data-delete-form" title="Delete Category" ><i class="fa-solid fa-trash"></i></button>
                                                </form>
                                            @endcan
{{--                                            <a href="{{ route('course-categories.edit', ['id' => $category['id'] ]) }}" class="btn btn-success btn-sm" >Edit</a>--}}
{{--                                            <a href="{{ route('course-categories.destroy', ['category_id' => $category['category_id'] ]) }}" class="btn btn-danger btn-sm" >Delete</a>--}}
                                        </div>

                                        @if(!empty($category->courseCategoriesByOrderAsc))
                                            @include('backend.course-management.course.course-category.child-category-view', [ 'category' => $category])
                                        @endif
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>

                    <div class="row">
                        <form action="{{ route('courseCategories.saveNestedCategories') }}" method="post" id="nestedCategoryOrderForm">
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
                                <label for="">Name</label>
                                <input type="text" name="name" required id="nameInput" class="form-control" placeholder="Name" />
                                <span class="text-danger" id="name"></span>
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
                                    <span class="text-danger" id="status"></span>
                                </div>

{{--                                <input type="checkbox" id="switch4" name="is_featured" switch="warning" />--}}
{{--                                <label for="switch4" class="f-s-16"></label>--}}


                                <div class="float-start ms-3">
                                    <div class="material-switch">
                                        <input id="someSwitchOptionWarning" name="is_featured" type="checkbox" checked />
                                        <label for="someSwitchOptionWarning" class="label-info"></label>
                                    </div>
                                    <label for="" class="switch-label">Featured</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="">Slug</label>
                                <input type="text" name="slug" required id="slugInput" class="form-control" placeholder="Slug" />
                                <span class="text-danger" id="slug"></span>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label for="">Note</label>
                                <textarea name="note" class="form-control" id="summernote" placeholder="Note" cols="30" rows="10"></textarea>
                                <span class="text-danger" id="note"></span>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label for="">Icon Class <br><span class="text-warning">[Use Font Awesome 6.4.0 classes]</span></label>
                                <input type="text" name="icon" class="form-control" placeholder="Icon CLass">
                                <span class="text-danger" id="icon"></span>

                            </div>
                            <div class="col-md-4 mt-2">
                                <label for="">Image <span class="text-red"> [300 x 200 pixels (WEBP format)] </span> </label>
                                <input type="file" name="image" id="categoryImage" accept="images/*">
                                <span class="text-danger" id="image"></span>
                            </div>

                            <div class="col-md-6 mt-2">
                                <label for="">Banner Image ALT text</label>
                              <input type="text" class="form-control" name="alt_text" placeholder="Banner Image ALT Text">
                              <span class="text-danger" id="alt_text"></span>
            
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="">Banner Image Title</label>
                              <input type="text" class="form-control" name="banner_title"  placeholder="Banner Image Title">
                              <span class="text-danger" id="banner_title"></span>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- INTERNAL Summernote Editor js -->
    <script src="{{ asset('/') }}backend/assets/plugins/summernote-editor/summernote1.js"></script>
    <script src="{{ asset('/') }}backend/assets/js/summernote.js"></script>
    <!-- DragNDrop js -->
    <script src="{{ asset('/') }}backend/assets/plugins/dragNdrop/jquery.nestable.js"></script>
    <script src="{{ asset('/') }}backend/assets/plugins/dragNdrop/init.js"></script>



    <script>
        $(document).on('blur', '#nameInput', function () {
            var courseTitle = $(this).val();
            $('#slugInput').val(courseTitle.replace(/ /g, "-"));
        })
    </script>

    <script>
        {{--    store course category--}}
        $(document).on('click', '.submit-btn', function () {
            event.preventDefault();
            var form = $('#courseCategoryForm')[0];
            var formData = new FormData(form);
            // $.ajax({
            //     url: "{{ route('course-categories.store') }}",
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
                url: "/course-categories/"+categoryId+"/edit",
                method: "GET",
                dataType: "JSON",
                success: function (data) {
                    console.log(data.note);
                    $('span[class="text-danger"]').empty();
                    $('input[name="name"]').val(data.name);
                    $('input[name="slug"]').val(data.slug);
                    $('input[name="icon"]').val(data.icon);
                    $('input[name="alt_text"]').val(data.alt_text);
                    $('input[name="banner_title"]').val(data.banner_title);
                    if (data.status == 1)
                    {
                        $('input[name="status"]').attr('checked', true);
                    } else {
                        $('input[name="status"]').attr('checked', false);
                    }
                    if (data.is_featured == 1)
                    {
                        $('input[name="is_featured"]').attr('checked', true);
                    } else {
                        $('input[name="is_featured"]').attr('checked', false);
                    }
                    $('#summernote').summernote('destroy');
                    $('textarea[name="note"]').html(data.note);
                    $("#summernote").summernote({height:70})
                    $('.submit-btn').addClass('update-btn').removeClass('submit-btn');
                    if (data.image != null)
                    {
                        $('#imagePreview').attr('src', data.image).css({height: '150px', width: '150px', marginTop: '5px', display: 'block'});
                    }
                    $('#courseCategoryForm').attr('action', base_url+'course-categories/update/'+data.id);
                    $('#courseCategoryModal').modal('show');
                }
            })
        })
    </script>


    <script>
        {{--    store course category--}}
        $(document).on('click', '.update-btn', function () {
            event.preventDefault();
            var form = $('#courseCategoryForm')[0];
            var formData = new FormData(form);
            $.ajax({
                {{--url: "{{ route('course-categories.store') }}",--}}
                url: $('#courseCategoryForm').attr('action'),
                method: "POST",
                data: formData,
                dataType: "JSON",
                contentType: false,
                processData: false,
                success: function (message) {
                    toastr.success(message);
                    $('#courseCategoryModal').modal('hide');
                    window.location.reload();
                },
                error: function (errors) {
                    if (errors.responseJSON)
                    {
                        $('span[class="text-danger"]').empty();
                        var allErrors = errors.responseJSON.errors;
                        for (key in allErrors)
                        {
                            $('#'+key).empty().append(allErrors[key]);
                        }
                    }
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
            {{--resetFromInputAndSelect("{{ route('course-categories.store') }}")--}}
            {{--$('#summernote').summernote('reset');--}}
            $('#courseCategoryModal').modal('show');
        })
    </script>
    <script>
        $(document).on('change', '#nestable-wrapper', function () {
            setTimeout(function () {
                var data = $('#nestedCategoryOrderForm').serialize();
                $.ajax({
                    url: "{{ route('courseCategories.saveNestedCategories') }}",
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
        $(document).on('keyup', 'input,textarea', function () {
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
