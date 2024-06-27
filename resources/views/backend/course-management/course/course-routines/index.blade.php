@extends('backend.master')

@section('title', 'Course Routines')

@section('body')
    <div class="row py-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">Course Routines</h4>
                    <a href="{{ route('courses.index') }}" title="Back to Courses" class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 m-r-50"><i class="fa-solid fa-arrow-left"></i></a>
                    @can('create-course-routine')
                        <button type="button" data-bs-toggle="modal" data-bs-target="#coursesModal" class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4"><i class="fa-solid fa-circle-plus"></i></button>
                    @endcan
                </div>
                <div class="card-body">
                    <table class="table" id="file-datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Content Name</th>
                                <th>Date</th>
                                <th>Day</th>
                                <th>Time</th>
                                <th>Fack Status</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($courseRoutines))
                                @foreach($courseRoutines as $courseRoutine)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $courseRoutine->content_name }}</td>
                                        <td>{{ showDate($courseRoutine->date_time) }}</td>
                                        <td>{{ $courseRoutine->day }}</td>
                                        <td>{{ showTime($courseRoutine->date_time) }}</td>
                                        <td>
                                            <a href="javascript:void(0)" class="nav-link">{{ $courseRoutine->is_fack == 1 ? 'Yes' : 'No' }}</a>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" class="nav-link">{{ $courseRoutine->status == 1 ? 'Published' : 'Unpublished' }}</a>
                                        </td>
                                        <td>
                                            @can('edit-course-routine')
                                            <a href="" data-course-routine-id="{{ $courseRoutine->id }}" class="btn btn-sm btn-warning edit-btn" title="Edit Course Routine">
                                                <i class="fa-solid fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('delete-course-routine')
                                                <form class="d-inline" action="{{ route('course-routines.destroy', $courseRoutine->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-sm btn-danger data-delete-form" title="Delete Course Routine">
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
                @include('backend.course-management.course.course-routines.form')
            </div>
        </div>
    </div>
@endsection
@push('style')
{{--    date time picker--}}
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('/') }}backend/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.min.css">


    <!-- DragNDrop Css -->
{{--    <link href="{{ asset('/') }}backend/assets/css/dragNdrop.css" rel="stylesheet" type="text/css" />--}}
<style>
    .datetimepicker {z-index: 100009!important;}
    input[switch]+label {
        margin-bottom: 0px;
    }

</style>
@endpush

@push('script')
{{--    datatables js--}}
@include('backend.includes.assets.plugin-files.datatable')
{{--@include('backend.includes.assets.plugin-files.date-time-picker')--}}
@if($errors->any())
    <script>
        $(function () {
            $('#coursesModal').modal('show');
        })
    </script>
@endif
{{--datetime picker--}}
{{--    <script src="{{ asset('/') }}backend/assets/plugins/bootstrap-material-datetimepicker/js/moment.min.js"></script>--}}
{{--    <script src="{{ asset('/') }}backend/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.min.js"></script>--}}
    <script src="{{ asset('/') }}backend/assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js"></script>
    <script>
        $(function () {
            // $('#dateTime').bootstrapMaterialDatePicker({
            //     format: 'YYYY-MM-DD HH:mm'
            // });
            $('input[data-dtp="dtp_Nufud"]').val(currentDateTime);
            $("#dateTime").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0})
        });
    </script>

    {{--    store course--}}
    <script>

    </script>

{{--    edit course category--}}
    <script>
        $(document).on('click', '.edit-btn', function () {
            event.preventDefault();
            var courseId = $(this).attr('data-course-routine-id');
            $.ajax({
                url: base_url+"course-routines/"+courseId+"/edit",
                method: "GET",
                // dataType: "JSON",
                success: function (data) {
                    // console.log(data);
                    $('#modalForm').empty().append(data);

                    // $('#dateTime').bootstrapMaterialDatePicker({
                    //     format: 'YYYY-MM-DD HH:mm'
                    // });
                    $("#dateTime").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0})

                    $('.select2').select2({
                        placeholder: $(this).attr('data-placeholder'),
                        // dropdownParent: $('#'+$('.modal-fix').attr('data-modal-parent')),
                        // dropdownParent: $('.modal').attr('data-modal-parent'),
                    });


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
            $('#categoryImage').change(function() {
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
