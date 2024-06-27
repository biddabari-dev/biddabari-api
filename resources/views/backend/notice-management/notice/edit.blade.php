<form action="{{ isset($notice) ? route('notice.update', $notice->id) : route('notices.store') }}" method="post" enctype="multipart/form-data" id="advertisementForm">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Notice</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
    </div>
    {{--                    <input type="hidden" name="category_id" >--}}
    <div class="modal-body">
        <div class="card card-body">
            <div class="row mt-2">
                <div class="col-md-6 mt-2 select2-div">
                    <label for="">Notice Category</label>
                    <select name="notice_category_id" class="form-control select2" data-placeholder="Select A Category" required >
                        <option value=""></option>
                        @foreach($noticeCategories as $noticeCategory)
                            <option value="{{ $noticeCategory->id }}" {{ $notice->notice_category_id == $noticeCategory->id ? 'selected' : '' }}>{{ $noticeCategory->name }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger" id="notice_category_id">{{ $errors->has('notice_category_id') ? $errors->first('notice_category_id') : '' }}</span>
                </div>
                <div class="col-md-6 mt-2 select2-div">
                    <label for="">Notice Type</label>
                    <select name="type" class="form-control select2" data-placeholder="Select A Type" >
                        <option value=""></option>
                        <option value="normal" {{ $notice->type == 'normal' ? 'selected' : '' }}>Normal</option>
                        <option value="scroll" {{ $notice->type == 'scroll' ? 'selected' : '' }}>Scroll</option>
                    </select>
                    <span class="text-danger" id="type">{{ $errors->has('type') ? $errors->first('type') : '' }}</span>
                </div>
                <div class="col-md-6 mt-2">
                    <label for="">Title</label>
                    <input type="text" class="form-control" name="title" value="{{ $notice->title }}" placeholder="Notice Title" />
                    <span class="text-danger" id="title">{{ $errors->has('title') ? $errors->first('title') : '' }}</span>
                </div>
                <div class="col-sm-3 mt-2">
                    <label for="">Status</label>
                    <div class="material-switch">
                        <input id="someSwitchOptionWarning" name="status" type="checkbox" {{ $notice->status == 1 ? 'checked' : '' }}>
                        <label for="someSwitchOptionWarning" class="label-info"></label>
                    </div>
                </div>
            </div>
            <div class="row mt-2 ">
                <div class="col-md-12">
                    <textarea name="body" id="summernote" placeholder="Notice Content" cols="30" rows="10">{!! $notice->body !!}</textarea>
                </div>
            </div>
            <div class="row mt-2 image-row {{ $notice->type == 'scroll' ? 'd-none' : '' }}">
                <div class="col-md-4 mt-2">
                    <label for="">Image</label>
                    <input type="file" name="image" class="form-control" id="imagex" accept="image/*" placeholder="Image" />
                    <span class="text-danger" id="image">{{ $errors->has('image') ? $errors->first('image') : '' }}</span>
                </div>
                <div class="col-md-4 mt-2">
                    <div>
                        <img src="" id="imagePreview" alt="">
                    </div>
                </div>
                <div class="col-md-4 mt-2">
                    <div>
                        <img src="{{ asset($notice->image) }}" height="150" width="150" id="" alt="">
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-6 mt-2">
                    <label for="">Banner Image ALT text</label>
                <input type="text" class="form-control" name="alt_text" value="{{ $notice->alt_text }}" placeholder="Banner Image ALT Text">
                <span class="text-danger" id="alt_text"></span>

                </div>
                <div class="col-md-6 mt-2">
                    <label for="">Banner Image Title</label>
                <input type="text" class="form-control" name="banner_title" value="{{ $notice->banner_title }}"  placeholder="Banner Image Title">
                <span class="text-danger" id="banner_title"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary " value="save">Save</button>
    </div>
</form>
