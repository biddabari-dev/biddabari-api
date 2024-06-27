@extends('backend.master')

@section('title', 'Notices')

@section('body')
    <div class="row py-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">Notices</h4>
                    @can('create-notice')
                        <button type="button" data-bs-toggle="modal" data-bs-target="#noticeModal" class="rounded-circle open-modal text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4"><i class="fa-solid fa-circle-plus"></i></button>
                    @endcan
                </div>
                <div class="card-body">
                    <table class="table" id="file-datatable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
{{--                            <th>Category</th>--}}
                            <th>Type</th>
                            <th>Image</th>
{{--                            <th>Content</th>--}}
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($notices))
                            @foreach($notices as $notice)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $notice->title }}</td>
{{--                                    <td>{{ $notice->noticeCategory->name  }}</td>--}}
                                    <td>{{ $notice->type }}</td>
                                    <td>
                                        <img src="{{ asset($notice->image) }}" alt="" style="height: 70px" />
                                    </td>
{{--                                    <td>{!! \Illuminate\Support\Str::words($notice->body, 10) !!}</td>--}}
                                    <td>
                                        <a href="" class="badge badge-sm bg-primary">{{ $notice->status == 1 ? 'Published' : 'Unpublished' }}</a>
                                    </td>
                                    <td>
                                        @can('show-notice')
                                            <button type="button" data-notice-id="{{ $notice->id }}" class="btn btn-sm btn-primary show-notice-btn" title="Show Notice">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                        @endcan
                                        @can('edit-notice')
                                            <button type="button" data-notice-id="{{ $notice->id }}" class="btn btn-sm btn-warning edit-notice-btn" title="Edit Notice">
                                                <i class="fa-solid fa-edit"></i>
                                            </button>
                                            @endcan
                                        @can('delete-notice')
                                            <form class="d-inline" action="{{ route('notices.destroy', $notice->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-danger data-delete-form" title="Delete Notice">
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
    <div class="modal fade modal-div" id="noticeModal" data-bs-backdrop="static" data-modal-parent="coursesModal" >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" id="modalForm">
                @include('backend.notice-management.notice.form')
            </div>
        </div>
    </div>
@endsection

@push('script')
    {{--    datatable--}}
    @include('backend.includes.assets.plugin-files.datatable')
    @include('backend.includes.assets.plugin-files.editor')

    @if($errors->any())
        <script>
            $(function () {
                $('#noticeModal').modal('show');
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
        // edit notice
        $(document).on('click', '.edit-notice-btn', function () {
            var noticeId = $(this).attr('data-notice-id');
            $.ajax({
                url: "/notices/"+noticeId+"/edit",
                method: "GET",
                success: function (data) {
                    console.log(data);
                    $('#modalForm').empty().append(data);
                    $('#summernote').summernote('destroy');
                    $('#summernote').summernote();
                    $('.select2').select2();
                    $('#image').change(function () {
                        var imageURL = URL.createObjectURL(event.target.files[0]);
                        $('#imagePreview').attr('src', imageURL).css({
                            height: '150px',
                            width: '150px',
                            marginTop: '0px',
                        })
                    });
                    $('#noticeModal').modal('show');
                }
            })
        })
        // show notice
        $(document).on('click', '.show-notice-btn', function () {
            var noticeId = $(this).attr('data-notice-id');
            $.ajax({
                url: "/notices/"+noticeId,
                method: "GET",
                success: function (data) {
                    console.log(data);
                    $('#modalForm').empty().append(data);
                    // $('#summernote').summernote('destroy');
                    // $('#summernote').summernote();
                    $('.select2').select2();
                    $('#image').change(function () {
                        var imageURL = URL.createObjectURL(event.target.files[0]);
                        $('#imagePreview').attr('src', imageURL).css({
                            height: '150px',
                            width: '150px',
                            marginTop: '0px',
                        })
                    });
                    $('#noticeModal').modal('show');
                }
            })
        })
    </script>
    <script>
        $(document).on('change', 'select[name="type"]', function () {
            var noticeType = $(this).val();
            if (noticeType == 'normal')
            {
                $('.image-row').removeClass('d-none');
            } else if (noticeType == 'scroll')
            {
                $('.image-row').addClass('d-none');
            }
        })
    </script>
@endpush
