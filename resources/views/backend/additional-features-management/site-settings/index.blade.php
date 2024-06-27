@extends('backend.master')

@section('title', 'Popup Notifications')

@section('body')
    <div class="row py-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">Site Info</h4>
                </div>
                <div class="card-body">
                    <form action="{{ isset($siteSettings) ? route('site-settings.update',$siteSettings->id) : route('site-settings.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @if(isset($siteSettings))
                            @method('put')
                        @endif
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="">Site Title</label>
                                <input type="text" class="form-control" name="site_title" value="{{ isset($siteSettings) ? $siteSettings->site_title : '' }}" placeholder="Title" title="Title" />
                            </div>
                            <div class="col-sm-6">
                                <label for="">Our Speech Youtube Url</label>
                                <input type="text" class="form-control" name="our_speech_video_url" value="{{ isset($siteSettings) ? $siteSettings->our_speech_video_url : '' }}" placeholder="Youtube Link" title="Youtube Link" />
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="">Description</label>
                                <textarea name="site_meta_description" data-editor="summernote" class="form-control" cols="30" rows="10">{{ isset($siteSettings) ? $siteSettings->site_meta_description : '' }}</textarea>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-sm-4">
                                <label for="">Favicon</label>
                                <input type="file" class="form-control img-file" name="favicon" placeholder="favicon" title="Favicon" />
                                <div class="mt-1">
                                    <img src="{{ isset($siteSettings) ? asset($siteSettings->favicon) : '' }}" id="favicon" alt="favicon" style="height: 40px; width: 40px;" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="">Logo</label>
                                <input type="file" class="form-control img-file" name="logo" placeholder="Logo" title="Logo" />
                                <div class="mt-1">
                                    <img src="{{ isset($siteSettings) ? asset($siteSettings->logo) : '' }}" id="logo" alt="logo" style="height: 80px; width: 80px;" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="">Banner</label>
                                <input type="file" class="form-control img-file" name="banner" placeholder="Banner" title="Banner" />
                                <div class="mt-1">
                                    <img src="{{ isset($siteSettings) ? asset($siteSettings->banner) : '' }}" id="banner" alt="banner" style="height: 80px; width: 80px;" />
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12 mt-2">
                                <label for="">Default SEO Code On Header</label>
                                <textarea name="default_seo_code_on_header" data-editor="summernote" class="form-control" cols="30" rows="10">{{ isset($siteSettings) ? $siteSettings->default_seo_code_on_header : '' }}</textarea>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="">Default SEO Code On Footer</label>
                                <textarea name="default_seo_code_on_footer" data-editor="summernote" class="form-control" cols="30" rows="10">{{ isset($siteSettings) ? $siteSettings->default_seo_code_on_footer : '' }}</textarea>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="">Our Speech</label>
                                <textarea name="our_speech_text" data-editor="summernote" id="ourSpeech" class="form-control" cols="30" rows="10">{{ isset($siteSettings) ? $siteSettings->our_speech_text : '' }}</textarea>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <input type="submit" class="col-md-4 mx-auto btn btn-success" value="{{ isset($siteSettings) ? 'Update' : 'Create' }}" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <!-- DragNDrop Css -->
{{--    <link href="{{ asset('/') }}backend/assets/css/dragNdrop.css" rel="stylesheet" type="text/css" />--}}
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
        $('#ourSpeech').summernote({height:70, inheritPlaceholder: true})
    </script>
    <script>
        $(document).ready(function() {
            $('.img-file').change(function() {
                var idName = $(this).attr('name');
                var imgURL = URL.createObjectURL(event.target.files[0]);
                $('#'+idName).attr('src', imgURL).css({
                    // height: 150+'px',
                    // width: 150+'px',
                    // marginTop: '5px'
                });
            });
        });
    </script>


@endpush
