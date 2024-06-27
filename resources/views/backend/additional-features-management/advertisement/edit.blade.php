<form action="{{ isset($advertisement) ? route('advertisements.update', $advertisement->id) : route('advertisements.store') }}" method="post" enctype="multipart/form-data" id="advertisementForm">
    @csrf
    @if(isset($advertisement))
        @method('put')
    @endif
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Advertisement</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
    </div>
    {{--                    <input type="hidden" name="category_id" >--}}
    <div class="modal-body">
        <div class="card card-body">
            <div class="row mt-2">
                <div class="col-md-6 mt-2">
                    <label for="">Title</label>
                    <input type="text" class="form-control" required name="title" value="{{ $advertisement->title }}" placeholder="Title" />
                    <span class="text-danger" id="title">{{ $errors->has('title') ? $errors->first('title') : '' }}</span>
                </div>
                <div class="col-md-6 mt-2 select2-div">
                    <label for="">Content Type</label>
                    <select name="content_type" required class="form-control select2" data-placeholder="Select a Content" >
                        <option value=""></option>
                        <option value="course" {{ $advertisement->content_type == 'course' ? 'selected' : '' }}>Course</option>
                        <option value="ebook" {{ $advertisement->content_type == 'ebook' ? 'selected' : '' }}>Ebook</option>
                        <option value="book" {{ $advertisement->content_type == 'book' ? 'selected' : '' }}>Book</option>
                        <option value="external-link" {{ $advertisement->content_type == 'external-link' ? 'selected' : '' }}>External Link</option>
                    </select>
                    <span class="text-danger" id="content_type">{{ $errors->has('content_type') ? $errors->first('content_type') : '' }}</span>
                </div>
                <div class="col-md-12 mt-2">
                    <label for="">Advertisement Description</label>
                    <textarea name="description" id="" class="form-control summernote" cols="30" rows="10">{!! $advertisement->description !!}</textarea>
                    <span class="text-danger" id="description">{{ $errors->has('description') ? $errors->first('description') : '' }}</span>
                </div>
                <div class="col-md-6 mt-2">
                    <label for="">Content Full Page Link</label>
                    <input type="text" class="form-control" name="link" value="{{ $advertisement->link }}" placeholder="Link" />
                    <span class="text-danger" id="link">{{ $errors->has('link') ? $errors->first('link') : '' }}</span>
                </div>
                <div class="col-sm-3 mt-2">
                    <label for="">Status</label>
                    <div class="material-switch">
                        <input id="someSwitchOptionWarning" name="status" type="checkbox" {{ $advertisement->status == 1 ? 'checked' : '' }}>
                        <label for="someSwitchOptionWarning" class="label-info"></label>
                    </div>
                    <span class="text-danger" id="status">{{ $errors->has('status') ? $errors->first('status') : '' }}</span>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4 mt-2">
                     <label for="">Image <span class="text-red">(760 X 440 + WEBP)</span> </label>
                    <input type="file" name="image" class="form-control" id="image" placeholder="Image" />
                    <span class="text-danger" id="image">{{ $errors->has('image') ? $errors->first('image') : '' }}</span>
                </div>
                <div class="col-md-4 mt-2">
                    <div>
                        <img src="" id="imagePreview" alt="">
                    </div>
                </div>
                <div class="col-md-4 mt-2">
                    <div>
                        <img src="{{ asset($advertisement->image) }}" height="150" width="150" id="" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" value="save">Save</button>
    </div>
</form>
