<form action="{{ route('batch-exams.store') }}" method="post" enctype="multipart/form-data" id="coursesForm">
    <input type="hidden" name="_token" id="formToken" value="{{ csrf_token() }}" />
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Batch Exams</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
    </div>
    {{--                    <input type="hidden" name="category_id" >--}}
    <div class="modal-body">
        <div class="card card-body">
            <div class="row mt-2">
                <div class="col-md-7 mt-2">
                    <label for="courseTitle">Batch Exam Title</label>
                    <input type="text" name="title" id="courseTitle" class="form-control" placeholder="Batch Exam Title" />
                    <span class="text-danger" id="title"></span>
                </div>
                <div class="col-md-5 mt-2 select2-div">
                    <label for="courseCategories">Select Batch Exam Categories</label>
                    <input type="text" class="form-control" id="questionTopicInputField">
                    <input type="hidden" class="form-control" name="batch_exam_categories[]" id="questionTopic">
{{--                    <select name="batch_exam_categories[]" class="form-control select2" id="courseCategories" multiple data-placeholder="Select Batch Exam Categories" >--}}
{{--                        <option></option>--}}
{{--                        @if(isset($batchExamCategories))--}}
{{--                            @foreach($batchExamCategories as $batchExamCategory)--}}
{{--                                <option value="{{ $batchExamCategory->id }}" >{{ $batchExamCategory->name }}</option>--}}
{{--                                @if(!empty($batchExamCategory))--}}
{{--                                    @if(count($batchExamCategory->batchExamCategories) > 0)--}}

