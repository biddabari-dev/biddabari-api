@extends('backend.master')

@section('title', 'Popup Notifications')

@section('body')
    <div class="row py-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">Popup Notifications</h4>
                    @can('create-notification')
                        <button type="button" class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4 blog-category-modal-btn"><i class="fa-solid fa-circle-plus"></i></button>
                    @endcan
                </div>
                <div class="card-body">


                    <table class="table" id="file-datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Popup Type</th>
                                <th>Action Button Text</th>
                                <th>Active Button Text</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($popupNotifications))
                                @foreach($popupNotifications as $popupNotification)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $popupNotification->title }}</td>
                                        <td>{{ $popupNotification->popup_type }}</td>
                                        <td>{{ $popupNotification->action_btn_text }}</td>
                                        <td>{{ $popupNotification->active_btn_link }}</td>
                                        <td>{!! str()->words($popupNotification->description, 10) !!}</td>
                                        <td>
                                            <img src="{{ asset($popupNotification->image) }}" alt="" style="height: 70px" />
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" class="badge bg-primary">{{ $popupNotification->status == 1 ? 'Published' : 'Unpublished' }}</a>
                                        </td>
                                        <td>
                                            @can('edit-notification')
                                            <a href="" data-blog-category-id="{{ $popupNotification->id }}" class="btn btn-sm btn-warning blog-category-edit-btn" title="Edit Blog Category">
                                                <i class="fa-solid fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('delete-notification')
                                            <form class="d-inline" action="{{ route('popup-notifications.destroy', $popupNotification->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-danger data-delete-form" title="Delete Blog Category">
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

    <div class="modal fade modal-div" id="blogCategoryModal" data-modal-parent="blogCategoryModal" data-bs-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" id="">
                <form id="courseSectionForm" action="{{ route('popup-notifications.store') }}" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="">Create Popup Notification</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="card card-body">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="">Title</label>
                                    <input type="text" class="form-control" name="title" placeholder="Title" title="Title" />
                                </div>
                                <div class="col-sm-6 select2-div">
                                    <label for="">Popup Type</label> <br>
                                    <select name="popup_type" class="select2 form-control" id="popupType" data-placeholder="Popup Type">
                                        <option value=""></option>
                                        <option value="course">course</option>
                                        <option value="book">book</option>
                                        <option value="external-link">external-link</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Action Button Link</label>
                                    <input type="text" class="form-control" name="action_btn_text" placeholder="Action Button Link" title="Action Button Link" />
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Active Button Link</label>
                                    <input type="text" class="form-control" name="active_btn_link" placeholder="Action Button Link" title="Action Button Link" />
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-6">
                                    @csrf
                                     <label for="">Image <span class="text-red">(400 X 400 + WEBP)</span> </label>
                                    <input type="file" class="form-control" id="image" name="image" placeholder="Image" title="Image" />
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <img src="" id="imagePreview" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <label for="">Description</label>
                                    <textarea name="description" id="summernote" class="form-control" cols="30" rows="10"></textarea>
                                </div>
                                <div class="col-sm-6 mt-2">
                                    <label for="">Status</label> <br>
                                    <div class="material-switch">
                                        <input id="someSwitchOptionInfo" name="status" type="checkbox" checked="">
                                        <label for="someSwitchOptionInfo" class="label-info"></label>
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
    @include('backend.includes.assets.plugin-files.editor')
    {{--    store course--}}
    <script>
        $(document).on('click', '.blog-category-modal-btn', function () {
            event.preventDefault();
            // resetInputFields();
            if ($('input[name="_method"]').length)
            {
                $('input[name="_method"]').remove();
            }
            $('#courseSectionForm').attr('action', "{{ route('popup-notifications.store') }}");
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
                url: base_url+"popup-notifications/"+courseId+"/edit",
                method: "GET",
                dataType: "JSON",
                success: function (data) {
                    // console.log(data.note);
                    $('input[name="title"]').val(data.name);
                    $('input[name="action_btn_text"]').val(data.action_btn_text);
                    $('input[name="active_btn_link"]').val(data.active_btn_link);
                    $('#summernote').summernote('destroy');
                    $('textarea[name="description"]').html(data.description);
                    $("#summernote").summernote({height:70,inheritPlaceholder: true})
                    $('#imagePreview').attr('src', data.image).css({height: '150px'});
                    $('#popupType option').each(function () {
                        if (data.popup_type == $(this).val())
                        {
                            $(this).attr('selected', true);
                        }
                    })
                    $(".select2").select2({
                        minimumResultsForSearch: "",
                        width: "100%"
                    })
                    if (data.status == 1)
                    {
                        $('input[name="status"]').attr('checked', true);
                    } else {
                        $('input[name="status"]').attr('checked', false);
                    }
                    $('#courseSectionForm').attr('action', base_url+"popup-notifications/"+data.id).append('<input type="hidden" name="_method" value="put">');
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
