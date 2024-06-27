<form action="" method="post" enctype="multipart/form-data" id="advertisementForm">
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
                    <select disabled name="notice_category_id" class="form-control select2" data-placeholder="Select A Category" required >
                        <option value=""></option>
                        @foreach($noticeCategories as $noticeCategory)
                            <option value="{{ $noticeCategory->id }}" {{ $notice->notice_category_id == $noticeCategory->id ? 'selected' : '' }}>{{ $noticeCategory->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mt-2 select2-div">
                    <label for="">Notice Type</label>
                    <select name="type" disabled class="form-control select2" data-placeholder="Select A Type" >
                        <option value=""></option>
                        <option value="normal" {{ $notice->type == 'normal' ? 'selected' : '' }}>Normal</option>
                        <option value="scroll" {{ $notice->type == 'scroll' ? 'selected' : '' }}>Scroll</option>
                    </select>
                </div>
                <div class="col-md-6 mt-2">
                    <label for="">Title</label>
                    <input type="text" readonly class="form-control" name="title" value="{{ $notice->title }}" placeholder="Notice Title" />
                </div>
                <div class="col-sm-3 mt-2">
                    <label for="">Status</label>
                    <div class="material-switch">
                        <input id="someSwitchOptionWarning" disabled name="status" type="checkbox" {{ $notice->status == 1 ? 'checked' : '' }}>
                        <label for="someSwitchOptionWarning" class="label-info"></label>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12">
                    <textarea name="body" disabled id="summernote" placeholder="Notice Content" class="form-control" cols="30" rows="10">{!! strip_tags($notice->body) !!}</textarea>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4 mt-2">
                    <div>
                        <img src="{{ asset($notice->image) }}" height="150" width="150" id="" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
