<form action="" method="post" enctype="multipart/form-data" id="coursesForm">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Show Circulars</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
    </div>
        <div class="modal-body">
            <div class="card card-body">
                <div class="row mt-2">
                    <div class="col-md-6 mt-2 select2-div">
                        <label for="">Category</label>
                        <select name="circular_category_id" disabled class="form-control select2" data-placeholder="Select a Category" >
                            <option value=""></option>
                            @foreach($circularCategories as $circularCategory)
                                <option value="{{ $circularCategory->id }}" {{ $circularCategory->id == $circular->circular_category_id ? 'selected' : '' }}>{{ $circularCategory->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="">Post Title</label>
                        <input type="text" class="form-control" readonly name="post_title" value="{{ $circular->post_title }}" placeholder="Post Title" />
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="">Job Title</label>
                        <input type="text" class="form-control" readonly name="job_title" value="{{ $circular->job_title }}" placeholder="Job Title" />
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="">Vacancy</label>
                        <input type="text" class="form-control" readonly name="vacancy" value="{{ $circular->vacancy }}" placeholder="Vacancy" />
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <label for="" >About</label>
                        <textarea name="about" id="" class="form-control" readonly placeholder="About Circular" cols="30" rows="10">{!! strip_tags($circular->about) !!}</textarea>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <label for="" >Description</label>
                        <textarea name="description" id="" readonly class="form-control" placeholder="Circular Description" cols="30" rows="10">{!! strip_tags($circular->description) !!}</textarea>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6 mt-2">
                        <label for="">Publish Date</label>
                        <input type="text" class="form-control" readonly value="{{ $circular->publish_date }}" name="publish_date" id="dateTime" data-dtp="dtp_CsLGs" placeholder="Publish Date" />
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="">Expire Date</label>
                        <input type="text" class="form-control" readonly value="{{ $circular->expire_date }}" name="expire_date" id="dateTime1" data-dtp="dtp_CsLGs" placeholder="Expire Date" />
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-4 mt-2">
                        <div>
                            <img src="{{ !empty($circular->image) ? asset($circular->image) : '' }}" id="imagePreview" alt="">
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-3 mt-2">
                        <label for="">Featured</label>
                        <div class="material-switch">
                            <input id="someSwitchOptionInfo" disabled name="is_featured" type="checkbox" {{ $circularCategory->is_featured == 1 ? 'checked' : '' }} />
                            <label for="someSwitchOptionInfo" class="label-info"></label>
                        </div>
                    </div>
                    <div class="col-sm-3 mt-2">
                        <label for="">Status</label>
                        <div class="material-switch">
                            <input id="someSwitchOptionWarning" disabled name="status" type="checkbox" {{ $circularCategory->status == 1 ? 'checked' : '' }}>
                            <label for="someSwitchOptionWarning" class="label-info"></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</form>

