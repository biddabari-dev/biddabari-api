<form action="{{ route('advertisements.store') }}" method="post" enctype="multipart/form-data" id="advertisementForm">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Advertisement</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
    </div>
    {{--                    <input type="hidden" name="category_id" >--}}
    <div class="modal-body">
        <div class="card card-body">
            <div class="row mt-2">
                <div class="col-md-6 mt-2">
                    <label for="">Title</label>
                    <input type="text" class="form-control" required name="title" value="" placeholder="Title" />
                    <span class="text-danger" id="title">{{ $errors->has('title') ? $errors->first('title') : '' }}</span>
                </div>
                <div class="col-md-6 mt-2 select2-div">
                    <label for="">Content Type</label>
                    <select name="content_type" class="form-control select2" required data-placeholder="Select A Content" >
                        <option value=""></option>
                        <option value="course">Course</option>
                        <option value="ebook">Ebook</option>
                        <option value="book">Book</option>
                        <option value="external-link">External Link</option>
                    </select>
                    <span class="text-danger" id="content_type">{{ $errors->has('content_type') ? $errors->first('content_type') : '' }}</span>
                </div>
                <div class="col-md-12 mt-2">
                    <label for="">Advertisement Description</label>
                    <textarea name="description" id="" class="form-control summernote" cols="30" rows="10"></textarea>
                    <span class="text-danger" id="description">{{ $errors->has('description') ? $errors->first('description') : '' }}</span>
                </div>
                <div class="col-md-6 mt-2">
                    <label for="">Content Full Page Link</label>
                    <input type="text" class="form-control" name="link" value="" placeholder="Link" />
                    <span class="text-danger" id="link">{{ $errors->has('link') ? $errors->first('link') : '' }}</span>
                </div>
                <div class="col-sm-3 mt-2">
                    <label for="">Status</label>
                    <div class="material-switch">
                        <input id="someSwitchOptionWarning" name="status" type="checkbox" checked="">
                        <label for="someSwitchOptionWarning" class="label-info"></label>
                    </div>
                    <span class="text-danger" id="status">{{ $errors->has('status') ? $errors->first('status') : '' }}</span>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4 mt-2">
                     <label for="">Image <span class="text-red">(7620 X 440 + WEBP)</span> </label>
                    <input type="file" name="image" class="form-control" id="imagex" placeholder="Image" />
                    <span class="text-danger" id="image">{{ $errors->has('image') ? $errors->first('image') : '' }}</span>
                </div>
                <div class="col-md-4 mt-2">
                    <div>
                        <img src="" id="imagePreview" alt="">
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
