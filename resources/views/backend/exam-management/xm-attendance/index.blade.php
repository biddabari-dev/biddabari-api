@extends('backend.master')

@section('title', 'Student Exam Attendance')

@section('body')
    <div class="row py-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">Student Exam Attendance</h4>
                </div>
                <div class="card-body">

                    <div class="row">
                        <ul class="nav nav-pills mb-3 col-4 mx-auto" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#present" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Present Students</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#absent" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Absent Students</button>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content mt-4" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="present" role="tabpanel" aria-labelledby="pills-home-tab">
                            <table class="table" id="">
                                <thead>
                                <tr>
                                    <td>#</td>
                                    <th>Student NAME</th>
                                    <th>Mobile</th>
                                    <th>Course Name</th>
                                    <th>Exam Title</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($presentStudents as $key => $presentStudent)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $presentStudent->name }}</td>
                                        <td>{{ $presentStudent->mobile ?? 0 }}</td>
                                        <td>{{ $examFrom->title }}</td>
                                        <td>{{ $content->title }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="absent" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <table class="table" id="file-datatable" style="width: 100%!important;">
                                <thead>
                                <tr>
                                    <td>#</td>
                                    <th>Student NAME</th>
                                    <th>Mobile</th>
                                    <th>Course Name</th>
                                    <th>Exam Title</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($absentStudents as $key => $absentStudent)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $absentStudent->name }}</td>
                                        <td>{{ $absentStudent->mobile ?? 0 }}</td>
                                        <td>{{ $examFrom->title }}</td>
                                        <td>{{ $content->title }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <!-- DragNDrop Css -->
    <style>
        #imagePreview {
            display: none;
        }
        #pills-tab li button { color: orangered; }
        #pills-tab li button:hover { color: orangered!important; background-color: lightgreen}
    </style>
@endpush

@push('script')
    @include('backend.includes.assets.plugin-files.datatable')
@endpush
