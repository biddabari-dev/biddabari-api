@extends('backend.master')

@section('title', 'Blogs')

@section('body')
    <div class="row py-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">Circulars</h4>
                    @can('create-job-circular')
                        <button type="button" data-bs-toggle="modal" data-bs-target="#coursesModal" class="rounded-circle open-modal text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4"><i class="fa-solid fa-circle-plus"></i></button>
                    @endcan
                </div>
                <div class="card-body">
                    <table class="table" id="file-datatable">
                        <thead>
                            <tr>
{{--                                <th>#</th>--}}
{{--                                <th>Circular Category</th>--}}
                                <th>P. Title</th>
{{--                                <th>J. Title</th>--}}
                                <th>Vacancy</th>
{{--                                <th>About</th>--}}
{{--                                <th>Description</th>--}}
                                <th>Pub. Date</th>
                                <th>Exp. Date</th>
                                <th>Created By</th>
                                <th>Image</th>
                                <th>Features</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($circulars))
                                @foreach($circulars as $circular)
                                    <tr>
{{--                                        <td>{{ $loop->iteration }}</td>--}}
{{--                                        <td>{{ $circular->circularCategory->title }}</td>--}}
                                        <td>{{ $circular->post_title }}</td>
{{--                                        <td>{{ $circular->job_title }}</td>--}}
                                        <td>{{ $circular->vacancy }}</td>
{{--                                        <td>{!! str()->words($circular->about, 50) !!}</td>--}}
{{--                                        <td>{!! \Illuminate\Support\Str::words($circular->description, 50) !!}</td>--}}
                                        <td>{{ $circular->publish_date }}</td>
                                        <td>{{ $circular->expire_date }}</td>
                                        <td>{{ $circular->user->name }}</td>
                                        <td>
                                            <img src="{{ asset($circular->image) }}" alt="" style="height: 70px" />
                                        </td>
                                        <td>
                                            <span href="" class="badge badge-sm bg-primary">{{ $circular->is_featured == 1 ? 'Featured' : 'Not Featured' }}</span>
                                            <span href="" class="badge badge-sm bg-primary">{{ $circular->status == 1 ? 'Published' : 'Unpublished' }}</span>
                                        </td>
                                        <td>
                                            @can('show-job-circular')
                                                <a href="" data-blog-id="{{ $circular->id }}" class="btn btn-sm btn-info view-btn" title="View">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                            @endcan
                                            @can('edit-job-circular')
                                                <a href="" data-blog-id="{{ $circular->id }}" class="btn btn-sm btn-warning edit-btn" title="Edit Blog">
                                                    <i class="fa-solid fa-edit"></i>
                                                </a>
                                                @endcan
                                            @can('delete-job-circular')
                                                <form class="d-inline" action="{{ route('circulars.destroy', $circular->id) }}" method="post">
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
                @include('backend.circular-management.circulars.form')
            </div>
        </div>
    </div>
@endsection
@push('style')
    <!-- DragNDrop Css -->
{{--    <link href="{{ asset('/') }}backend/assets/css/dragNdrop.css" rel="stylesheet" type="text/css" />--}}
    <style>
        .datetimepicker {z-index: 100009!important;}
    </style>
@endpush

@push('script')
{{--    datatable--}}
@include('backend.includes.assets.plugin-files.datatable')
@include('backend.includes.assets.plugin-files.editor')
{{--@include('backend.includes.assets.plugin-files.date-time-picker')--}}
<script src="{{ asset('/') }}backend/assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js"></script>

<script>
    $(document).on('click', '.open-modal', function () {
        event.preventDefault();
        // resetForm('coursesForm');
        $('#coursesModal').modal('show');
    })
    $(function () {
        $('#summernote1').summernote({height:70,inheritPlaceholder: true});
        // $('#dateTime1').bootstrapMaterialDatePicker({ format: 'YYYY-MM-DD HH:mm' });
        $("#dateTime").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
        $("#dateTime1").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
    })
</script>

    {{--    store course--}}
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
        $(document).on('click', '.edit-btn', function () {
            event.preventDefault();
            var courseId = $(this).attr('data-blog-id');
            $.ajax({
                url: base_url+"circulars/"+courseId+"/edit",
                method: "GET",
                // dataType: "JSON",
                success: function (data) {
                    console.log(data);
                    $('#modalForm').empty().append(data);
                    $('#summernote').summernote('destroy');
                    $('#summernote1').summernote('destroy');
                    $('#summernote').summernote({height:70,inheritPlaceholder: true});
                    $('#summernote1').summernote({height:70,inheritPlaceholder: true});

                    // $('#dateTime').bootstrapMaterialDatePicker({ format: 'YYYY-MM-DD HH:mm' });
                    // $('#dateTime1').bootstrapMaterialDatePicker({ format: 'YYYY-MM-DD HH:mm' });

                    $("#dateTime").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
                    $("#dateTime1").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});

                    $('#coursesModal').modal('show');
                }
            })
        })
    </script>
{{-- update course category--}}
    <script>
        // $(document).on('click', '.update-btn', function () {
        //     event.preventDefault();
        //     var formData = $('#courseCategoryForm').serialize();
        //     $.ajax({
        //         url: $('#courseCategoryForm').attr('action'),
        //         method: "PUT",
        //         data: formData,
        //         dataType: "JSON",
        //         // async: false,
        //         // cache: false,
        //         contentType: false,
        //         processData: false,
        //         // enctype: 'multipart/form-data',
        //         success: function (message) {
        //             // console.log(formData);
        //             toastr.success(message);
        //             $('.update-btn').addClass('submit-btn').removeClass('update-btn');
        //             $('#courseCategoryForm').attr('action', '');
        //             $('#courseCategoryModal').modal('hide');
        //             window.location.reload();
        //             resetInputFields();
        //         }
        //     })
        // })
    </script>

{{--show circular--}}
{{--    view circular--}}
<script>
    $(document).on('click', '.view-btn', function () {
        event.preventDefault();
        var courseId = $(this).attr('data-blog-id');
        $.ajax({
            url: base_url+"circulars/"+courseId,
            method: "GET",
            // dataType: "JSON",
            success: function (data) {
                console.log(data);
                $('#modalForm').empty().append(data);

                $('#coursesModal').modal('show');
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
