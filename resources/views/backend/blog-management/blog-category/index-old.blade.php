@extends('backend.master')

@section('title', 'Blog Categories')

@section('body')
    <div class="row py-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">Blog Categories</h4>
                    <button type="button" class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4 blog-category-modal-btn"><i class="fa-solid fa-circle-plus"></i></button>
                </div>
                <div class="card-body">


                    <table class="table" id="file-datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($blogCategories))
                                @foreach($blogCategories as $blogCategory)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $blogCategory->name }}</td>
                                        <td>
                                            <img src="{{ asset($blogCategory->image) }}" alt="" style="height: 70px" />
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" class="badge bg-primary">{{ $blogCategory->status == 1 ? 'Published' : 'Unpublished' }}</a>
                                        </td>
                                        <td>
                                            <a href="" data-blog-category-id="{{ $blogCategory->id }}" class="btn btn-sm btn-warning blog-category-edit-btn" title="Edit Blog Category">
                                                <i class="fa-solid fa-edit"></i>
                                            </a>
                                            <form class="d-inline" action="{{ route('blog-categories.destroy', $blogCategory->id) }}" method="post" onsubmit="return confirm('Are you sure to delete this? Once deleted, It can not be undone.')">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete Blog Category">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-div" id="blogCategoryModal" data-bs-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" id="">
                <form id="courseSectionForm" action="{{ route('blog-categories.store') }}" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="">Create Blog Categories</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body">

                        <div class="card card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    @csrf
                                    <label for="">Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Name" title="Name" />
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Status</label> <br>
                                    <div class="material-switch">
                                        <input id="someSwitchOptionInfo" name="status" type="checkbox" checked="">
                                        <label for="someSwitchOptionInfo" class="label-info"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    @csrf
                                    <label for="">Image</label>
                                    <input type="file" class="form-control" id="image" name="image" placeholder="Image" title="Image" />
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <img src="" id="imagePreview" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary " value="save">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <!-- DragNDrop Css -->
{{--    <link href="{{ asset('/') }}backend/assets/css/dragNdrop.css" rel="stylesheet" type="text/css" />--}}
    <style>
        input[switch]+label {
            margin-bottom: 0px;
        }

    </style>
@endpush

@push('script')

    @include('backend.includes.assets.plugin-files.datatable')
{{--    @include('backend.includes.assets.plugin-files.date-time-picker')--}}
{{--    @include('backend.includes.assets.plugin-files.editor')--}}
    {{--    store course--}}
    <script>
        $(document).on('click', '.blog-category-modal-btn', function () {
            event.preventDefault();
            // resetInputFields();
            if ($('input[name="_method"]').length)
            {
                $('input[name="_method"]').remove();
            }
            $('#courseSectionForm').attr('action', "{{ route('blog-categories.store') }}");
            $('#blogCategoryModal').modal('show');
        })
    </script>
    <script>
        {{--$(document).on('click', '.submit-btn', function () {--}}
        {{--    event.preventDefault();--}}
        {{--    var form = $('#coursesForm')[0];--}}
        {{--    var formData = new FormData(form);--}}
        {{--    $.ajax({--}}
        {{--        url: "{{ route('course-routines.store') }}",--}}
        {{--        method: "POST",--}}
        {{--        data: formData,--}}
        {{--        dataType: "JSON",--}}
        {{--        contentType: false,--}}
        {{--        processData: false,--}}
        {{--        success: function (message) {--}}
        {{--            // console.log(message);--}}
        {{--            toastr.success(message);--}}
        {{--            $('#coursesModal').modal('hide');--}}
        {{--            resetInputFields();--}}
        {{--            window.location.reload();--}}
        {{--        }--}}
        {{--    })--}}
        {{--})--}}
    </script>

{{--    edit course category--}}
    <script>
        $(document).on('click', '.blog-category-edit-btn', function () {
            event.preventDefault();
            var courseId = $(this).attr('data-blog-category-id'); //change value
            $.ajax({
                url: base_url+"blog-categories/"+courseId+"/edit",
                method: "GET",
                // dataType: "JSON",
                success: function (data) {
                    // console.log(data.note);
                    $('input[name="name"]').val(data.name);
                    $('#imagePreview').attr('src', data.image).css({height: '150px'});
                    if (data.status == 1)
                    {
                        $('input[name="status"]').attr('checked', true);
                    } else {
                        $('input[name="status"]').attr('checked', false);
                    }
                    $('#courseSectionForm').attr('action', base_url+"blog-categories/"+data.id).append('<input type="hidden" name="_method" value="put">');
                    $('#blogCategoryModal').modal('show');
                }
            })
        })
    </script>

    <script>
        $(document).ready(function() {
            $('#image').change(function() {
                var imgURL = URL.createObjectURL(event.target.files[0]);
                $('#imagePreview').attr('src', imgURL).css({
                    height: 150+'px',
                    width: 150+'px',
                    marginTop: '5px'
                });
            });
        });
    </script>


@endpush
