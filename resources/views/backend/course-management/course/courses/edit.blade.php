<form action="{{ isset($course) ? route('courses.update', $course->id) : route('courses.store') }}" method="post" enctype="multipart/form-data" id="coursesForm">
    @if(isset($course))
        <input type="hidden" name="_method" id="formMethod" value="put" />

    @endif
        <input type="hidden" name="_token" id="formToken" value="{{ csrf_token() }}" />
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update a Course</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
    </div>
    {{--                    <input type="hidden" name="category_id" >--}}
    <div class="modal-body">
        <div class="card card-body">
            <div class="row mt-2">
                <div class="col-md-7 mt-2">
                    <label for="courseTitle">Course Title</label>
                    <input type="text" name="title" value="{{ isset($course) ? $course->title : '' }}" id="courseTitle" class="form-control" placeholder="Course Title" />
                    <span class="text-danger" id="title"></span>
                </div>
                <div class="col-md-5 mt-2 select2-div">
                    <label for="">Select Course Categories</label>
                    <input type="text" class="form-control" id="questionTopicInputField" value="@foreach($course->courseCategories as $courseCategoryName){{ $courseCategoryName->name.',' }}@endforeach" />
                    @php
                        $string = '';
                        foreach($course->courseCategories as $courseCategoryId){
                           $string .= $courseCategoryId->id.',';
                        }
                    @endphp
                    <input type="hidden" class="form-control" name="course_categories[]" value="{{ rtrim($string, ',') }}" id="questionTopic">
{{--                    <select name="course_categories[]" class="form-control select2"  multiple data-placeholder="Select Course Categories" >--}}
{{--                        <option></option>--}}
{{--                        @if(isset($courseCategories))--}}
{{--                            @foreach($courseCategories as $courseCategory)--}}
{{--                                <option value="{{ $courseCategory->id }}" @if(isset($course->courseCategories)) @foreach($course->courseCategories as $selectedCourseCategory) @if($courseCategory->id == $selectedCourseCategory->id) selected @endif @endforeach @endif>{{ $courseCategory->name }}</option>--}}
{{--                                @if(isset($courseCategory->courseCategories))--}}
{{--                                    @include('backend.course-management.course.courses.course-category-loop', ['courseCategory' => $courseCategory, 'child' => 1, 'course' => $course ?? ''])--}}
{{--                                @endif--}}
{{--                            @endforeach--}}

