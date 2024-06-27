<form action="{{ route('courses.store') }}" method="post" enctype="multipart/form-data" id="coursesForm">
    <input type="hidden" name="_token" id="formToken" value="{{ csrf_token() }}" />
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create a Course</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
    </div>
    {{--                    <input type="hidden" name="category_id" >--}}
    <div class="modal-body">
        <div class="card card-body">
            <div class="row mt-2">
                <div class="col-md-7 mt-2">
                    <label for="courseTitle">Course Title</label>
                    <input type="text" name="title" id="courseTitle" class="form-control" placeholder="Course Title" />
                    <span class="text-danger" id="title"></span>
                </div>
                <div class="col-md-5 mt-2 select2-div">
                    <label for="courseCategories">Select Course Categories</label>
                    <input type="text" class="form-control" id="questionTopicInputField">
                    <input type="hidden" class="form-control" name="course_categories[]" id="questionTopic">
{{--                    <select name="course_categories[]" class="form-control select2" id="courseCategories" multiple data-placeholder="Select Course Categories" >--}}
{{--                        @if(isset($courseCategories))--}}
{{--                            @foreach($courseCategories as $courseCategory)--}}
{{--                                <option value="{{ $courseCategory->id }}" >{{ $courseCategory->name }}</option>--}}
{{--                                @if(!empty($courseCategory))--}}
{{--                                    @if(count($courseCategory->courseCategories) > 0)--}}
{{--                                        @include('backend.course-management.course.courses.course-category-loop', ['courseCategory' => $courseCategory, 'child' => 1])--}}
{{--                                    @endif--}}
{{--                                @endif--}}
{{--                            @endforeach--}}
{{--                        @endif--}}
{{--                    </select>--}}
                    <span class="text-danger" id="course_categories"></span>
                </div>
                <div class="col-md-7 mt-2">
                    <label for="courseSlug">Course Slug</label>
                    <input type="text" name="slug" id="courseSlug" required class="form-control" placeholder="Course Slug" />
                    <span class="text-danger" id="slug"></span>
                </div>
                <div class="col-md-12 mt-2">
                    <label for="">Course Sub Title</label>
                    <textarea name="sub_title" id="" placeholder="Course Sub Title" class="form-control" cols="30" rows="5"></textarea>
                    <span class="text-danger" id="sub_title"></span>
                </div>
                <div class="col-md-12 mt-2 mb-2">
                    <label for="">Course Description</label>
                    <textarea name="description" class="form-control " id="ck" placeholder="Course Description" cols="30" rows="5"></textarea>
                    <span class="text-danger" id="description"></span>
                </div>
                <div class="col-md-12 mt-2 mb-2">
                    <label for="">What you'll learn</label>
                    <textarea name="whythiscourse" class="form-control whythiscourse" id="whythiscourse" placeholder="What you'll learn ?" cols="30" rows="5"></textarea>
                    <span class="text-danger" id="descriptionwhythiscourse"></span>
                </div>
                <div class="col-md-6 mt-2 select2-div position-relative">
                    <label for="">Teachers</label>
                    <select name="teachers_id[]" class="form-control select2" multiple data-placeholder="Select Teachers" >
{{--                        <option value=""></option>--}}
                        @if(isset($teachers))
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->user->name }}</option>
                            @endforeach
                        @endif
                    </select>
                    <span class="text-danger" id="teachers_id"></span>
                </div>
                <div class="col-md-6 mt-2">
                    <label for="">Featured Video</label>
                    <input type="text"  name="featured_video_url" class="form-control" placeholder="Featured Video" />
                    <span class="text-danger" id="featured_video_url"></span>
                </div>
                <div class="col-md-6 mt-2">
                      <label for="">Featured Banner <span class="">(450 x 350) pixels</span></label>
                    <input type="file" class="form-control" name="banner" id="courseImage" accept="images/*" placeholder="Featured Banner" />
                    <span class="text-danger" id="banner"></span>
                </div>
                <div class="col-md-6 mt-2">
                    <img src="" id="courseImagePreview" alt="">
                </div>
                <div class="col-md-6 mt-2">
                    <label for="">Banner Image ALT text</label>
                  <input type="text" class="form-control" name="alt_text" placeholder="Banner Image ALT Text">
                  <span class="text-danger" id="alt_text"></span>

                </div>
                <div class="col-md-6 mt-2">
                    <label for="">Banner Image Title</label>
                  <input type="text" class="form-control" name="banner_title"  placeholder="Banner Image Title">
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
        <div class="card card-body x">
            <div class="row">
                <div class="col-md-4 mt-2">
                    <label for="">Duration in Month</label>
                    <input type="text"  class="form-control" name="duration_in_month" placeholder="Duration in Month" />
                    <span class="text-danger" id="duration_in_month"></span>
                </div>
                <div class="col-md-4 mt-2 date-fuck">
                    <label for="">Starting Date And Time</label>
                    <input type="text" class="form-control" id="dateTime" data-dtp="dtp_Nufud" name="starting_date_time" placeholder="Starting Date And Time" />
                    <span class="text-danger" id="starting_date_time"></span>
                </div>
                <div class="col-md-4 mt-2 date-fuck">
                    <label for="">Ending  Date And Time</label>
                    <input type="text" class="form-control" id="dateTime1" data-dtp="dtp_Nufud" name="ending_date_time" placeholder="Ending  Date And Time" />
                    <span class="text-danger" id="ending_date_time"></span>
                </div>
            </div>
        </div>
        <div class="card card-body">
            <div class="row">
                <div class="col-md-4 mt-2">
                    <label for="">Admission Last Date</label>
                    <input type="text" name="admission_last_date" id="admissionLastDate" data-dtp="dtp_Nufud" class="form-control" placeholder="Admission Last Date" />
                    <span class="text-danger" id="admission_last_date"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Price</label>
                    <input type="text" name="price"  class="form-control" placeholder="Price" />
                    <span class="text-danger" id="price"></span>
                </div>
                <div class="col-md-4 mt-2 select2-div">
                    <label for="">Select a Discount Type</label>
                    <select name="discount_type" class="form-control" data-placeholder="Select a Discount Type">
                        <option value="" disabled selected>Select a Discount Option</option>
                        <option value="1">Fixed</option>
                        <option value="2">Percentage</option>
                    </select>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Discount Value</label>
                    <input type="text" id="discountAmount" name="discount_amount" class="form-control" placeholder="Discount Value" />
                    <span id="discountErrorMsg" class="text-danger"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Discount Start Date</label>
                    <input type="text" name="discount_start_date" id="dateTime2" data-dtp="dtp_Nufud" class="form-control" placeholder="Discount Start Date" />
                    <span class="text-danger" id="discount_start_date"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Discount End Date</label>
                    <input type="text" name="discount_end_date" id="dateTime3" data-dtp="dtp_Nufud" class="form-control" placeholder="Discount Start Date" />
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
                    <input type="text" class="form-control" name="affiliate_amount" placeholder="Affiliate Amount" />
                    <span class="text-danger" id="affiliate_amount"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Fack Student Count</label>
                    <input type="text" class="form-control" name="fack_student_count" placeholder="Fack Student Count" />
                    <span class="text-danger" id="fack_student_count"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Total Hour</label>
                    <input type="text" class="form-control" name="total_hours" placeholder="Total Hour" />
                    <span class="text-danger" id="total_hours"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Total Class</label>
                    <input type="text" class="form-control" name="total_class" placeholder="Total Class" />
                    <span class="text-danger" id="total_class"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Partial Payment Amount</label>
                    <input type="text" class="form-control" name="partial_payment" placeholder="Partial Payment Amount" />
                    <span class="text-danger" id="partial_payment"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Total Video</label>
                    <input type="text" class="form-control" name="total_video" placeholder="Total Video" />
                    <span class="text-danger" id="total_video"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Total Audio</label>
                    <input type="text" class="form-control" name="total_audio" placeholder="Total Audio" />
                    <span class="text-danger" id="total_audio"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Total Exam</label>
                    <input type="text" class="form-control" name="total_exam" placeholder="Total Exam" />
                    <span class="text-danger" id="total_exam"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Total PDF</label>
                    <input type="text" class="form-control" name="total_pdf" placeholder="Total PDF" />
                    <span class="text-danger" id="total_pdf"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Total Note</label>
                    <input type="text" class="form-control" name="total_note" placeholder="Total Note" />
                    <span class="text-danger" id="total_note"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Total Link</label>
                    <input type="text" class="form-control" name="total_link" placeholder="Total Link" />
                    <span class="text-danger" id="total_link"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Total Live</label>
                    <input type="text" class="form-control" name="total_live" placeholder="Total Live" />
                    <span class="text-danger" id="total_live"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Total ZIP</label>
                    <input type="text" class="form-control" name="total_zip" placeholder="Total ZIP" />
                    <span class="text-danger" id="total_zip"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Total File</label>
                    <input type="text" class="form-control" name="total_file" placeholder="Total File" />
                    <span class="text-danger" id="total_file"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Total Written Exam</label>
                    <input type="text" class="form-control" name="total_written_exam" placeholder="Total Written Exam" />
                    <span class="text-danger" id="total_written_exam"></span>
                </div>
                <div class="col-md-4 mt-3">
                    <label for="">Status</label>

                    <div class="material-switch">
                        <input id="someSwitchOptionInfo" name="status" type="checkbox" checked />
                        <label for="someSwitchOptionInfo" class="label-info"></label>
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <label for="">Is Paid</label>

                    <div class="material-switch">
                        <input id="someSwitchOptionWaring" name="is_paid" type="checkbox" />
                        <label for="someSwitchOptionWaring" class="label-info"></label>
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <label for="">Featured This Course</label>

                    <div class="material-switch">
                        <input id="someSwitchOptionSuccess" name="is_featured" type="checkbox" />
                        <label for="someSwitchOptionSuccess" class="label-info"></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary submit-btn " value="save">Save</button>
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
                                        <li><label class="mb-0 f-s-15 ms-2"><input type="checkbox" class="check" value="{{ $courseCategory->id }}">{{ $courseCategory->name }}</label></li>
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
