@extends('backend.master')

@section('title', 'Batch Exams Teachers')

@section('body')
    <div class="row py-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">{{ $batchExam->title }} Trainers</h4>
                    <a href="{{ route('batch-exams.index') }}" title="Back to Batch Exams" class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 m-r-50"><i class="fa-solid fa-arrow-left"></i></a>
                    @can('assign-batch-exam-teacher')
                        <button type="button" data-bs-toggle="modal" data-bs-target="#coursesModal" class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4"><i class="fa-solid fa-circle-plus"></i></button>
                    @endcan
                </div>
                <div class="card-body">
                    <table class="table" id="file-datatable">
                        <thead>
                        <tr>
                            {{--                                <th>#</th>--}}
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
{{--                            <th>Commission</th>--}}
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($batchExam))
                            @foreach($batchExam->teachers as $teacher)
                                <tr>
                                    <td>{{ $teacher->user->name }}</td>
                                    <td>{{ $teacher->user->email }}</td>
                                    <td>{{ $teacher->user->mobile }}</td>
{{--                                    <td></td>--}}
                                    <td>{{ $teacher->status == 1 ? 'Active' : 'Inactive' }}</td>
                                    <td>
{{--                                        <a href="" data-course-id="{{ $batchExam->id }}" class="btn btn-sm btn-warning edit-btn" title="Edit Course">--}}
{{--                                            <i class="mdi mdi-circle-edit-outline"></i>--}}
{{--                                        </a>--}}
                                        @can('detach-batch-exam-teacher')
                                            <form class="d-inline" action="{{ route('detach-batch-exam-teacher', $batchExam->id) }}" method="post" onsubmit="return confirm('Are you sure to Detach this trainer from this Batch Exam?')">
                                                @csrf
                                                <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                                                <button type="submit" class="btn btn-sm btn-danger" title="Detach Student from this Batch Exam?">
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
    <div class="modal fade modal-div" id="coursesModal" data-modal-parent="coursesModal" >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" id="modalForm">
                <form action="{{ route('assign-batch-exam-teacher', ['batch_exam_id' => $batchExam->id]) }}" method="post" enctype="multipart/form-data" id="coursesForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Assign Trainers</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    {{--                    <input type="hidden" name="category_id" >--}}
                    <div class="modal-body">
                        <div class="card card-body">
                            <div class="row">
                                <div class="col-md-12 mt-2 select2-div">
                                    <label for="">Assign Trainers</label>
                                    <select name="teachers[]" class="form-control select2" required multiple data-placeholder="Assign Trainers" >
                                        <option label="Assign Trainers"></option>
                                        @if(isset($teachers))
                                            @foreach($teachers as $teacher)
                                                <option value="{{ $teacher->id }}" @foreach($batchExam->teachers as $selectedTeacher) @if($selectedTeacher->id == $teacher->id) selected @endif @endforeach >{{ $teacher->user->mobile }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="text-danger" id="name">{{ $errors->has('teachers') ? $errors->first('teachers') : '' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
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
    {{--    <link href="{{ asset('/') }}backend/assets/css/dragNdrop.css" rel="stylesheet" type="text/css" />--}}
    <style>
        input[switch]+label {
            margin-bottom: 0px;
        }
    </style>
@endpush

@push('script')
@include('backend.includes.assets.plugin-files.datatable')


    {{-- update course category--}}
{{--    <script>--}}
{{--        $(document).on('click', '.update-btn', function () {--}}
{{--            event.preventDefault();--}}
{{--            var formData = $('#courseCategoryForm').serialize();--}}
{{--            $.ajax({--}}
{{--                url: $('#courseCategoryForm').attr('action'),--}}
{{--                method: "PUT",--}}
{{--                data: formData,--}}
{{--                dataType: "JSON",--}}
{{--                // async: false,--}}
{{--                // cache: false,--}}
{{--                contentType: false,--}}
{{--                processData: false,--}}
{{--                // enctype: 'multipart/form-data',--}}
{{--                success: function (message) {--}}
{{--                    // console.log(formData);--}}
{{--                    toastr.success(message);--}}
{{--                    $('.update-btn').addClass('submit-btn').removeClass('update-btn');--}}
{{--                    $('#courseCategoryForm').attr('action', '');--}}
{{--                    $('#courseCategoryModal').modal('hide');--}}
{{--                    window.location.reload();--}}
{{--                    resetInputFields();--}}
{{--                }--}}
{{--            })--}}
{{--        })--}}
{{--    </script>--}}
{{--    <!-- DragNDrop js -->--}}

{{--    --}}{{--    <script src="{{ asset('/') }}backend/assets/js/dragNdrop/init.js"></script>--}}


{{--    <script>--}}
{{--        $(document).ready(function() {--}}
{{--            $('#categoryImage').change(function() {--}}
{{--                var imgURL = URL.createObjectURL(event.target.files[0]);--}}
{{--                $('#imagePreview').attr('src', imgURL).css({--}}
{{--                    height: 150+'px',--}}
{{--                    width: 150+'px',--}}
{{--                    marginTop: '5px'--}}
{{--                });--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
@endpush
