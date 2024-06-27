
@extends('backend.master')

@section('title', 'Student Opinion')

@section('body')
    <div class="row py-5">
        <div class="col-8 mx-auto">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">Student Opinions Info</h4>
                    <a href="{{ route('student-opinions.index') }}" class="btn btn-white btn-sm float-end position-absolute me-5" style="right: 0"><i class="fa fa-sliders"></i></a>
                </div>
                <div class="card-body">
                    <form action="{{ isset($opinion) ? route('student-opinions.update',$opinion->id) : route('student-opinions.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @if(isset($opinion))
                            @method('put')
                        @endif
                        <div class="row mt-3">
                            <div class="col-sm-6 select2-div">
                                    <label for="" class="applicable-form">Student Type</label>
                                <select name="show_type" required class="form-control select2">
                                    <option value="all_students" {{ isset($opinion) && $opinion->show_type == 'all_students' ? 'selected' : '' }}>Passed</option>
                                    <option value="running_student" {{ isset($opinion) && $opinion->show_type == 'running_student' ? 'selected' : '' }}>Running</option>
                                </select>
                                <span class="text-danger" id="">{{ $errors->has('student_category_id') ? $errors->first('student_category_id') : '' }}</span>
                            </div>
                            <div class="col-sm-6">
                                <label for="">Student Name</label>
                                <input type="text" class="form-control" name="name" value="{{ isset($opinion) ? $opinion->name : '' }}" placeholder="Name" title="Title" />
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-sm-6">
                                <label for="">Student Image</label>
                                <div class="mt-1">
                                    <input type="file" name="image" id="hijibiji" class="form-control" placeholder="Image" accept="image/*" />
                                    @if(isset($opinion))
                                        <img src="{{ asset($opinion->image) }}" alt="" style="height: 80px">
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 mt-2">
                                <img src="" id="imagePreview" alt="">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12 mt-2">
                                <label for="" class="col-md-4">Student Comment</label>
                                <div class="col-md-12">
                                    <textarea type="text" name="comment" class="form-control" placeholder="Long Description" id="summernote" cols="30" rows="10">{{ isset($opinion) ? $opinion->comment : '' }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <label for="" class="col-md-3"> Student Opinion Status</label>
                            <div class="col-md-2">
                                <div class="material-switch">
                                    <input id="someSwitchOptionLight" name="status" type="checkbox" {{ isset($opinion) && $opinion->status == 0 ? '' : 'checked' }} />
                                    <label for="someSwitchOptionLight" class="label-light"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <input type="submit" class="col-md-4 mx-auto btn btn-yellow" value="{{ isset($opinion) ? 'Update' : 'Create' }}" />
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
            $('#hijibiji').change(function() {
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
