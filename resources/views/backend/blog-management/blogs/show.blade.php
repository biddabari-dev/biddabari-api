<form action="" method="post" enctype="multipart/form-data" id="coursesForm">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Show Blog</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
    </div>
        <div class="modal-body">
            <div class="card card-body">
                <div class="row mt-2">
                    <div class="col-md-6 mt-2 select2-div">
                        <label for="">Category</label>
                        <select name="blog_category_id" disabled class="form-control select2" data-placeholder="Select a Category" id="discountType">
                            <option value=""></option>
                            @foreach($blogCategories as $blogCategory)
                                <option value="{{ $blogCategory->id }}" {{ $blogCategory->id == $blog->blog_category_id ? 'selected' : '' }} >{{ $blogCategory->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="">Title</label>
                        <input type="text" class="form-control" readonly name="title" value="{{ $blog->title }}" placeholder="Title" />
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="">Sub Title</label>
                        <input type="text" class="form-control" readonly name="sub_title" value="{{ $blog->sub_title }}" placeholder="Sub Title" />
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="">Video Url</label>
                        <input type="text" class="form-control" readonly name="video_url" value="{{ $blog->video_url }}" placeholder="Video Url" />
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <textarea name="body" id="" placeholder="Blog Content" cols="30" class="form-control w-100" rows="10">{!! strip_tags($blog->body) !!}</textarea>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-4 mt-2">
                        <div>
                            <img src="{{ asset($blog->image) }}" id="imagePreview" alt="" style="height: 150px">
                        </div>
                    </div>
                    <div class="col-sm-3 mt-2">
                        <label for="">Featured</label>
                        <div class="material-switch">
                            <input id="someSwitchOptionInfo" readonly name="is_featured" type="checkbox" {{ $blog->is_featured == 0 ? '' : 'checked' }} />
                            <label for="someSwitchOptionInfo" class="label-info"></label>
                        </div>
                    </div>
                    <div class="col-sm-3 mt-2">
                        <label for="">Status</label>
                        <div class="material-switch">
                            <input id="someSwitchOptionWarning" readonly name="status" type="checkbox" {{ $blog->status == 0 ? '' : 'checked' }} />
                            <label for="someSwitchOptionWarning" class="label-info"></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</form>

