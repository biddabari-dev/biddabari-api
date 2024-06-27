@extends('backend.master')

@section('title', 'Blogs')

@section('body')
    <div class="row py-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">Blogs</h4>
                    @can('create-blog')
                        <button type="button" data-bs-toggle="modal" data-bs-target="#coursesModal" class="rounded-circle open-modal text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4"><i class="fa-solid fa-circle-plus"></i></button>
                    @endcan
                </div>
                <div class="card-body">
                    <table class="table" id="file-datatable">
                        <thead>
                            <tr>
{{--                                <th>#</th>--}}
{{--                                <th>Blog Category</th>--}}
                                <th>Title</th>
                                <th>Sub Title</th>
                                <th>Image</th>
{{--                                <th>Video</th>--}}
{{--                                <th>Content</th>--}}
                                <th>Author</th>
                                <th>Features</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($blogs))
                                @foreach($blogs as $blog)
                                    <tr>
{{--                                        <td>{{ $loop->iteration }}</td>--}}
{{--                                        <td>{{ $blog->blogCategory->name }}</td>--}}
                                        <td>{{ $blog->title }}</td>
                                        <td>{{ $blog->sub_title }}</td>
                                        <td>
                                            <img src="{{ asset($blog->image) }}" alt="" style="height: 70px" />
                                        </td>
{{--                                        <td>--}}
{{--                                            <video src="{{ $blog->video_url }}" width="250" height="150" controls>--}}
{{--                                                <source src="{{ $blog->video_url }}" type="video/*">--}}
{{--                                            </video>--}}
{{--                                        </td>--}}
{{--                                        <td>{!! \Illuminate\Support\Str::words($blog->body, 10) !!}</td>--}}
{{--                                        <td>{!! $blog->body !!}</td>--}}
                                        <td>{{ $blog->user->name }}</td>
                                        <td>
                                            <span href="" class="badge badge-sm bg-primary">{{ $blog->is_featured == 1 ? 'Featured' : 'Not Featured' }}</span>
                                            <span href="" class="badge badge-sm bg-primary">{{ $blog->status == 1 ? 'Published' : 'Unpublished' }}</span>
                                        </td>
                                        <td>
                                            @can('show-blog')
                                                <a href="" data-blog-id="{{ $blog->id }}" class="btn btn-sm btn-success show-btn" title="Edit Blog">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                            @endcan
                                            @can('edit-blog')
                                                <a href="" data-blog-id="{{ $blog->id }}" class="btn btn-sm btn-warning edit-btn" title="Edit Blog">
                                                    <i class="fa-solid fa-edit"></i>
                                                </a>
                                                @endcan
                                            @can('delete-blog')
                                                <form class="d-inline" action="{{ route('blogs.destroy', $blog->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-sm btn-danger data-delete-form" title="Delete Blog">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                                @endcan
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
    <div class="modal fade modal-div" id="coursesModal" data-bs-backdrop="static" data-modal-parent="coursesModal" >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" id="modalForm">
                @include('backend.blog-management.blogs.form')
            </div>
        </div>
    </div>
@endsection
@push('style')
    <!-- DragNDrop Css -->
{{--    <link href="{{ asset('/') }}backend/assets/css/dragNdrop.css" rel="stylesheet" type="text/css" />--}}

@endpush

@push('script')
{{--    datatable--}}
@include('backend.includes.assets.plugin-files.datatable')
@include('backend.includes.assets.plugin-files.editor')

@if($errors->any())
    <script>
        $(function () {
            $('#coursesModal').modal('show');
        })
    </script>
@endif

<script>
    $(document).on('click', '.open-modal', function () {
        event.preventDefault();
        // resetForm('coursesForm');
        $('#coursesModal').modal('show');
    })
</script>

    {{--    store course--}}
    <script>

    </script>

{{--    edit course category--}}
    <script>
        $(document).on('click', '.edit-btn', function () {
            event.preventDefault();
            var courseId = $(this).attr('data-blog-id');
            $.ajax({
                url: "/blogs/"+courseId+"/edit",
                method: "GET",
                // dataType: "JSON",
                success: function (data) {
                    console.log(data);
                    $('#modalForm').empty().append(data);
                    $('#summernote').summernote('destroy');
                    $('#summernote').summernote();

                    $('#coursesModal').modal('show');
                }
            })
        })
    </script>
{{--    show course category--}}
    <script>
        $(document).on('click', '.show-btn', function () {
            event.preventDefault();
            var courseId = $(this).attr('data-blog-id');
            $.ajax({
                url: "/blogs/"+courseId,
                method: "GET",
                // dataType: "JSON",
                success: function (data) {
                    console.log(data);
                    $('#modalForm').empty().append(data);
                    $('#summernote').summernote('destroy');
                    $('#summernote').summernote();

                    $('#coursesModal').modal('show');
                }
            })
        })
    </script>
{{-- update course category--}}
    <script>

    </script>

    <script>
        $(document).ready(function() {
            $('#imagez').change(function() {
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