{{--                                        @include('backend.batch-exam-management.batch-exams.course-category-loop', ['batchExamCategory' => $batchExamCategory, 'child' => 1])--}}
{{--                                    @endif--}}
{{--                                @endif--}}
{{--                            @endforeach--}}
{{--                        @endif--}}
{{--                    </select>--}}
                    <span class="text-danger" id="batch_exam_categories"></span>
                </div>
                <div class="col-md-12 mt-2">
                    <label for="">Batch Exam Sub Title</label>
                    <textarea name="sub_title" id="" placeholder="Batch Exam Sub Title" class="form-control" cols="30" rows="5"></textarea>
                    <span class="text-danger" id="sub_title"></span>
                </div>
                <div class="col-md-12 mt-2 mb-2">
                    <label for="">Batch Exam Description</label>
                    <textarea name="description" class="form-control summernote" id="summernote" placeholder="Batch Exam Description" cols="30" rows="5"></textarea>
                    <span class="text-danger" id="description"></span>
                </div>
{{--                <div class="col-md-6 mt-2 select2-div">--}}
{{--                    <label for="">Trainers</label>--}}
{{--                    <select name="teachers_id[]" class="form-control select2" multiple data-placeholder="Select Teachers" >--}}
{{--                        <option value=""></option>--}}
{{--                        @if(isset($teachers))--}}
{{--                            @foreach($teachers as $teacher)--}}
{{--                                <option value="{{ $teacher->id }}">{{ $teacher->user->name }}</option>--}}
{{--                            @endforeach--}}
{{--                        @endif--}}
{{--                    </select>--}}
{{--                    <span class="text-danger" id="teachers_id"></span>--}}
{{--                </div>--}}
                <div class="col-md-6 mt-2">
                    <label for="">Affiliate Amount</label>
                    <input type="text" class="form-control" name="affiliate_amount" placeholder="Affiliate Amount" />
                    <span class="text-danger" id="affiliate_amount"></span>
                </div>
                <div class="col-md-6 mt-2">
                    <label for="">Featured Video</label>
                    <input type="text"  name="featured_video_url" class="form-control" placeholder="Featured Video" />
                    <span class="text-danger" id="featured_video_url"></span>
                </div>
                <div class="col-md-6 mt-2">
                      <label for="">Featured Banner <span class="text-red">(320 X 200 + WEBP)</span></label>
                    <input type="file" class="form-control" name="banner" id="courseImage" accept="image/*" placeholder="Featured Banner" />
                    <span class="text-danger" id="banner"></span>
                </div>
                <div class="col-md-6 mt-2">
                    <img src="" id="courseImagePreview" alt="">
                </div>
            </div>
        </div>
        <div class="card card-body" id="appendPackage">
            <div class="row">
                <div class="col-12 mt-3">
                    <h4>Exam Package Details</h4>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Package Title</label>
                    <input type="text"  class="form-control" name="package_title[0]" placeholder="Package Title" />
                    <span class="text-danger" id="package_title"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Package Duration</label>
                    <input type="number"  class="form-control" name="package_duration_in_days[0]" placeholder="Duration in Days" />
                    <span class="text-danger" id="package_duration_in_days"></span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Price</label>
                    <input type="number" name="price[0]" data-loop-id="0" class="form-control price price-val-0" placeholder="Price" />
                    <span class="text-danger" id="price"></span>
                </div>
                <div class="col-md-4 mt-2 select2-div d-none">
                    <label for="">Select a Discount Type</label>
                    <select name="discount_type[0]" class="form-control discount-type0" data-placeholder="Select a Discount Type">
                        <option value="" disabled >Select a Discount Option</option>
                        <option value="1" selected>Fixed</option>
                        <option value="2">Percentage</option>
                    </select>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Discount Value</label>
                    <input type="number" id="discountAmount0" name="discount_amount[0]" data-loop-id="0" class="form-control discount-amount" placeholder="Discount Value" />
                    <span id="discountErrorMsg0" class="text-danger"></span>
                </div>
                <div class="col-md-3 mt-2">
                    <label for="">Discount Start Date</label>
                    <input type="text" name="discount_start_date[0]" id="dateTime2" data-dtp="dtp_Nufud" class="form-control" placeholder="Discount Start Date" />
                    <span class="text-danger" id="discount_start_date"></span>
                </div>
                <div class="col-md-3 mt-2">
                    <label for="">Discount End Date</label>
                    <input type="text" name="discount_end_date[0]" id="dateTime3" data-dtp="dtp_Nufud" class="form-control" placeholder="Discount Start Date" />
                    <span class="text-danger" id="discount_end_date"></span>
                </div>
                <div class="col-md-2 m-t-30">
                    <div class="text-end">
                        <a href="" class="btn btn-sm btn-success add-row"><i class="fa-solid fa-plus"></i></a>
{{--                        <a href="" class="btn btn-sm btn-danger remove-row"><i class="fa-solid fa-trash"></i></a>--}}
                    </div>
                </div>
            </div>
        </div>
{{--        <div class="card card-body">--}}
{{--            <div class="row">--}}
{{--                <div class="col-md-4 mt-2 select2-div d-none">--}}
{{--                    <label for="">Select a Discount Type</label>--}}
{{--                    <select name="discount_type" class="form-control" data-placeholder="Select a Discount Type">--}}
{{--                        <option value="" disabled >Select a Discount Option</option>--}}
{{--                        <option value="1" selected>Fixed</option>--}}
{{--                        <option value="2">Percentage</option>--}}
{{--                    </select>--}}
{{--                </div>--}}
{{--                <div class="col-md-4 mt-2">--}}
{{--                    <label for="">Discount Value</label>--}}
{{--                    <input type="text" id="discountAmount" name="discount_amount" class="form-control" placeholder="Discount Value" />--}}
{{--                    <span id="discountErrorMsg" class="text-danger"></span>--}}
{{--                </div>--}}
{{--                <div class="col-md-4 mt-2">--}}
{{--                    <label for="">Discount Start Date</label>--}}
{{--                    <input type="text" name="discount_start_date" id="dateTime2" data-dtp="dtp_Nufud" class="form-control" placeholder="Discount Start Date" />--}}
{{--                    <span class="text-danger" id="discount_start_date"></span>--}}
{{--                </div>--}}
{{--                <div class="col-md-4 mt-2">--}}
{{--                    <label for="">Discount End Date</label>--}}
{{--                    <input type="text" name="discount_end_date" id="dateTime3" data-dtp="dtp_Nufud" class="form-control" placeholder="Discount Start Date" />--}}
{{--                    <span class="text-danger" id="discount_end_date"></span>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="card card-body">
            <div class="row">
                <div class="col-md-4 mt-3">
                    <label for="">Status</label>
                    <div class="material-switch">
                        <input id="someSwitchOptionWarningxx" name="status" type="checkbox" >
                        <label for="someSwitchOptionWarningxx" class="label-warning"></label>
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <label for="">Is Paid</label>

                    <div class="material-switch">
                        <input id="someSwitchOptionWaringp" name="is_paid" type="checkbox" />
                        <label for="someSwitchOptionWaringp" class="label-info"></label>
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <label for="">Featured This Batch Exam</label>

                    <div class="material-switch">
                        <input id="someSwitchOptionSuccessp" name="is_featured" type="checkbox" />
                        <label for="someSwitchOptionSuccessp" class="label-info"></label>
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
                <h1 class="modal-title fs-5" id="exampleModalLabel">Select Batch Exam Categories</h1>
                <button type="button" class="btn-close close-topic-modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="" id="">
                    @if(isset($batchExamCategories))
                        @foreach($batchExamCategories as $key => $batchExamCategory)
                            <div class="parent-div ">
                                <div class="card card-body bg-transparent shadow-0 mb-2 p-1">
                                    <ul class="nav mb-0">
                                        @if(count($batchExamCategory->batchExamCategories) > 0)
                                            <li class="drop-icon f-s-15" style="cursor: pointer" data-id="{{ $batchExamCategory->id }}"><i class="fa-solid fa-circle-arrow-down"></i></li>
                                        @else
                                            <li class="ms-3"></li>
                                        @endif
                                        <li><label class="mb-0 f-s-15 ms-2"><input type="checkbox" class="check" value="{{ $batchExamCategory->id }}">{{ $batchExamCategory->name }}</label></li>
                                    </ul>
                                </div>
                                @if(!empty($batchExamCategory))
                                    @if(count($batchExamCategory->batchExamCategories) > 0)
                                        @include('backend.batch-exam-management.batch-exams.course-category-loop', ['batchExamCategory' => $batchExamCategory, 'child' => 15])
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
