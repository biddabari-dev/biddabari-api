<form action="{{ route('circulars.store') }}" method="post" enctype="multipart/form-data" id="coursesForm">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Circular</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
    </div>
    {{--                    <input type="hidden" name="category_id" >--}}
    <div class="modal-body">
        <div class="card card-body">
            <div class="row mt-2">
                <div class="col-md-6 mt-2 select2-div">
                    <label for="">Category</label>
                    <select name="circular_category_id" required class="form-control select2" data-placeholder="Select a Category" >
                        <option value=""></option>
                        @foreach($circularCategories as $circularCategory)
                            <option value="{{ $circularCategory->id }}">{{ $circularCategory->title }}</option>
                            @if(!empty($circularCategory))
                                @if(count($circularCategory->circularCategories) > 0)
                                    @include('backend.circular-management.circulars.circular-category-loop', ['circularCategory' => $circularCategory, 'child' => 1])
                                @endif
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mt-2">
                    <label for="">Post Title</label>
                    <input type="text" class="form-control" required name="post_title" value="" placeholder="Post Title" />
                </div>
                <div class="col-md-6 mt-2">
                    <label for="">Job Title</label>
                    <input type="text" class="form-control" required name="job_title" value="" placeholder="Job Title" />
                </div>
                <div class="col-md-6 mt-2">
                    <label for="">Vacancy</label>
                    <input type="text" class="form-control" required name="vacancy" value="" placeholder="Vacancy" />
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12">
                    <label for="" >About</label>
                    <textarea name="about" id="summernote" placeholder="About Circular" cols="30" rows="10"></textarea>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12">
                    <label for="" >Description</label>
                    <textarea name="description" id="summernote1" placeholder="Circular Description" cols="30" rows="10"></textarea>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-6 mt-2">
                    <label for="">Publish Date</label>
                    <input type="text" class="form-control" name="publish_date" id="dateTime" data-dtp="dtp_CsLGs" placeholder="Publish Date" />
                </div>
                <div class="col-md-6 mt-2">
                    <label for="">Expire Date</label>
                    <input type="text" class="form-control" name="expire_date" id="dateTime1" data-dtp="dtp_CsLGs" placeholder="Expire Date" />
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4 mt-2">
                     <label for="">Image <span class="text-red">(300 X 200 + WEBP)</span> </label>
                    <input type="file" name="image" class="form-control" id="image" placeholder="Image" />
                </div>
                <div class="col-md-4 mt-2">
                    <div>
                        <img src="" id="imagePreview" alt="">
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-sm-3 mt-2">
                    <label for="">Featured</label>
                    <div class="material-switch">
                        <input id="someSwitchOptionInfo" name="is_featured" type="checkbox" checked="">
                        <label for="someSwitchOptionInfo" class="label-info"></label>
                    </div>
                </div>
                <div class="col-sm-3 mt-2">
                    <label for="">Status</label>
                    <div class="material-switch">
                        <input id="someSwitchOptionWarning" name="status" type="checkbox" checked="">
                        <label for="someSwitchOptionWarning" class="label-info"></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary " value="save">Save</button>
    </div>
</form>