{{--                        @endif--}}
{{--                    </select>--}}
                    <span class="text-danger" id="course_categories"></span>
                </div>
                <div class="col-md-7 mt-2">
                    <label for="courseSlug">Course Slug</label>
                    <input type="text" name="slug" id="courseSlug" class="form-control" required placeholder="Course Slug" value="{{ isset($course) ? $course->slug : '' }}" />
                    <span class="text-danger" id="slug"></span>
                </div>
                <div class="col-md-12 mt-2">
                    <label for="">Course Sub Title</label>
                    <textarea name="sub_title" placeholder="Course Sub Title" id="" class="form-control" cols="30" rows="5">{{ isset($course) ? $course->sub_title : '' }}</textarea>
                    <span class="text-danger" id="sub_title"></span>
                </div>
                <div class="col-md-12 mt-2 mb-2">
                    <label for="">Course Description</label>
                    <textarea name="description" class="form-control" id="description" placeholder="Course Description" cols="30" rows="5"></textarea>
                    <span class="text-danger" id="description"></span>
                </div>
                <div class="col-md-12 mt-2 mb-2">
                    <label for="">What you'll learn?</label>
                    <textarea name="whythiscourse" class="form-control" id="whythiscourse" placeholder="What you'll learn?" cols="30" rows="5">{!! isset($course) ? $course->whythiscourse : '' !!}</textarea>
                    <span class="text-danger" id="descriptionwhythiscourse"></span>
                </div>
                <div class="col-md-6 mt-2 select2-div">
                    <label for="">Teachers</label>
                    <select name="teachers_id[]" class="form-control select2" multiple data-placeholder="Select Teachers" >
                        <option value=""></option>
                        @if(isset($teachers))
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" @if(isset($course->teachers)) @foreach($course->teachers as $selectedTeacher) @if($teacher->id == $selectedTeacher->id) selected @endif @endforeach @endif>{{ $teacher->user->name }}</option>
                            @endforeach
                        @endif
                    </select>
                    <span class="text-danger" id="teachers_id"></span>
                </div>
                <div class="col-md-6 mt-2">
                    <label for="">Featured Video</label>
{{--                    <input type="text" value="{{ isset($course->featured_video_url) ? 'https://youtu.be/'.$course->featured_video_url : '' }}" name="featured_video_url" class="form-control" placeholder="Featured Video" />--}}
                    <input type="text" value="{{ isset($course->featured_video_url) ? 'https://www.youtube.com/watch?v='.$course->featured_video_url : '' }}" name="featured_video_url" class="form-control" placeholder="Featured Video" />
                    <span class="text-danger" id="featured_video_url"></span>
                </div>
                <div class="col-md-6 mt-2">
                      <label for="">Featured Banner <span class="text-red">(450 x 350) pixels</span></label>
                    <input type="file" class="form-control" name="banner" id="courseImage" accept="images/*" placeholder="Featured Banner">
                    <span class="text-danger" id="banner"></span>

                </div>
                <div class="col-md-6 mt-2">
                    @if(isset($course))
                        <div>
                            <img src="{{ asset($course->banner) }}" id="courseImagePreview" style="height: 60px; width: 70px" />
                        </div>
                    @endif
                </div>
                <div class="col-md-6 mt-2">
                    <label for="">Banner Image ALT text</label>
                  <input type="text" class="form-control" name="alt_text" value="{{ $course->alt_text }}" placeholder="Banner Image ALT Text">
                  <span class="text-danger" id="alt_text"></span>

                </div>
                <div class="col-md-6 mt-2">
                    <label for="">Banner Image Title</label>
                  <input type="text" class="form-control" name="banner_title" value="{{ $course->banner_title }}" placeholder="Banner Image Title">
                  <span class="text-danger" id="banner_title"></span>

                </div>
            </div>
        </div>
        {{--                        legend test--}}
        {{--                        <style>--}}
        {{--                            legend{ padding: inherit; }--}}
        {{--                        </style>--}}
        {{--                        <fieldset class="border p-2">--}}
        {{--                            <legend  class="w-auto float-none">Legend</legend>--}}
        {{--                        </fieldset>--}}
        <div class="card card-body">
            <div class="row">
                <div class="col-md-4 mt-2">
                    <label for="">Duration in Month</label>
                    <input type="text" value="{{ isset($course) ? $course->duration_in_month : '' }}" class="form-control" name="duration_in_month" placeholder="Duration in Month" />
                    <span class="text-danger" id="duration_in_month"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Starting Date And Time</label>
                    <input type="text" class="form-control" id="dateTime" name="starting_date_time" value="{{ isset($course) ? $course->starting_date_time : '' }}" placeholder="Starting Date And Time" />
                    <span class="text-danger" id="starting_date_time"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Ending  Date And Time</label>
                    <input type="text" class="form-control" id="dateTime1" name="ending_date_time" value="{{ isset($course) ? $course->ending_date_time : '' }}" placeholder="Ending Date And Time" />
                    <span class="text-danger" id="ending_date_time"></span>
                </div>
            </div>
        </div>
        <div class="card card-body">
            <div class="row">
                <div class="col-md-4 mt-2">
                    <label for="">Admission Last Date</label>
                    <input type="text" name="admission_last_date" id="admissionLastDate" data-dtp="dtp_Nufud" value="{{ isset($course) ? $course->admission_last_date : '' }}" class="form-control" placeholder="Admission Last Date" />
                    <span class="text-danger" id="admission_last_date"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Price</label>
                    <input type="text" name="price" value="{{ isset($course) ? $course->price : '' }}" class="form-control" placeholder="Price" />
                    <span class="text-danger" id="price"></span>
                </div>
                <div class="col-md-4 mt-2 select2-div">
                    <label for="">Select a Discount Type</label>
                    <select name="discount_type" class="form-control" data-placeholder="Select a Discount Type">
                        <option value="" disabled>Select a Discount Option</option>
                        <option value="1" {{ isset($course) && $course->discount_type == 1 ? 'selected' : '' }}>Fixed</option>
                        <option value="2" {{ isset($course) && $course->discount_type == 2 ? 'selected' : '' }}>Percentage</option>
                    </select>
                    <span class="text-danger" id="discount_type"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Discount Value</label>
                    <input type="text" id="discountAmount" name="discount_amount" value="{{ isset($course) ? $course->discount_amount : '' }}" class="form-control" placeholder="Discount Value" />
                    <span id="discountErrorMsg" class="text-danger"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Discount Start Date</label>
                    <input type="text" name="discount_start_date" id="dateTime2" value="{{ isset($course) ? $course->discount_start_date : '' }}" data-dtp="dtp_Nufud" class="form-control" placeholder="Discount Start Date" />
                    <span class="text-danger" id="discount_start_date"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Discount End Date</label>
                    <input type="text" name="discount_end_date" id="dateTime3" value="{{ isset($course) ? $course->discount_end_date : '' }}" data-dtp="dtp_Nufud" class="form-control" placeholder="Discount Start Date" />
                    <span class="text-danger" id="discount_end_date"></span>
                </div>
            </div>
        </div>
        <div class="card card-body">
            <div class="row">
                <div class="col-md-12 mt-2">
                    <p>Content Total Items</p>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Affiliate Amount</label>
                    <input type="text" class="form-control" name="affiliate_amount" value="{{ isset($course) ? $course->affiliate_amount : '' }}" placeholder="Affiliate Amount" />
                    <span class="text-danger" id="affiliate_amount"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Fack Student Count</label>
                    <input type="text" class="form-control" name="fack_student_count" value="{{ isset($course) ? $course->fack_student_count : '' }}" placeholder="Fack Student Count" />
                    <span class="text-danger" id="fack_student_count"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Total Hour</label>
                    <input type="text" class="form-control" name="total_hours" value="{{ isset($course) ? $course->total_hours : '' }}" placeholder="Total Hour" />
                    <span class="text-danger" id="total_hours"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Total Class</label>
                    <input type="text" class="form-control" name="total_class" value="{{ isset($course) ? $course->total_class : '' }}" placeholder="Total Class" />
                    <span class="text-danger" id="total_class"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Partial Payment Amount</label>
                    <input type="text" class="form-control" name="partial_payment" value="{{ isset($course) ? $course->partial_payment : '' }}" placeholder="Partial Payment Amount" />
                    <span class="text-danger" id="partial_payment"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Total Video</label>
                    <input type="text" class="form-control" name="total_video" value="{{ isset($course) ? $course->total_video : '' }}" placeholder="Total Video" />
                    <span class="text-danger" id="total_video"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Total Audio</label>
                    <input type="text" class="form-control" name="total_audio" value="{{ isset($course) ? $course->total_audio : '' }}" placeholder="Total Audio" />
                    <span class="text-danger" id="total_audio"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Total Exam</label>
                    <input type="text" class="form-control" name="total_exam" value="{{ isset($course) ? $course->total_exam : '' }}" placeholder="Total Exam" />
                    <span class="text-danger" id="total_exam"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Total PDF</label>
                    <input type="text" class="form-control" name="total_pdf" value="{{ isset($course) ? $course->total_pdf : '' }}" placeholder="Total PDF" />
                    <span class="text-danger" id="total_pdf"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Total Note</label>
                    <input type="text" class="form-control" name="total_note" value="{{ isset($course) ? $course->total_note : '' }}" placeholder="Total Note" />
                    <span class="text-danger" id="total_note"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Total Link</label>
                    <input type="text" class="form-control" name="total_link" value="{{ isset($course) ? $course->total_link : '' }}" placeholder="Total Link" />
                    <span class="text-danger" id="total_link"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Total Live</label>
                    <input type="text" class="form-control" name="total_live" value="{{ isset($course) ? $course->total_live : '' }}" placeholder="Total Live" />
                    <span class="text-danger" id="title"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Total ZIP</label>
                    <input type="text" class="form-control" name="total_zip" value="{{ isset($course) ? $course->total_zip : '' }}" placeholder="Total ZIP" />
                    <span class="text-danger" id="total_zip"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Total File</label>
                    <input type="text" class="form-control" name="total_file" value="{{ isset($course) ? $course->total_file : '' }}" placeholder="Total File" />
                    <span class="text-danger" id="total_file"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Total Written Exam</label>
                    <input type="text" class="form-control" name="total_written_exam" value="{{ isset($course) ? $course->total_written_exam : '' }}" placeholder="Total Written Exam" />
                    <span class="text-danger" id="total_written_exam"></span>
                </div>
                <div class="col-md-4 mt-3">
                    <label for="">Status</label>
                    <div class="material-switch">
                        <input id="someSwitchOptionInfo" name="status" type="checkbox" {{ isset($course) && $course->status == 0 ? '' : 'checked' }} />
                        <label for="someSwitchOptionInfo" class="label-info"></label>
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <label for="">Is Paid</label>

                    <div class="material-switch">
                        <input id="someSwitchOptionWaring" name="is_paid" type="checkbox" {{ isset($course) && $course->is_paid == 0 ? '' : 'checked' }} />
                        <label for="someSwitchOptionWaring" class="label-info"></label>
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <label for="">Featured This Course</label>

                    <div class="material-switch">
                        <input id="someSwitchOptionSuccess" name="is_featured" type="checkbox" {{ isset($course) && $course->is_featured == 0 ? '' : 'checked' }} />
                        <label for="someSwitchOptionSuccess" class="label-info"></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary update-btn " value="save">Save</button>
    </div>
