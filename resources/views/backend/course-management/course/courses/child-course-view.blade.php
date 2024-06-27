@if(!empty($course->courses))
    <ol class="dd-list list-group">
        @foreach($course->courses as $kk => $subCourse)
            <li class="dd-item list-group-item" data-id="{{ $subCourse['id'] }}" >
                <div class="dd-handle" >
                    <div class="row">
                        <div class="col-md-9">
                            <div class=" ps-3">
                                <img src="{{ asset($subCourse->banner) }}" alt="" style="height: 100px;" />
                            </div>
                            <div class=" ps-3 mt-2">{{ $subCourse->title }}</div>
                        </div>

                        <div class="col-md-3">
                            <p>৳ {{ $subCourse->price }}</p>
                        </div>
                    </div>
                </div>
                <div class="dd-option-handle">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="nav flex-column course-links">
                                @can('assign-course-teacher-page')
                                    <a href="{{ route('assign-teacher-to-course', ['course_id' => $subCourse->id, 'title' => str_replace(' ', '-', $subCourse->title)]) }}" class="btn btn-sm fw-bold" title="Course Assigned Teachers">Teachers</a>
                                @endcan
                                @can('assign-course-student-page')
                                    <a href="{{ route('assign-student-to-course', ['course_id' => $subCourse->id, 'title' => str_replace(' ', '-', $subCourse->title)]) }}" class="btn btn-sm fw-bold" title="Course Assigned Students">Students</a>
                                @endcan
                                @can('manage-course-routine')
                                    <a href="{{ route('course-routines.index', ['course_id' => $subCourse->id, 'title' => str_replace(' ', '-', $subCourse->title)]) }}" class="btn btn-sm fw-bold" title="Course Routines">Routines</a>
                                @endcan
                                @can('manage-course-coupon')
                                    <a href="{{ route('course-coupons.index', ['course_id' => $subCourse->id, 'title' => str_replace(' ', '-', $subCourse->title)]) }}" class="btn btn-sm fw-bold" title="Course Coupons">Coupons</a>
                                @endcan
                                @can('manage-course-section')
                                    <a href="{{ route('course-sections.index', ['course_id' => $subCourse->id, 'title' => str_replace(' ', '-', $subCourse->title)]) }}" class="btn btn-sm fw-bold" title="Course Content">Content</a>
                                @endcan
                            </div>
                        </div>
                        <div class="col-md-4">
                            <a href="javascript:void(0)" class="badge badge-sm badge-orange-light text-dark">{{ $subCourse->status == 1 ? 'Published' : 'Unpublished' }}</a>
                            <br>
                            <a href="javascript:void(0)" class="badge badge-sm badge-success-light text-dark">{{ $subCourse->is_paid == 1 ? 'Paid' : 'Free' }}</a>
                            <br>
                            <a href="javascript:void(0)" class="badge badge-sm badge-default text-dark">{{ $subCourse->is_featured == 1 ? 'Featured' : 'Not Featured' }}</a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('export-course-json', ['model_id' => $subCourse->id, 'model' => 'course']) }}" data-course-id="{{ $subCourse->id }}"  class="btn btn-sm mt-1 btn-secondary " title="Export course to JSON">
                                <i class="fa-solid fa-arrow-alt-circle-down"></i>
                            </a>
                            <br>
                            @can('show-course')
                                <a href="" data-course-id="{{ $subCourse->id }}"  class="btn btn-sm mt-1 btn-primary show-btn" title="View Course">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            @endcan
                            <br>
                            @can('edit-course')
                                <a href="" data-course-id="{{ $subCourse->id }}" class="btn btn-sm mt-1 btn-warning edit-btn" title="Edit Course">
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                            @endcan
                            <br>
                            @can('delete-course')
                                <form class="d-inline" action="{{ route('courses.destroy', $subCourse->id) }}" method="post" >
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-sm mt-1 btn-danger data-delete-form" title="Delete Course">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
                @if(!empty($subCourse->courses))
                    @include('backend.course-management.course.courses.child-course-view', [ 'course' => $subCourse])
                @endif
            </li>
        @endforeach
    </ol>
@endif
