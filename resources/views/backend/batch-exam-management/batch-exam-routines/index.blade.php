@extends('backend.master')

@section('title', 'Batch Exam Routines')

@section('body')
    <div class="row py-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">Batch Exam Routines</h4>
                    <a href="{{ route('batch-exams.index') }}" title="Back to Batch Exams" class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 m-r-50"><i class="fa-solid fa-arrow-left"></i></a>
                    @can('create-batch-exam-routine')
                        <button type="button" data-bs-toggle="modal" data-bs-target="#coursesModal" class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4"><i class="fa-solid fa-circle-plus"></i></button>
                    @endcan
                </div>
                <div class="card-body">
                    <table class="table" id="file-datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Day</th>
                                <th>Time</th>
                                <th>Fack Status</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($batchExamRoutines))
                                @foreach($batchExamRoutines as $batchExamRoutine)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ showDate($batchExamRoutine->date_time) }}</td>
                                        <td>{{ $batchExamRoutine->day }}</td>
                                        <td>{{ showTime($batchExamRoutine->date_time) }}</td>
                                        <td>
                                            <a href="javascript:void(0)" class="nav-link">{{ $batchExamRoutine->is_fack == 1 ? 'Yes' : 'No' }}</a>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" class="nav-link">{{ $batchExamRoutine->status == 1 ? 'Published' : 'Unpublished' }}</a>
                                        </td>
                                        <td>
                                            @can('edit-batch-exam-routine')
                                            <a href="" data-course-routine-id="{{ $batchExamRoutine->id }}" class="btn btn-sm btn-warning edit-btn" title="Edit Batch Exam Routine">
                                                <i class="fa-solid fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('delete-batch-exam-routine')
                                            <form class="d-inline" action="{{ route('batch-exam-routines.destroy', $batchExamRoutine->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-danger data-delete-form" title="Delete Batch Exam Routine">
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
                @include('backend.batch-exam-management.batch-exam-routines.form')
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
        input[switch]+label {
            margin-bottom: 0px;
        }
        .datetimepicker {z-index: 100009!important;}
    </style>
@endpush

@push('script')
{{--    datatables js--}}
@include('backend.includes.assets.plugin-files.datatable')
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
            //     format: 'YYYY-MM-DD HH:mm',
            //     minDate : new Date(),
            // });
            $("#dateTime").val(currentDateTime);
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
                url: base_url+"batch-exam-routines/"+courseId+"/edit",
                method: "GET",
                // dataType: "JSON",
                success: function (data) {
                    // console.log(data);
                    $('#modalForm').empty().append(data);

                    // $('#dateTime').bootstrapMaterialDatePicker({
                    //     format: 'YYYY-MM-DD HH:mm',
                    //     minDate : new Date(),
                    // });
                    $("#dateTime").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});

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
