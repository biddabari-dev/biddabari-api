<form action="{{ isset($courseCoupon) ? route('course-coupons.update', $courseCoupon->id) : route('course-coupons.store') }}" method="post" enctype="multipart/form-data" id="coursesForm">
    @if(isset($courseCoupon))
        @method('put')
    @endif
        <input type="hidden" name="course_id" value="{{ isset($courseCoupon) ? $courseCoupon->course_id : request()->input('course_id') }}" />
    @csrf
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Course Coupons</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
    </div>
    {{--                    <input type="hidden" name="category_id" >--}}
    <div class="modal-body">
        <div class="card card-body">
            <div class="row mt-2">
                <div class="col-md-4 mt-2">
                    <label for="">Coupon Code</label>
                    <input type="text" class="form-control" required name="code" value="{{ isset($courseCoupon) ? $courseCoupon->code : '' }}" placeholder="Code" />
                    <span class="text-danger" id="code">{{ $errors->has('code') ? $errors->first('code') : '' }}</span>
                </div>
                <div class="col-md-4 mt-2 select2-div">
                    <label for="">Discount Type</label>
                    <select name="type" class="form-control select2" required data-placeholder="Select a Discount Type" id="discountType">
                        <option value=""></option>
                        <option value="Flat" {{ isset($courseCoupon) && $courseCoupon->type == 'Flat' ? 'selected' : '' }}>Flat</option>
                        <option value="Percentage" {{ isset($courseCoupon) && $courseCoupon->type == 'Percentage' ? 'selected' : '' }}>Percentage</option>
                    </select>
                    <span class="text-danger" id="type">{{ $errors->has('type') ? $errors->first('type') : '' }}</span>
                </div>
                <div class="col-md-4 mt-2 show-hide-div {{ isset($courseCoupon) && $courseCoupon->type == 'Percentage' ? '' : 'd-none' }}">
                    <label for="">Percentage Value</label>
                    <input type="text" name="percentage_value" value="{{ isset($courseCoupon) ? $courseCoupon->percentage_value : '' }}" class="form-control" placeholder="Percentage Value" />
                </div>
                <div class="col-md-4 mt-2 show-hide-amount {{ isset($courseCoupon) && $courseCoupon->type == 'Flat' ? '' : 'd-none' }}">
                    <label for="">Amount</label>
                    <input type="text" name="discount_amount" value="{{ isset($courseCoupon) ? $courseCoupon->discount_amount : '' }}" class="form-control" placeholder="Discount Amount" />
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4 mt-2">
                    <label for="">Expire Date</label>
                    <input type="text" name="expire_date_time" id="dateTime" required data-dtp="dtp_Nufud" value="{{ isset($courseCoupon) ? $courseCoupon->expire_date_time : '' }}" class="form-control" placeholder="Expire Date Time" />
                    <span class="text-danger" id="expire_date_time">{{ $errors->has('expire_date_time') ? $errors->first('expire_date_time') : '' }}</span>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="">Available From</label>
                    <input type="text" name="available_from" id="dateTime1" required data-dtp="dtp_Nufud" value="{{ isset($courseCoupon) ? $courseCoupon->available_from : '' }}" class="form-control" placeholder="Available Date Time" />
                    <span class="text-danger" id="available_from">{{ $errors->has('available_from') ? $errors->first('available_from') : '' }}</span>
                </div>
{{--                <div class="col-md-4 mt-2">--}}
{{--                    <label for="">Available To</label>--}}
{{--                    <input type="text" name="avaliable_to" id="dateTime2" required data-dtp="dtp_Nufud" value="{{ isset($courseCoupon) ? $courseCoupon->avaliable_to : '' }}" class="form-control" placeholder="Ending Date Time" />--}}
{{--                    <span class="text-danger" id="avaliable_to">{{ $errors->has('avaliable_to') ? $errors->first('avaliable_to') : '' }}</span>--}}
{{--                </div>--}}
{{--                <div class="col-md-4 mt-2">--}}
{{--                    <label for="">Flat Discount</label>--}}
{{--                    <input type="number" name="flat_discount" value="{{ isset($courseCoupon) ? $courseCoupon->flat_discount : '' }}" class="form-control" />--}}
{{--                </div>--}}
{{--                <div class="col-md-4 mt-3">--}}
{{--                    <label for="">Status</label> <br>--}}
{{--                    <input type="checkbox" id="switch6" name="status" switch="primary" {{ isset($courseCoupon) && $courseCoupon->status == 0 ? '' : 'checked' }} />--}}
{{--                    <label for="switch6" data-on-label="Yes" data-off-label="No"></label>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary update-btn" value="save">Save</button>
    </div>
</form>

@push('script')
    <script>
        $(document).on('change', '#discountType', function () {
            var discounttype = $(this).val();
            // alert(discounttype);
            if (discounttype == 'Percentage')
            {
                $('.show-hide-div').removeClass('d-none');
                $('.show-hide-amount').addClass('d-none');
            } else if (discounttype == 'Flat')
            {
                $('.show-hide-div').addClass('d-none');
                $('.show-hide-amount').removeClass('d-none');
            }
        })
    </script>
@endpush

