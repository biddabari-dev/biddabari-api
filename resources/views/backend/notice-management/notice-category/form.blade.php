<form action="{{ route('notice-categories.store') }}" method="post" enctype="multipart/form-data" id="advertisementForm">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Notice Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
    </div>
    {{--                    <input type="hidden" name="category_id" >--}}
    <div class="modal-body">
        <div class="card card-body">
            <div class="row mt-2">
                <div class="col-md-6 mt-2">
                    <label for="">Category Name</label>
                    <input type="text" class="form-control" required name="name" value="" placeholder="Category Name" />
                    <span class="text-danger" id="name">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
                </div>
                <div class="col-sm-3 mt-2">
                    <label for="">Status</label>
                    <div class="material-switch">
                        <input id="someSwitchOptionWarning" name="status" type="checkbox" checked="">
                        <label for="someSwitchOptionWarning" class="label-info"></label>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4 mt-2">
                    <label for="">Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*" id="imagex" placeholder="Image" />
                    <span class="text-danger" id="image">{{ $errors->has('image') ? $errors->first('image') : '' }}</span>
                </div>
                <div class="col-md-4 mt-2">
                    <div>
                        <img src="" id="imagePreview" alt="">
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-6 mt-2">
                    <label for="">Banner Image ALT text</label>
                <input type="text" class="form-control" name="alt_text" placeholder="Banner Image ALT Text">
                <span class="text-danger" id="alt_text"></span>

                </div>
                <div class="col-md-6 mt-2">
                    <label for="">Banner Image Title</label>
                <input type="text" class="form-control" name="banner_title"  placeholder="Banner Image Title">
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