</form>


<div class="modal fade" id="questionTopicModal" data-bs-backdrop="static" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Select Course Categories</h1>
                <button type="button" class="btn-close close-topic-modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="" id="">
                    @if(isset($courseCategories))
                        @foreach($courseCategories as $key => $courseCategory)
                            <div class="parent-div ">
                                <div class="card card-body bg-transparent shadow-0 mb-2 p-1">
                                    <ul class="nav mb-0">
                                        @if(count($courseCategory->courseCategories) > 0)
                                            <li class="drop-icon f-s-15" style="cursor: pointer" data-id="{{ $courseCategory->id }}"><i class="fa-solid fa-circle-arrow-down"></i></li>
                                        @else
                                            <li class="ms-3"></li>
                                        @endif
                                        <li><label class="mb-0 f-s-15 ms-2"><input type="checkbox" class="check" @foreach($course->courseCategories as $courseSelectedCategory) {{ $courseCategory->id == $courseSelectedCategory->id ? 'checked' : '' }} @endforeach value="{{ $courseCategory->id }}">{{ $courseCategory->name }}</label></li>
                                    </ul>
                                </div>
                                @if(!empty($courseCategory))
                                    @if(count($courseCategory->courseCategories) > 0)
                                        @include('backend.course-management.course.courses.course-category-loop', ['courseCategory' => $courseCategory, 'child' => 15])
                                    @endif
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-topic-modal" >Close</button>
                <button type="button" class="btn btn-primary" id="okDone">Save</button>
            </div>
        </div>
    </div>
</div>


<script>

    var sites = {!! json_encode( isset($course) ? $course->description : '') !!};

    CKEDITOR.replace( 'description',
                {
                    fullPage : true,
                    uiColor : '#efe8ce'
                });
    CKEDITOR.instances['description'].setData(sites);
</script>
