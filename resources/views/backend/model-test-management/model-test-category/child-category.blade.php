<form action="{{ route('model-test-categories.store') }}" method="post" enctype="multipart/form-data" id="modelTestForm">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Model Test Sub Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
    </div>
    <div class="modal-body">
        <div class="card card-body">
            <div class="row mt-2">
                <div class="col-md-6 mt-2">
                    <label for="">Category Name</label>
                    <input type="text" class="form-control" name="name" value="" placeholder="Category Name" />
                    <input type="hidden" name="model_test_category_id" value="{{ $modelTestCategory->id }}">
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
                    <input type="file" name="image" class="form-control" id="image" placeholder="Image" />
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
