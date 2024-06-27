<form action="{{ isset($batchExam) ? route('batch-exams.update', $batchExam->id) : route('batch-exams.store') }}" method="post" enctype="multipart/form-data" id="coursesForm">
    @if(isset($batchExam))
        <input type="hidden" name="_method" id="formMethod" value="put" />

    @endif
        <input type="hidden" name="_token" id="formToken" value="{{ csrf_token() }}" />
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Batch Exam</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
    </div>
    {{--                    <input type="hidden" name="category_id" >--}}
    <div class="modal-body">
        <div class="card card-body">
            <div class="row mt-2">
                <div class="col-md-7 mt-2">
                    <label for="courseTitle">Batch Exam Title</label>
                    <input type="text" name="title" value="{{ isset($batchExam) ? $batchExam->title : '' }}" class="form-control" placeholder="Batch Exam Title" />
                    <span class="text-danger" id="title"></span>
                </div>
                <div class="col-md-5 mt-2 select2-div">
                    <label for="">Select Batch Exam Categories</label>
                    <input type="text" class="form-control" id="questionTopicInputField" value="@foreach($batchExam->batchExamCategories as $batchExamCategoryName){{ $batchExamCategoryName->name.',' }}@endforeach" />
                    @php
                        $string = '';
                        foreach($batchExam->batchExamCategories as $batchExamCategoryId){
                           $string .= $batchExamCategoryId->id.',';
                        }
                    @endphp
                    <input type="hidden" class="form-control" name="batch_exam_categories[]" value="{{ rtrim($string, ',') }}" id="questionTopic">
{{--                    <select name="batch_exam_categories[]" class="form-control select2"  multiple data-placeholder="Select Batch Exam Categories" >--}}
{{--                        <option></option>--}}
{{--                        @if(isset($batchExamCategories))--}}
{{--                            @foreach($batchExamCategories as $batchExamCategory)--}}
{{--                                <option value="{{ $batchExamCategory->id }}" @if(isset($batchExam->batchExamCategories)) @foreach($batchExam->batchExamCategories as $selectedCourseCategory) @if($batchExamCategory->id == $selectedCourseCategory->id) selected @endif @endforeach @endif>{{ $batchExamCategory->name }}</option>--}}
{{--                                @if(isset($batchExamCategory->batchExamCategories))--}}
{{--                                    @include('backend.batch-exam-management.batch-exams.course-category-loop', ['batchExamCategory' => $batchExamCategory, 'child' => 1, 'batchExam' => $batchExam ?? ''])--}}
{{--                                @endif--}}
{{--                            @endforeach--}}

