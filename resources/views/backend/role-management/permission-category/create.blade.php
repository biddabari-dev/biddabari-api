@extends('backend.master')

@section('title', 'Permission Categories')

@section('body')
    <div class="row py-5">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="text-white">Permission Category Create</h4>
                    <a href="{{ route('permission-categories.index') }}" class="btn rounded-circle position-absolute end-0 me-3">
                        <i class="fa-regular fa-file-lines fa-2x text-white"></i>
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ isset($permissionCategory) ? route('permission-categories.update', $permissionCategory->id) : route('permission-categories.store') }}" method="post">
                        @csrf
                        @if(isset($permissionCategory))
                            @method('put')
                        @endif
                        <div>
                            <label for="">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ isset($permissionCategory) ? $permissionCategory->name : '' }}" />
                        </div>
                        <div class="mt-2">
                            <label for="">note</label>
                            <textarea name="note" class="form-control" id="elm1" cols="30" rows="2">{{ isset($permissionCategory) ? $permissionCategory->note : '' }}</textarea>
                        </div>
                        <div class="mt-2">
                            <label for="">Is Published</label>
                            <div>
                                <div class="material-switch">
                                    <input id="someSwitchOptionInfo" name="status" type="checkbox" {{ isset($permissionCategory) && $permissionCategory->status == 0 ? '' : 'checked' }} />
                                    <label for="someSwitchOptionInfo" class="label-info"></label>
                                </div>
                            </div>
                        </div>
                        <div>
                            <input type="submit" class="btn btn-success btn-sm float-end" value="{{ isset($permissionCategory) ? 'Update' : 'Create' }} Permission Category" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('script')
    <!--tinymce js-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.3.2/tinymce.min.js" integrity="sha512-9w/jRiVYhkTCGR//GeGsRss1BJdvxVj544etEHGG1ZPB9qxwF7m6VAeEQb1DzlVvjEZ8Qv4v8YGU8xVPPgovqg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{--    <script src="{{ asset('/') }}backend/assets/libs/tinymce/tinymce.min.js"></script>--}}

    <!-- init js -->
{{--    <script src="{{ asset('/') }}backend/assets/js/pages/form-editor.init.js"></script>--}}
    <script>

        tinymce.init({
            selector: 'textarea#elm1',
            height: 200,
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });


    </script>
@endpush
