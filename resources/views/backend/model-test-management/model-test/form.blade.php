<form action="{{ route('model-tests.store') }}" method="post" enctype="multipart/form-data" id="modelTestForm">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Model Test</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
    </div>
    {{--                    <input type="hidden" name="category_id" >--}}
    <div class="modal-body">
        <div class="card card-body">
            <div class="row mt-2">
                <div class="col-md-6 mt-2 select2-div">
                    <label for="">Model Test Category</label>
                    <select name="model_test_category_id" class="form-control select2" data-placeholder="Select A Category" required >
                        <option value=""></option>
                        @foreach($modelTestCategories as $modelTestCategory)
                        <option value="{{ $modelTestCategory->id }}">{{ $modelTestCategory->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mt-2">
                    <label for="">Title</label>
                    <input type="text" class="form-control" name="title" value="" placeholder="Model Test Title" />
                </div>
                <div class="col-md-6 mt-2">
                    <label for="">Image</label>
                    <input type="file" name="image" class="form-control" id="image" placeholder="Image" />
                </div>
                <div class="col-sm-3 mt-2">
                    <label for="">Status</label>
                    <div class="material-switch">
                        <input id="someSwitchOptionWarning" name="status" type="checkbox" checked="">
                        <label for="someSwitchOptionWarning" class="label-info"></label>
                    </div>
                </div>
                <div class="col-md-6 mt-2">
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
