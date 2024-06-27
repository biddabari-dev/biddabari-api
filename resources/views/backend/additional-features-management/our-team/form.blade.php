@extends('backend.master')

@section('title', 'Our Team')

@section('body')
    <div class="row py-5">
        <div class="col-8 mx-auto">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">{{ isset($ourTeam) ? 'Update' : 'Create' }} Our Team Form</h4>

                    <a href="{{ route('our-teams.index') }}"  class="rounded-circle open-modal text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4"><i class="fa-solid fa-file-lines"></i></a>

                </div>
                <div class="card-body">
                    <form action="{{ isset($ourTeam) ? route('our-teams.update', $ourTeam->id) : route('our-teams.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @if(isset($ourTeam))
                            @method('put')
                        @endif
                        <div class="row mt-2">

                            <div class="col-md-6 mt-2 select2-div">
                                <label for="">Content Show Type</label>
                                <select name="content_show_type" required class="form-control select2" data-placeholder="Select a Category" >
                                    <option value="" disabled selected >Select a Category</option>
                                    <option value="home_page" {{ isset($ourTeam) && $ourTeam->content_show_type == 'home_page' ? 'selected' : '' }}>Home Page</option>
                                    <option value="about_us_page" {{ isset($ourTeam) && $ourTeam->content_show_type == 'about_us_page' ? 'selected' : '' }}>About Us</option>
                                </select>
                                <span class="text-danger" id="">{{ $errors->has('content_show_type') ? $errors->first('content_show_type') : '' }}</span>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="">Name</label>
                                <input type="text" class="form-control" required name="name" value="{{ isset($ourTeam) ? $ourTeam->name : '' }}" placeholder="Name" />
                                <span class="text-danger" id="">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="">Designation</label>
                                <input type="text" class="form-control" name="designation" value="{{ isset($ourTeam) ? $ourTeam->designation : '' }}" placeholder="Designation" />
                                <span class="text-danger" id="">{{ $errors->has('designation') ? $errors->first('designation') : '' }}</span>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="">Video Link</label>
                                <input type="text" disabled class="form-control" name="video_link" value="{{ isset($ourTeam) ? $ourTeam->video_link : '' }}" placeholder="Video Link" />
                                <span class="text-danger" id="">{{ $errors->has('video_link') ? $errors->first('video_link') : '' }}</span>
                                <span class="text-red">Temporary Feature Unavailable</span>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="">Video File</label>
                                <input type="file" class="form-control" name="video_file" accept="video/*" />
                                <span class="text-danger" id="">{{ $errors->has('video_file') ? $errors->first('video_file') : '' }}</span>
                            </div>
                            @if(isset($ourTeam->video_file))
                                <div class="col-md-6 mt-2">
                                    <video class="w-100" style="height: 120px">
                                        <source src="{{ asset($ourTeam->video_file) }}" type="video/mp4" />
                                    </video>
                                </div>
                            @endif
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
                                        <img src="{{ !empty($ourTeam->image) ? asset($ourTeam->image) : 'https://cdn.vectorstock.com/i/preview-1x/65/30/default-image-icon-missing-picture-page-vector-40546530.jpg' }}" style="height: 100px;" id="imagePreview" alt="Our Team" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-sm-3 mt-2">
                                <label for="">Status</label>
                                <div class="material-switch">
                                    <input id="someSwitchOptionWarning" name="status" type="checkbox" {{ isset($ourTeam) && $ourTeam->status == 0 ? '' : 'checked' }} />
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
                    height: 100+'px',
                    width: 100+'px',
                    marginTop: '5px'
                });
            });
        });
    </script>
@endpush
