@extends('backend.master')

@section('title', 'Home Counter')

@section('body')
    <div class="row py-5">
        <div class="col-6 mx-auto">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">{{ isset($numberCounter) ? 'Update' : 'Create' }} Number Counter Form</h4>

                    <a href="{{ route('number-counters.index') }}"  class="rounded-circle open-modal text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4"><i class="fa-solid fa-file-lines"></i></a>

                </div>
                <div class="card-body">
                    <form action="{{ isset($numberCounter) ? route('number-counters.update', $numberCounter->id) : route('number-counters.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @if(isset($numberCounter))
                            @method('put')
                        @endif
                        <div class="row mt-2">
                            <div class="col-md-6 mt-2">
                                <label for="">Label</label>
                                <input type="text" class="form-control" required name="label" value="{{ isset($numberCounter) ? $numberCounter->label : '' }}" placeholder="Label" />
                                <span class="text-danger" id="">{{ $errors->has('label') ? $errors->first('label') : '' }}</span>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="">Icon Code</label>
                                <input type="text" class="form-control" name="icon_code" value="{{ isset($numberCounter) ? $numberCounter->icon_code : '' }}" placeholder="Icon Code" />
                                <span class="text-danger" id="">{{ $errors->has('icon_code') ? $errors->first('icon_code') : '' }}</span>
                                <span class="text-green">Use Font Awesome v6.2 icon class</span>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="">Total Number</label>
                                <input type="number" class="form-control" name="total_number" value="{{ isset($numberCounter) ? $numberCounter->total_number : '' }}" placeholder="Total Number" />
                                <span class="text-danger" id="">{{ $errors->has('total_number') ? $errors->first('total_number') : '' }}</span>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="row mt-2">
                                <div class="col-md-6 mt-2">
                                    <label for="">Image</label>
                                    <input type="file" name="image" class="form-control" id="imagez" placeholder="Image" />
                                    <span class="text-danger" id="image">{{ $errors->has('image') ? $errors->first('image') : '' }}</span>

                                </div>
                                <div class="col-md-6 mt-2">
                                    <div>
                                        @if(!empty($numberCounter->image))
                                            <img src="{{ asset($numberCounter->image) }}" id="imagePreview" style="height: 100px" />
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-sm-3 mt-2">
                                <label for="">Status</label>
                                <div class="material-switch">
                                    <input id="someSwitchOptionWarning" name="status" type="checkbox" {{ isset($numberCounter) && $numberCounter->status == 0 ? '' : 'checked' }} />
                                    <label for="someSwitchOptionWarning" class="label-info"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="modal-footer">
                                {{--                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>--}}
                                <button type="submit" class="btn btn-primary " value="save">Save</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
{{--    <div class="modal fade modal-div" id="coursesModal" data-bs-backdrop="static" data-modal-parent="coursesModal" >--}}
{{--        <div class="modal-dialog modal-dialog-centered modal-lg">--}}
{{--            <div class="modal-content" id="modalForm">--}}
{{--                @include('backend.blog-management.blogs.form')--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection

@push('style')
    <!-- DragNDrop Css -->
    {{--    <link href="{{ asset('/') }}backend/assets/css/dragNdrop.css" rel="stylesheet" type="text/css" />--}}

@endpush

@push('script')
    {{--    datatable--}}
    @include('backend.includes.assets.plugin-files.editor')



    <script>
        $(document).ready(function() {
            $('#imagez').change(function() {
                var imgURL = URL.createObjectURL(event.target.files[0]);
                $('#imagePreview').attr('src', imgURL).css({
                    height: 150+'px',
                    width: 150+'px',
                    marginTop: '5px'
                });
            });
        });
    </script>
@endpush
