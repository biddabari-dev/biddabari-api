
@extends('backend.master')

@section('title', 'Service')

@section('body')
    <div class="row py-5">
        <div class="col-8 mx-auto">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">Our Services Info</h4>
                    <a href="{{ route('our-services.index') }}" class="btn btn-white btn-sm float-end position-absolute me-5" style="right: 0"><i class="fa fa-sliders"></i></a>
                </div>
                <div class="card-body">
                    <form action="{{ isset($service) ? route('our-services.update',$service->id) : route('our-services.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @if(isset($service))
                            @method('put')
                        @endif
                        <div class="row mt-3">
                            <div class="col-sm-6">
                                <label for="">Service Icon Code</label>
                                <div class="mt-1">
                                    <input type="text" name="icon_code" class="form-control" value="{{ isset($service) ? $service->icon_code : '' }}" placeholder="Service Icon" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="">Service Title</label>
                                <input type="text" class="form-control" name="title" value="{{ isset($service) ? $service->title : '' }}" placeholder="Title" title="Title" />
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-sm-6 ">
                                <label for="">Student Image</label>
                                <div class="">
                                    <input type="file" name="image" id="nothing" class="form-control" placeholder="Image" accept="image/*" />
                                    @if(isset($service))
                                        <img src="{{ asset($service->image) }}" alt="" style="height: 80px">
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <img src="" id="imagePreview" alt="" />
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label for="" class="">Service Content</label>
                                <div class="">
                                    <textarea type="text" name="content" class="form-control" placeholder="Long Description" id="summernote" cols="30" rows="10">{{ isset($service) ? $service->content : '' }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <label for="" class="col-md-3"> Service Status</label>
                            <div class="col-md-2">
                                <div class="material-switch">
                                    <input id="someSwitchOptionLight" name="status" type="checkbox" {{ isset($service) && $service->status == 0 ? '' : 'checked' }} />
                                    <label for="someSwitchOptionLight" class="label-success"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <input type="submit" class="col-md-4 mx-auto btn btn-yellow" value="{{ isset($service) ? 'Update' : 'Create' }}" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')

    <style>
        input[switch]+label {
            margin-bottom: 0px;
        }

    </style>
@endpush

@push('script')

    {{--    @include('backend.includes.assets.plugin-files.datatable')--}}
    {{--    @include('backend.includes.assets.plugin-files.date-time-picker')--}}
    @include('backend.includes.assets.plugin-files.editor')
    <script>
        // $('textarea[data-editor="summernote"]').summernote({height:70,inheritPlaceholder: true})
    </script>
    <script>
        $(document).ready(function() {
            $('#nothing').change(function() {
                var idName = $(this).attr('name');
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