{{--                        @endif--}}
{{--                    </select>--}}
                    <span class="text-danger" id="course_categories"></span>
                </div>
                <div class="col-md-12 mt-2">
                    <label for="">Batch Exam Sub Title</label>
                    <textarea name="sub_title" placeholder="Batch Exam Sub Title" id="" class="form-control" cols="30" rows="5">{{ isset($batchExam) ? $batchExam->sub_title : '' }}</textarea>
                    <span class="text-danger" id="sub_title"></span>
                </div>
                <div class="col-md-12 mt-2 mb-2">
                    <label for="">Batch Exam Description</label>
                    <textarea name="description" class="form-control" id="summernote" placeholder="Batch Exam Description" cols="30" rows="5">{!! isset($batchExam) ? $batchExam->description : '' !!}</textarea>
                    <span class="text-danger" id="description"></span>
                </div>
                <div class="col-md-6 mt-2">
                    <label for="">Affiliate Amount</label>
                    <input type="text" class="form-control" name="affiliate_amount" value="{{ isset($batchExam) ? $batchExam->affiliate_amount : '' }}" placeholder="Affiliate Amount" />
                    <span class="text-danger" id="affiliate_amount"></span>
                </div>
                <div class="col-md-6 mt-2">
                    <label for="">Featured Video</label>
                    <input type="text" value="{{ isset($batchExam->featured_video_url) ? 'https://www.youtube.com/watch?v='.$batchExam->featured_video_url : '' }}" name="featured_video_url" class="form-control" placeholder="Featured Video" />
                    <span class="text-danger" id="featured_video_url"></span>
                </div>
                <div class="col-md-6 mt-2">
                      <label for="">Featured Banner <span class="text-red">(320 X 200 + WEBP)</span></label>
                    <input type="file" class="form-control" name="banner" id="courseImage" accept="images/*" placeholder="Featured Banner">
                    <span class="text-danger" id="banner"></span>

                </div>

                <div class="col-md-6 mt-2">
                    @if(isset($batchExam))
                        <div>
                            <img src="{{ asset($batchExam->banner) }}" id="courseImagePreview" style="height: 60px; width: 70px" />
                        </div>
                    @endif
                </div>
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
                        <input type="text"  class="form-control" name="package_title[{{ $key }}]" value="{{ isset($examPackage) ? $examPackage->package_title : '' }}" placeholder="Package Title" />
                        <span class="text-danger" id="package_title"></span>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label for="">Package Duration</label>
                        <input type="text" value="{{ isset($examPackage) ? $examPackage->package_duration_in_days : '' }}" class="form-control" name="package_duration_in_days[{{ $key }}]" placeholder="Duration in Days" />
                        <span class="text-danger" id="package_duration_in_days"></span>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label for="">Price</label>
                        <input type="text" name="price[{{ $key }}]" value="{{ isset($examPackage) ? $examPackage->price : '' }}" data-loop-id="{{ $key }}" class="form-control price price-val-{{ $key }}" placeholder="Price" />
                        <span class="text-danger" id="price"></span>
                    </div>
                    <div class="col-md-4 mt-2 select2-div d-none">
                        <label for="">Select a Discount Type</label>
                        <select name="discount_type[{{ $key }}]" class="form-control discount-type{{ $key }}" data-placeholder="Select a Discount Type">
                            <option value="" disabled>Select a Discount Option</option>
                            <option value="1" {{ isset($examPackage) && $examPackage->discount_type == 1 ? 'selected' : '' }}>Fixed</option>
                            <option value="2" {{ isset($examPackage) && $examPackage->discount_type == 2 ? 'selected' : '' }}>Percentage</option>
                        </select>
                        <span class="text-danger" id="discount_type"></span>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label for="">Discount Value</label>
                        <input type="text" id="discountAmount{{ $key }}" name="discount_amount[{{ $key }}]" value="{{ isset($examPackage) ?  $examPackage->discount_amount : '' }}" data-loop-id="{{ $key }}" class="form-control discount-amount" placeholder="Discount Value" />
                        <span id="discountErrorMsg{{ $key }}" class="text-danger"></span>
                    </div>
                    <div class="col-md-3 mt-2">
                        <label for="">Discount Start Date</label>
                        <input type="text" name="discount_start_date[{{ $key }}]" id="dateTime{{ $key }}" value="{{ isset($examPackage) ? $examPackage->discount_start_date : '' }}" data-dtp="dtp_Nufud" class="form-control" placeholder="Discount Start Date" />
                        <span class="text-danger" id="discount_start_date"></span>
                    </div>
                    <div class="col-md-3 mt-2">
                        <label for="">Discount End Date</label>
                        <input type="text" name="discount_end_date[{{ $key }}]" id="dateTimex{{ $key }}" value="{{ isset($examPackage) ? $examPackage->discount_end_date : '' }}" data-dtp="dtp_Nufud" class="form-control" placeholder="Discount Start Date" />
                        <span class="text-danger" id="discount_end_date"></span>
                    </div>
                    <div class="col-md-2 m-t-30">
                        <div class="text-end">
                            <a href="" class="btn btn-sm btn-success add-row"><i class="fa-solid fa-plus"></i></a>
                            @if($key != 0)
                                <a href="" class="btn btn-sm btn-danger remove-row"><i class="fa-solid fa-trash"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
                <script>
                    $('#dateTime{{ $key }}').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm', minDate : new Date()});
                    $('#dateTimex{{ $key }}').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm', minDate : new Date()});
                </script>
            @endforeach
        </div>
        <div class="card card-body">
            <div class="row">
                <div class="col-md-4 mt-3">
                    <label for="">Status</label>
                    <div class="material-switch">
                        <input id="someSwitchOptionInfo" name="status" type="checkbox" {{ isset($batchExam) && $batchExam->status == 0 ? '' : 'checked' }} />
                        <label for="someSwitchOptionInfo" class="label-info"></label>
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <label for="">Is Paid</label>

                    <div class="material-switch">
                        <input id="someSwitchOptionWaring" name="is_paid" type="checkbox" {{ isset($batchExam) && $batchExam->is_paid == 0 ? '' : 'checked' }} />
                        <label for="someSwitchOptionWaring" class="label-info"></label>
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <label for="">Featured This Exam</label>

                    <div class="material-switch">
                        <input id="someSwitchOptionSuccess" name="is_featured" type="checkbox" {{ isset($batchExam) && $batchExam->is_featured == 0 ? '' : 'checked' }} />
                        <label for="someSwitchOptionSuccess" class="label-info"></label>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary update-btn" value="save">Save</button>
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
                                        <li><label class="mb-0 f-s-15 ms-2"><input type="checkbox" class="check" @if(isset($batchExam) && count($batchExam->batchExamCategories) > 0) @foreach($batchExam->batchExamCategories as $courseSelectedCategory) {{ $batchExamCategory->id == $courseSelectedCategory->id ? 'checked' : '' }} @endforeach @endif value="{{ $batchExamCategory->id }}">{{ $batchExamCategory->name }}</label></li>
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
