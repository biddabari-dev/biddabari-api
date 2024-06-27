@extends('backend.master')

@section('title', 'Batch Exam Students')

@section('body')
    <div class="row py-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">{{ $batchExam->title }} Students</h4>
                    <a href="{{ route('batch-exams.index') }}" title="Back to Batch Exams" class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 m-r-50"><i class="fa-solid fa-arrow-left"></i></a>
                    @can('assign-batch-exam-student')
                        <button type="button" data-bs-toggle="modal" data-bs-target="#coursesModal" class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4"><i class="fa-solid fa-circle-plus"></i></button>
                        {{--                        <button type="button" data-bs-toggle="modal" data-bs-target="#transferCourseStudentsModal" class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 m-r-50"><i class="fe fe-users"></i></button>--}}
                    @endcan
                </div>
                <div class="card-body">
                    <table class="table" id="">
                        <thead>
                        <tr>
{{--                            <th>#</th>--}}
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($batchExam))
                            @foreach($students as $key => $student)
                                {{--                                @if($key <= 1000)--}}
                                <tr>
                                    <td>{{ $student['students'][0]['first_name'] }}</td>
                                    <td>{{ $student['students'][0]['email'] }}</td>
                                    <td>{{ $student['students'][0]['mobile'] }}</td>
                                    <td>{{ $student['status'] == 1 ? 'Active' : 'Inactive' }}</td>
                                    <td>
                                        {{--                                            <a href="" data-course-id="{{ $course->id }}" class="btn btn-sm btn-warning edit-btn" title="Edit Course">--}}
                                        {{--                                                <i class="mdi mdi-circle-edit-outline"></i>--}}
                                        {{--                                            </a>--}}
                                        @can('detach-course-student')
                                            <form class="d-inline" action="{{ route('detach-batch-exam-student', $batchExam->id) }}" method="post" onsubmit="return confirm('Are you sure to Detach this Student from this course?')">
                                                @csrf
                                                <input type="hidden" name="student_id" value="{{ $student['student_id'] }}">
                                                <button type="submit" class="btn btn-sm btn-danger data-delete-form" title="Detach Student from this Course?">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                                {{--                                @else--}}
                                {{--                                    @break--}}
                                {{--                                @endif--}}
                            @endforeach

{{--                            @foreach($batchExam->students as $student)--}}
{{--                                <tr>--}}
{{--                                    <td>{{ $loop->iteration }}</td>--}}
{{--                                    <td>{{ $student->user->name }}</td>--}}
{{--                                    <td>{{ $student->user->email }}</td>--}}
{{--                                    <td>{{ $student->user->mobile }}</td>--}}
{{--                                    <td>{{ $student->status == 1 ? 'Active' : 'Inactive' }}</td>--}}
{{--                                    <td>--}}
{{--                                        <a href="" data-course-id="{{ $batchExam->id }}" class="btn btn-sm btn-warning edit-btn" title="Edit Course">--}}
{{--                                            <i class="mdi mdi-circle-edit-outline"></i>--}}
{{--                                        </a>--}}
{{--                                        @can('detach-batch-exam-student')--}}
{{--                                            <form class="d-inline" action="{{ route('detach-batch-exam-student', $batchExam->id) }}" method="post" onsubmit="return confirm('Are you sure to Detach this Student from this Batch Exam?')">                                            @csrf--}}
{{--                                                <input type="hidden" name="student_id" value="{{ $student->id }}">--}}
{{--                                                <button type="submit" class="btn btn-sm btn-danger" title="Detach Student from this Batch Exam?">--}}
{{--                                                    <i class="fa-solid fa-trash"></i>--}}
{{--                                                </button>--}}
{{--                                            </form>--}}
{{--                                        @endcan--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
                        @endif
                        </tbody>
                    </table>

                    {{ $students->links() }}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-div" id="coursesModal" data-modal-parent="coursesModal" >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" id="modalForm">
                <form action="{{ route('assign-batch-exam-new-student', ['batch_exam_id' => $batchExam->id]) }}" method="post" enctype="multipart/form-data" id="coursesForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Assign Student</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    {{--                    <input type="hidden" name="category_id" >--}}
                    <div class="modal-body">
                        <div class="card card-body">
                            <div class="row">
                                <div class="col-md-6 mt-2 select2-div">
                                    <label for="">Assign Students</label>
                                    <select name="student_id" required class="form-control js-example-basic-single select2-style1"  data-placeholder="Assign Student" >
                                        <option label="Assign Students"></option>
{{--                                        @if(isset($students))--}}
{{--                                            @foreach($students as $student)--}}
{{--                                                <option value="{{ $student->id }}" >{{ $student->user->mobile }}</option>--}}
{{--                                            @endforeach--}}
{{--                                        @endif--}}
                                    </select>
                                    <span class="text-danger" id="student_id">{{ $errors->has('student_id') ? $errors->first('student_id') : '' }}</span>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label for="">Payment Amount</label>
                                    <input type="number" name="paid_amount" class="form-control" placeholder="Payment Amount">
                                    <span class="text-danger" id="paid_amount">{{ $errors->has('paid_amount') ? $errors->first('paid_amount') : '' }}</span>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12 mt-2">
                                    <label for="">Select Package</label>
                                    <div class="row mt-3">
                                        @foreach($batchExam->batchExamSubscriptions as $key => $batchExamSubscription)
                                            <div class="col-md-4">
                                                <div class="float-start mr-2">
                                                    <input type="radio" name="batch_exam_subscription_id" {{ $key == 0 ? 'checked' : '' }} value="{{ $batchExamSubscription->id }}" class="mt-4" />
                                                </div>
                                                <div class="float-start ms-1">
                                                    <p class="m-0">{{ $batchExamSubscription->package_title }}</p>
                                                    <p class="m-0">price: {{ $batchExamSubscription->price }}</p>
                                                    <p class="m-0">Duration: {{ $batchExamSubscription->package_duration_in_days }} Days</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <span class="text-danger" id="total_amount">{{ $errors->has('total_amount') ? $errors->first('total_amount') : '' }}</span>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6 mt-2 select2-div">
                                    <label for="">Vendor</label>
                                    <select name="vendor" id="" class="form-control select2">
                                        <option value="bkash">Bkash</option>
                                        <option value="nagad">Nagad</option>
                                        <option value="rocket">Rocket</option>
                                    </select>
                                    <span class="text-danger" id="vendor">{{ $errors->has('vendor') ? $errors->first('vendor') : '' }}</span>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label for="">Paid To</label>
                                    <input type="text" class="form-control" name="paid_to" placeholder="Paid To" />
                                    <span class="text-danger" id="paid_to">{{ $errors->has('paid_to') ? $errors->first('paid_to') : '' }}</span>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label for="">Paid From</label>
                                    <input type="text" class="form-control" name="paid_from" placeholder="Paid From" />
                                    <span class="text-danger" id="paid_from">{{ $errors->has('paid_from') ? $errors->first('paid_from') : '' }}</span>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label for="">Txt Id</label>
                                    <input type="text" class="form-control" name="txt_id" placeholder="Txt Id" />
                                    <span class="text-danger" id="txt_id">{{ $errors->has('txt_id') ? $errors->first('txt_id') : '' }}</span>
                                </div>
                                <div class="col-sm-6 mt-2 select2-div">
                                    <label for="paymentStatus">Payment Status</label>
                                    <select name="payment_status" class="form-control select2" id="paymentStatus" data-placeholder="Set Payment Status">
                                        <option value=""></option>
                                        <option value="pending">Pending</option>
                                        <option value="partial">Partial</option>
                                        <option value="complete">Complete</option>
                                    </select>
                                    <span class="text-danger" id="payment_status">{{ $errors->has('payment_status') ? $errors->first('payment_status') : '' }}</span>
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

{{--    not using this modal--}}
    <div class="modal fade modal-div" id="transferCourseStudentsModal" data-modal-parent="coursesModal" >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" id="modalForm">
                <form action="{{ route('assign-batch-exam-student', ['batch_exam_id' => $batchExam->id]) }}" method="post" enctype="multipart/form-data" id="coursesForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Transfer Students</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    {{--                    <input type="hidden" name="category_id" >--}}
                    <div class="modal-body">
                        <div class="card card-body">
                            <div class="row">
                                <div class="col-md-6 mt-2 select2-div">
                                    <label for="">Transfer From</label>
                                    <select name="batch_exam_id" required class="form-control select2"  data-placeholder="Select Course" >
                                        <option label="Select Course"></option>
                                        @if(isset($students))
                                            @foreach($batchExams as $publishedBatchExam)
                                                <option value="{{ $publishedBatchExam->id }}" >{{ $publishedBatchExam->title }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="text-danger" id="course_id">{{ $errors->has('course_id') ? $errors->first('course_id') : '' }}</span>
                                </div>
                                <div class="col-md-6 mt-2 select2-div">
                                    <label for="">Assign Students</label>
                                    <select name="students[]" required multiple class="form-control select2"  data-placeholder="Assign Student" >
                                        <option label="Assign Students"></option>
                                        @if(isset($students))
{{--                                            @foreach($students as $student)--}}
{{--                                                <option value="{{ $student->id }}" --}}{{--@foreach($course->students as $selectedStudent) @if($student->id == $selectedStudent->id) selected @endif @endforeach--}}{{-- >{{ $student->user->mobile }}</option>--}}
{{--                                            @endforeach--}}
                                        @endif
                                    </select>
                                    <span class="text-danger" id="students">{{ $errors->has('students') ? $errors->first('students') : '' }}</span>
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
@if($errors->any())
    <script>
        $(function () {
            $('#coursesModal').modal('show');
        })
    </script>
@endif

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            dropdownParent: $('#coursesModal'),
            ajax: {
                url: "{{ route('search-student-ajax') }}",
                datatype: "json",
                delay: 250,
                data: function (params) {
                    return {mobile:params.term}
                },
                processResults: function (data) {
                    // return {
                    //     results: data.items
                    // }


                    var formattedData = data.map(function (item) {
                        return { id: item.id, text: item.mobile, image: item.profile_photo_url };
                    });

                    return {
                        results: formattedData
                    };
                }
            },
            templateResult: formatResult,
            templateSelection: formatResult,
        });
        function formatResult(result) {
            if (!result.id) {
                return result.text;
            }

            var $result = $(
                '<span> ' + result.text + '</span>'
            );

            return $result;
        }
    });
</script>

@endpush
