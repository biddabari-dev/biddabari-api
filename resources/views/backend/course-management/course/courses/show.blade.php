<form action="" method="post" enctype="multipart/form-data" id="coursesForm">

    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Show Course Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
    </div>
    {{--                    <input type="hidden" name="category_id" >--}}
    <div class="modal-body">
        <div class="card card-body">
            <div class="row mt-2">
                <div class="col-md-7 mt-2">
                    <label for="courseTitle">Course Title</label>
                    <input type="text" name="title" disabled value="{{ isset($course) ? $course->title : '' }}" class="form-control" placeholder="Course Title" />
                </div>
                <div class="col-md-5 mt-2 select2-div">
                    <label for="">Select Course Categories</label>
                    <select name="course_categories[]" class="form-control select2"  multiple data-placeholder="Select Course Categories" disabled >
                        @foreach($course->courseCategories as $courseCategory)
                            <option selected>{{ $courseCategory->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12 mt-2">
                    <label for="">Course Sub Title</label>
                    <textarea name="sub_title" disabled placeholder="Course Sub Title" id="" class="form-control" cols="30" rows="5">{{ isset($course) ? $course->sub_title : '' }}</textarea>
                </div>
                <div class="col-md-12 mt-2 mb-2">
                    <label for="">Course Description</label>
                    <div class="mt-2">
                        {!! isset($course) ? $course->description : '' !!}
                    </div>
                </div>
                <div class="col-md-6 mt-2 select2-div">
                    <label for="">Teachers</label>
                    <select name="teachers_id[]" disabled class="form-control select2" multiple data-placeholder="Select Teachers" >
                        <option value=""></option>
                        @if(isset($teachers))
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" @if(isset($course->teachers)) @foreach($course->teachers as $selectedTeacher) @if($teacher->id == $selectedTeacher->id) selected @endif @endforeach @endif>{{ $teacher->user->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-6 mt-2">
                    <label for="">Featured Video</label>
{{--                    <input type="text" disabled value="{{ isset($course) ? $course->featured_video_url : '' }}" name="featured_video_url" class="form-control" placeholder="Featured Video" />--}}
                    <input type="text" disabled value="{{ isset($course->featured_video_url) ? 'https://www.youtube.com/watch?v='.$course->featured_video_url : '' }}" name="featured_video_url" class="form-control" placeholder="Featured Video" />
                </div>
                <div class="col-md-6 mt-2">
                    <p>Featured Banner</p>
                    @if(isset($course))
                        <div>
                            <img src="{{ asset($course->banner) }}" id="courseImagePreview" style="height: 60px; width: 70px" />
                        </div>
                    @endif
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
                    <input type="text" disabled value="{{ isset($course) ? $course->duration_in_month : '' }}" class="form-control" name="duration_in_month" placeholder="Duration in Month" />
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Starting Date And Time</label>
                    <input type="text" disabled class="form-control" id="dateTime" name="starting_date_time" value="{{ isset($course) ? $course->starting_date_time : '' }}" placeholder="Starting Date And Time" />
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Ending  Date And Time</label>
                    <input type="text" disabled class="form-control" id="dateTime1" name="ending_date_time" value="{{ isset($course) ? $course->ending_date_time : '' }}" placeholder="Ending Date And Time" />
                </div>
            </div>
        </div>
        <div class="card card-body">
            <div class="row">
                <div class="col-md-4 mt-2">
                    <label for="">Admission Last Date</label>
                    <input type="text" name="admission_last_date" disabled value="{{ isset($course) ? $course->admission_last_date : '' }}" class="form-control" placeholder="Admission Last Date" />
                    <span class="text-danger" id="admission_last_date"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Price</label>
                    <input type="text" disabled name="price" value="{{ isset($course) ? $course->price : '' }}" class="form-control" placeholder="Price" />
                </div>
                <div class="col-md-4 mt-2 select2-div">
                    <label for="">Select a Discount Type</label>
                    <select name="discount_type" disabled class="form-control" data-placeholder="Select a Discount Type">
                        <option value="" disabled>Select a Discount Option</option>
                        <option value="1" {{ isset($course) && $course->discount_type == 1 ? 'selected' : '' }}>Fixed</option>
                        <option value="2" {{ isset($course) && $course->discount_type == 2 ? 'selected' : '' }}>Percentage</option>
                    </select>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Discount Value</label>
                    <input type="text" disabled id="discountAmount" name="discount_amount" value="{{ isset($course) ? $course->discount_amount : '' }}" class="form-control" placeholder="Discount Value" />
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Discount Start Date</label>
                    <input type="text" disabled name="discount_start_date" id="dateTime2" value="{{ isset($course) ? $course->discount_start_date : '' }}" data-dtp="dtp_Nufud" class="form-control" placeholder="Discount Start Date" />
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Discount End Date</label>
                    <input type="text" disabled name="discount_end_date" id="dateTime3" value="{{ isset($course) ? $course->discount_end_date : '' }}" data-dtp="dtp_Nufud" class="form-control" placeholder="Discount Start Date" />
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
                    <input type="text" class="form-control" name="affiliate_amount" disabled value="{{ isset($course) ? $course->affiliate_amount : '' }}" placeholder="Affiliate Amount" />
                    <span class="text-danger" id="affiliate_amount"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Fack Student Count</label>
                    <input type="text" class="form-control" disabled name="fack_student_count" value="{{ isset($course) ? $course->fack_student_count : '' }}" placeholder="Fack Student Count" />
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Total Hour</label>
                    <input type="text" class="form-control" disabled name="total_hours" value="{{ isset($course) ? $course->total_hours : '' }}" placeholder="Total Hour" />
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Total Class</label>
                    <input type="text" class="form-control" disabled name="total_class" value="{{ isset($course) ? $course->total_class : '' }}" placeholder="Total Class" />
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Partial Payment Amount</label>
                    <input type="text" class="form-control" disabled name="partial_payment" value="{{ isset($course) ? $course->partial_payment : '' }}" placeholder="Partial Payment Amount" />
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Total Video</label>
                    <input type="text" class="form-control" disabled name="total_video" value="{{ isset($course) ? $course->total_video : '' }}" placeholder="Total Video" />
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Total Audio</label>
                    <input type="text" class="form-control" disabled name="total_audio" value="{{ isset($course) ? $course->total_audio : '' }}" placeholder="Total Audio" />
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Total Exam</label>
                    <input type="text" class="form-control" disabled name="total_exam" value="{{ isset($course) ? $course->total_exam : '' }}" placeholder="Total Exam" />
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Total PDF</label>
                    <input type="text" class="form-control" disabled name="total_pdf" value="{{ isset($course) ? $course->total_pdf : '' }}" placeholder="Total PDF" />
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Total Note</label>
                    <input type="text" class="form-control" disabled name="total_note" value="{{ isset($course) ? $course->total_note : '' }}" placeholder="Total Note" />
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Total Link</label>
                    <input type="text" class="form-control" disabled name="total_link" value="{{ isset($course) ? $course->total_link : '' }}" placeholder="Total Link" />
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Total Live</label>
                    <input type="text" class="form-control" disabled name="total_live" value="{{ isset($course) ? $course->total_live : '' }}" placeholder="Total Live" />
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Total ZIP</label>
                    <input type="text" class="form-control" disabled name="total_zip" value="{{ isset($course) ? $course->total_zip : '' }}" placeholder="Total ZIP" />
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Total File</label>
                    <input type="text" class="form-control" disabled name="total_file" value="{{ isset($course) ? $course->total_file : '' }}" placeholder="Total File" />
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Total Written Exam</label>
                    <input type="text" class="form-control" disabled name="total_written_exam" value="{{ isset($course) ? $course->total_written_exam : '' }}" placeholder="Total Written Exam" />
                </div>
                <div class="col-md-4 mt-3">
                    <label for="">Status</label>
                    <div class="material-switch">
                        <input id="someSwitchOptionInfo" disabled name="status" type="checkbox" {{ isset($course) && $course->status == 0 ? '' : 'checked' }} />
                        <label for="someSwitchOptionInfo" class="label-info"></label>
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <label for="">Is Paid</label>

                    <div class="material-switch">
                        <input id="someSwitchOptionWaring" disabled name="is_paid" type="checkbox" {{ isset($course) && $course->is_paid == 0 ? '' : 'checked' }} />
                        <label for="someSwitchOptionWaring" class="label-info"></label>
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <label for="">Featured This Course</label>

                    <div class="material-switch">
                        <input id="someSwitchOptionSuccess" disabled name="is_featured" type="checkbox" {{ isset($course) && $course->is_featured == 0 ? '' : 'checked' }} />
                        <label for="someSwitchOptionSuccess" class="label-info"></label>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>

