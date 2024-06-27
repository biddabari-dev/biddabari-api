<form action="" method="post" enctype="multipart/form-data" id="coursesForm">

    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Show Batch Exam Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
    </div>
    {{--                    <input type="hidden" name="category_id" >--}}
    <div class="modal-body">
        <div class="card card-body">
            <div class="row mt-2">
                <div class="col-md-7 mt-2">
                    <label for="courseTitle">Batch Exam Title</label>
                    <input type="text" name="title" disabled value="{{ isset($batchExam) ? $batchExam->title : '' }}" class="form-control" placeholder="Batch Exam Title" />
                </div>
                <div class="col-md-5 mt-2 select2-div">
                    <label for="">Select Batch Exam Categories</label>
                    <select name="batch_exam_categories[]" readonly="" class="form-control select2"  multiple data-placeholder="Select Batch Exam Categories" disabled >
                        @foreach($batchExam->batchExamCategories as $batchExamCategory)
                            <option selected>{{ $batchExamCategory->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12 mt-2">
                    <label for="">Batch Exam Sub Title</label>
                    <textarea name="sub_title" disabled placeholder="Batch Exam Sub Title" id="" class="form-control" cols="30" rows="5">{{ isset($batchExam) ? $batchExam->sub_title : '' }}</textarea>
                </div>
                <div class="col-md-12 mt-2 mb-2">
                    <label for="">Batch Exam Description</label>
                    <div class="mt-2">
                        {!! isset($batchExam) ? $batchExam->description : '' !!}
                    </div>
                </div>
                <div class="col-md-6 mt-2">
                    <label for="">Affiliate Amount</label>
                    <input type="text" class="form-control" disabled name="affiliate_amount" value="{{ isset($batchExam) ? $batchExam->affiliate_amount : '' }}" placeholder="Affiliate Amount" />
                    <span class="text-danger" id="affiliate_amount"></span>
                </div>
                <div class="col-md-6 mt-2">
                    <label for="">Featured Video</label>
                    <input type="text" disabled value="{{ isset($batchExam) ? $batchExam->featured_video_url : '' }}" name="featured_video_url" class="form-control" placeholder="Featured Video" />
                </div>
                <div class="col-md-6 mt-2">
                    <p>Featured Banner</p>
                    @if(isset($batchExam))
                        <div>
                            <img src="{{ asset($batchExam->banner) }}" id="courseImagePreview" style="height: 60px; width: 70px" />
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
                    <label for="">Package Duration</label>
                    <input type="text" disabled value="{{ isset($batchExam) ? $batchExam->package_duration_in_days : '' }}" class="form-control" name="duration_in_month" placeholder="Duration in Days" />
                </div>
{{--                <div class="col-md-4 mt-2">--}}
{{--                    <label for="">Starting Date And Time</label>--}}
{{--                    <input type="text" disabled class="form-control" id="dateTime" name="starting_date_time" value="{{ isset($batchExam) ? $batchExam->starting_date_time : '' }}" placeholder="Starting Date And Time" />--}}
{{--                </div>--}}
{{--                <div class="col-md-4 mt-2">--}}
{{--                    <label for="">Ending  Date And Time</label>--}}
{{--                    <input type="text" disabled class="form-control" id="dateTime1" name="ending_date_time" value="{{ isset($batchExam) ? $batchExam->ending_date_time : '' }}" placeholder="Ending Date And Time" />--}}
{{--                </div>--}}
            </div>
        </div>
        <div class="card card-body" id="appendPackage">
            @foreach($batchExam->batchExamSubscriptions as $key => $examPackage)
                <div class="row">
                    <div class="col-12 mt-3">
                        <h4>Exam Package Details</h4>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label for="">Package Title</label>
                        <input type="number"  class="form-control" readonly name="package_title[{{ $key }}]" value="{{ isset($examPackage) ? $examPackage->package_title : '' }}" placeholder="Package Title" />
                        <span class="text-danger" id="package_title"></span>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label for="">Package Duration</label>
                        <input type="text" readonly value="{{ isset($examPackage) ? $examPackage->package_duration_in_days : '' }}" class="form-control" name="package_duration_in_days[{{ $key }}]" placeholder="Duration in Days" />
                        <span class="text-danger" id="package_duration_in_days"></span>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label for="">Price</label>
                        <input type="text" readonly name="price[{{ $key }}]" value="{{ isset($examPackage) ? $examPackage->price : '' }}" class="form-control" placeholder="Price" />
                        <span class="text-danger" id="price"></span>
                    </div>
                    <div class="col-md-4 mt-2 select2-div d-none">
                        <label for="">Select a Discount Type</label>
                        <select name="discount_type[{{ $key }}]" class="form-control" data-placeholder="Select a Discount Type">
                            <option value="" disabled>Select a Discount Option</option>
                            <option value="1" {{ isset($examPackage) && $examPackage->discount_type == 1 ? 'selected' : '' }}>Fixed</option>
                            <option value="2" {{ isset($examPackage) && $examPackage->discount_type == 2 ? 'selected' : '' }}>Percentage</option>
                        </select>
                        <span class="text-danger" id="discount_type"></span>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label for="">Discount Value</label>
                        <input type="text" id="discountAmount" readonly name="discount_amount[{{ $key }}]" value="{{ isset($examPackage) ?  $examPackage->discount_amount : '' }}" class="form-control" placeholder="Discount Value" />
                        <span id="discountErrorMsg" class="text-danger"></span>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label for="">Discount Start Date</label>
                        <input type="text" name="discount_start_date[{{ $key }}]" readonly id="dateTime{{ $key }}" value="{{ isset($examPackage) ? $examPackage->discount_start_date : '' }}" data-dtp="dtp_Nufud" class="form-control" placeholder="Discount Start Date" />
                        <span class="text-danger" id="discount_start_date"></span>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label for="">Discount End Date</label>
                        <input type="text" name="discount_end_date[{{ $key }}]" readonly id="dateTimex{{ $key }}" value="{{ isset($examPackage) ? $examPackage->discount_end_date : '' }}" data-dtp="dtp_Nufud" class="form-control" placeholder="Discount Start Date" />
                        <span class="text-danger" id="discount_end_date"></span>
                    </div>

                </div>

            @endforeach
        </div>
        <div class="card card-body">
            <div class="row">

                <div class="col-md-4 mt-3">
                    <label for="">Status</label>
                    <div class="material-switch">
                        <input id="someSwitchOptionInfo" disabled name="status" type="checkbox" {{ isset($batchExam) && $batchExam->status == 0 ? '' : 'checked' }} />
                        <label for="someSwitchOptionInfo" class="label-info"></label>
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <label for="">Is Paid</label>

                    <div class="material-switch">
                        <input id="someSwitchOptionWaring" disabled name="is_paid" type="checkbox" {{ isset($batchExam) && $batchExam->is_paid == 0 ? '' : 'checked' }} />
                        <label for="someSwitchOptionWaring" class="label-info"></label>
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <label for="">Featured This Batch Exam</label>

                    <div class="material-switch">
                        <input id="someSwitchOptionSuccess" disabled name="is_featured" type="checkbox" {{ isset($batchExam) && $batchExam->is_featured == 0 ? '' : 'checked' }} />
                        <label for="someSwitchOptionSuccess" class="label-info"></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

