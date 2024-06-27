@extends('backend.master')

@section('title', 'Courses')

@section('body')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">Courses</h4>
                    @can('create-course')
                        <button type="button" data-bs-toggle="modal" data-bs-target="#coursesModal" class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4 open-modal"><i class="fa-solid fa-circle-plus"></i></button>
                    @endcan
                    <button type="button" data-bs-toggle="modal" data-bs-target="#jsonImport" class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 m-r-50 "><i class="fa-solid fa-arrow-alt-circle-up"></i></button>
                </div>
                <div class="card-body">
                    <form action="" method="get">
                        {{--                    @csrf--}}
                        <div class="row pb-5 pt-3">
                            <div class="col-md-6 mx-auto card card-body">
                                <div class="row" >
                                    <div class="col select2-div">
                                        <label for="">Course Category </label>
                                        <select name="category_id" class="form-control select2" id="courseCategories" data-placeholder="Select Course Categories" >
                                            @if(isset($courseCategories))
                                                @foreach($courseCategories as $courseCategory)
                                                    <option value="{{ $courseCategory->id }}" {{ isset($_GET['category_id']) && $_GET['category_id'] == $courseCategory->id ? 'selected' : '' }} >{{ $courseCategory->name }}</option>
                                                    @if(!empty($courseCategory))
                                                        @if(count($courseCategory->courseCategories) > 0)
                                                            @include('backend.course-management.course.courses.course-category-loop-type-two', ['courseCategory' => $courseCategory, 'child' => 1])
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>


                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-success ms-4 " style="margin-top: 18px" >Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <table class="table" id="{{--file-datatable--}}">
                        <thead>
                            <tr class="text-center">
                                <th>SL No</th>
                                <th>Course Title</th>
                                <th>Links</th>
                                <th>Price</th>
                                <th>Duration</th>
                                <th>Discount</th>
                                {{-- <th>Partial Payment</th> --}}
                                <th>Extra Features</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody  class="text-center">
                            @if(isset($courses))
                                @foreach($courses as $course)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="mt-3">
{{--                                                <a href="{{ route('front.course-details', ['slug' => $course->slug]) }}" target="_blank">--}}
                                                <a href="{{ route('course-sections.index', ['course_id' => $course->id]) }}" >
                                                    <div class="text-center">
                                                        <img src="{{ asset(file_exists_obs($course->banner) ? $course->banner : 'frontend/logo/biddabari-card-logo.jpg') }}" alt="" style="height: 100px;" />
                                                    </div>
                                                    {{--                                            <br>--}}
                                                    <div class="text-center mt-2">{{ $course->title }}</div>
                                                </a>
                                            </div>
                                        </td>
                                        <td class="nav flex-column course-links">
                                            @can('assign-course-teacher-page')
                                                <a href="{{ route('assign-teacher-to-course', ['course_id' => $course->id, 'title' => str_replace(' ', '-', $course->title)]) }}" class="nav-link fw-bold" title="Course Assigned Teachers">Teachers</a>
                                            @endcan
                                            @can('assign-course-student-page')
                                                <a href="{{ route('assign-student-to-course', ['course_id' => $course->id, 'title' => str_replace(' ', '-', $course->title)]) }}" class="nav-link fw-bold" title="Course Assigned Students">Students</a>
                                            @endcan
                                            @can('manage-course-routine')
                                                <a href="{{ route('course-routines.index', ['course_id' => $course->id, 'title' => str_replace(' ', '-', $course->title)]) }}" class="nav-link fw-bold" title="Course Routines">Routines</a>
                                            @endcan
                                            @can('manage-course-coupon')
                                                <a href="{{ route('course-coupons.index', ['course_id' => $course->id, 'title' => str_replace(' ', '-', $course->title)]) }}" class="nav-link fw-bold" title="Course Coupons">Coupons</a>
                                            @endcan
                                            @can('manage-course-section')
                                                <a href="{{ route('course-sections.index', ['course_id' => $course->id, 'title' => str_replace(' ', '-', $course->title)]) }}" class="nav-link fw-bold" title="Course Content">Content</a>
                                            @endcan
                                        </td>
                                        <td> ৳ {{ $course->price }}</td>
                                        <td>{{ $course->duration_in_month }} Months</td>
                                        <td>
                                            ৳ {{ $course->discount_type == 1 ? $course->discount_amount : ($course->price * $course->discount_amount)/100 }}
                                        </td>
                                        {{-- <td> ৳ {{ $course->partial_payment }}</td> --}}
                                        <td>
                                            <a href="javascript:void(0)" class="badge badge-sm badge-orange-light text-dark">{{ $course->status == 1 ? 'Published' : 'Unpublished' }}</a>
                                            <br>
                                            <a href="javascript:void(0)" class="badge badge-sm badge-success-light text-dark">{{ $course->is_paid == 1 ? 'Paid' : 'Free' }}</a>
                                            <br>
                                            <a href="javascript:void(0)" class="badge badge-sm badge-default text-dark">{{ $course->is_featured == 1 ? 'Featured' : 'Not Featured' }}</a>
                                        </td>
                                        <td class="">
                                            <a href="{{ route('export-course-json', ['model_id' => $course->id, 'model' => 'course']) }}" data-course-id="{{ $course->id }}"  class="btn btn-sm mt-1 btn-secondary " title="Export course to JSON">
                                                <i class="fa-solid fa-arrow-alt-circle-down"></i>
                                            </a>
                                            <br>
                                            @can('show-course')
                                                <a href="" data-course-id="{{ $course->id }}"  class="btn btn-sm mt-1 btn-primary show-btn" title="View Course">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                            @endcan
                                            <br>
                                            @can('edit-course')
                                                <a href="" data-course-id="{{ $course->id }}" class="btn btn-sm mt-1 btn-warning edit-btn" title="Edit Course">
                                                    <i class="fa-solid fa-edit"></i>
                                                </a>
                                            @endcan
                                            <br>
                                            @can('delete-course')
                                                <form class="d-inline" action="{{ route('courses.destroy', $course->id) }}" method="post" >
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-sm mt-1 btn-danger data-delete-form" title="Delete Course">
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
                    <div>
                        {{ $courses->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-div" id="coursesModal" data-bs-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" id="modalForm">
                @include('backend.course-management.course.courses.form')
            </div>
        </div>
    </div>
    <div class="modal fade modal-div" id="jsonImport" data-bs-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" id="">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Courses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('import-model-json', ['model' => 'course']) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="">Input Json</label>
                            <div>
                                <input type="file" name="json_file" class="" accept="application/JSON" />
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-success">Import</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <!-- DragNDrop Css -->
{{--    <link href="{{ asset('/') }}backend/assets/css/dragNdrop.css" rel="stylesheet" type="text/css" />--}}
    <style>
        .course-links a:hover {
            color: darkorange!important;
        }
        input[switch]+label {
            margin-bottom: 0px;
        }
        .datetimepicker {z-index: 100009!important;}
    </style>
@endpush

@push('script')
    @include('backend.includes.assets.plugin-files.datatable')
    @include('backend.includes.assets.plugin-files.editor')
   <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>

   <script type="text/javascript">
    //<![CDATA[

        CKEDITOR.replace( 'ck',
            {
                fullPage : true,
                uiColor : '#efe8ce'
            });
    //]]>
    </script>


{{--    @include('backend.includes.assets.plugin-files.date-time-picker')--}}
    <script src="{{ asset('/') }}backend/assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js"></script>
    <script src="{{ asset('backend/assets/js/page-js/manage-course.js') }}"></script>
    <script>
        $(document).on('blur', '#courseTitle', function () {
            var courseTitle = $(this).val();
            $('#courseSlug').val(courseTitle.replace(/ /g, "-"));
        })
    </script>
@endpush
