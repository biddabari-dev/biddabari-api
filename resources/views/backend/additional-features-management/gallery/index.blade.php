@extends('backend.master')

@section('title', 'Gallery')

@section('body')
    <div class="row py-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">Gallery</h4>
                    @can('create-gallery')
                        <button type="button" class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4 blog-category-modal-btn"><i class="fa-solid fa-circle-plus"></i></button>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse($galleries as $gallery)
                        <div class="col-md-4 mt-3 position-relative gallery-parent-div">
                            <div class="card text-center card-max-height">
                                <img src="{{ asset(!empty($gallery->banner) ? $gallery->banner : 'frontend/logo/biddabari-card-logo.jpg' ) }}" alt="lgoo" class="card-img-top" style="height: 200px"/>
                                <div class="card-body">
                                    <h3>{{ $gallery->title }}</h3>
                                    <span class="text-sm">{{ $gallery->sub_title }}</span>
                                </div>
                            </div>
                            <div class="shadow-over-div" style="display: none">
                                <div class="text-center">
                                    @can('add-gallery-images')
                                        <a href="" data-blog-category-id="{{ $gallery->id }}" class="btn btn-sm btn-success blog-category-add-btn" title="Add Gallery Images">
                                            <i class="fa-solid fa-plus"></i>
                                        </a>
                                    @endcan
                                    @can('get-gallery-images')
                                        <a href="" data-blog-category-id="{{ $gallery->id }}" class="btn btn-sm btn-secondary blog-category-show-btn" title="Show Gallery">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        @endcan
                                    @can('edit-gallery')
                                        <a href="" data-blog-category-id="{{ $gallery->id }}" class="btn btn-sm btn-warning blog-category-edit-btn" title="Edit Gallery">
                                            <i class="fa-solid fa-edit"></i>
                                        </a>
                                        @endcan
                                    @can('delete-gallery')
                                        <form class="d-inline" action="{{ route('galleries.destroy', $gallery->id) }}" method="post" >
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger data-delete-form" title="Delete Gallery">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                        @endcan
                                </div>
                            </div>
                        </div>
                        @empty
                            <div class="col-md-12 mt-3">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <p>No Gallery Photos added yet.</p>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-div" id="showGalleryImages" data-modal-parent="" data-bs-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content" id="">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Show Gallery Images</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="card card-body">
                        <div class="append-image">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
{{--                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>--}}
{{--                    <button type="submit" class="btn btn-primary " value="save">Save</button>--}}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-div" id="galleryImage" data-modal-parent="" data-bs-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content" id="">
                <form id="courseSectionFormx" action="{{ route('galleries.add-images') }}" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="">Add Gallery Images</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="card card-body">
                            @csrf
                            <div class="append-image">

                            </div>
                            <div class="row mt-4">
                                <input type="hidden" name="gallery_id" />
                                <div class="col-sm-3">
                                    <label for="">Multiple Image</label>
                                    <div class="material-switch">
                                        <input id="someSwitchOptionInfo" name="is_multiple" type="checkbox" checked="">
                                        <label for="someSwitchOptionInfo" class="label-info"></label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Upload Image</label>
                                    <input type="file" class="form-control" name="images[]" multiple accept="images/*" />
                                </div>
                                <div class="col-sm-12 description d-none">
                                    <label for="">Description</label>
                                    <input type="text" class="form-control" name="title" placeholder="Title" title="Title" />
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary " value="save">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade modal-div" id="blogCategoryModal" data-modal-parent="blogCategoryModal" data-bs-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" id="">
                <form id="courseSectionForm" action="{{ route('galleries.store') }}" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="">Create Gallery</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="card card-body">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="">Title</label>
                                    <input type="text" class="form-control" required name="title" placeholder="Title" title="Title" />
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Sub Title</label>
                                    <input type="text" class="form-control" name="sub_title" placeholder="Sub Title" title="Sub Title" />
                                </div>
                                <div class="col-sm-12">
                                    <label for="">Description</label>
                                    <textarea name="description" class="form-control" id="summernote" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-4">

                                    <label for="">Image</label>
                                    <input type="file" class="form-control" id="image" name="banner" placeholder="Image" title="Image" />
                                </div>
                                <div class="col-sm-4">
                                    <div>
                                        <img src="" id="imagePreview" alt="">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-2">
                                    <label for="">Status</label> <br>
                                    <div class="material-switch">
                                        <input id="someSwitchOptionInfos" name="status" type="checkbox" checked>
                                        <label for="someSwitchOptionInfos" class="label-info"></label>
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
        .shadow-over-div {
            width: 100%;
        }
        .gallery-parent-div:hover .shadow-over-div{

            display: block!important;
            position: absolute;
            top: 0;
            left: 0;
            background-color: rgba(135,155,201, .3);
            transition: 1s;
        }
    </style>
@endpush

@push('script')

{{--    @include('backend.includes.assets.plugin-files.datatable')--}}
{{--    @include('backend.includes.assets.plugin-files.date-time-picker')--}}
    @include('backend.includes.assets.plugin-files.editor')
    {{--    store course--}}
    <script>
        $(function () {
            var maxHeight = 0, maxHeightElement = null;
            $('.card-max-height').each(function(){
                if ($(this).height() > maxHeight) {
                    maxHeight = $(this).height();
                    maxHeightElement = $(this);
                }
            });
            $('.card-max-height').css('height', maxHeight.toFixed());

            $('.shadow-over-div').each(function () {
                var divHeight = $(this).parent().find('.card-max-height').height();
                $(this).css({
                    'height': divHeight.toFixed(),
                    'paddingTop' : '40%'
                });
            });
        })
        // $(document).on('hover', '.gallery-parent-div', function () {
        //     $(this).find('shadow-over-div').css('display', 'block');
        // })

        $(document).on('click', '.blog-category-modal-btn', function () {
            event.preventDefault();
            // resetInputFields();
            if ($('input[name="_method"]').length)
            {
                $('input[name="_method"]').remove();
            }
            $('#courseSectionForm').attr('action', "{{ route('galleries.store') }}");
            $('#blogCategoryModal').modal('show');
        })
    </script>
    <script>
        {{--$(document).on('click', '.submit-btn', function () {--}}
        {{--    event.preventDefault();--}}
        {{--    var form = $('#coursesForm')[0];--}}
        {{--    var formData = new FormData(form);--}}
        {{--    $.ajax({--}}
        {{--        url: "{{ route('course-routines.store') }}",--}}
        {{--        method: "POST",--}}
        {{--        data: formData,--}}
        {{--        dataType: "JSON",--}}
        {{--        contentType: false,--}}
        {{--        processData: false,--}}
        {{--        success: function (message) {--}}
        {{--            // console.log(message);--}}
        {{--            toastr.success(message);--}}
        {{--            $('#coursesModal').modal('hide');--}}
        {{--            resetInputFields();--}}
        {{--            window.location.reload();--}}
        {{--        }--}}
        {{--    })--}}
        {{--})--}}
    </script>

{{--    edit course category--}}
    <script>
        $(document).on('click', '.blog-category-edit-btn', function () {
            event.preventDefault();
            var courseId = $(this).attr('data-blog-category-id'); //change value
            $.ajax({
                url: base_url+"galleries/"+courseId+"/edit",
                method: "GET",
                dataType: "JSON",
                success: function (data) {
                    // console.log(data);
                    $('input[name="title"]').val(data.title);
                    $('input[name="sub_title"]').val(data.sub_title);
                    // $('input[name="active_btn_link"]').val(data.active_btn_link);
                    $('#summernote').summernote('destroy');
                    $('textarea[name="description"]').html(data.description);
                    $("#summernote").summernote({height:70,inheritPlaceholder: true})
                    $('#imagePreview').attr('src', data.banner).css({height: '150px'});
                    if (data.status == 1)
                    {
                        $('input[name="status"]').attr('checked', true);
                    } else {
                        $('input[name="status"]').attr('checked', false);
                    }
                    $('#courseSectionForm').attr('action', base_url+"galleries/"+data.id).append('<input type="hidden" name="_method" value="put">');
                    $('#blogCategoryModal').modal('show');
                }
            })
        })
    </script>
{{--    show course category--}}
    <script>
        $(document).on('click', '.blog-category-show-btn', function () {
            event.preventDefault();
            var courseId = $(this).attr('data-blog-category-id'); //change value
            $.ajax({
                url: base_url+"galleries/get-images/"+courseId,
                method: "GET",
                // dataType: "JSON",
                success: function (data) {
                    // console.log(data.note);
                    // $('input[name="title"]').val(data.title).attr('readonly', true);
                    // $('input[name="sub_title"]').val(data.sub_title).attr('readonly', true);
                    // // $('input[name="active_btn_link"]').val(data.active_btn_link);
                    // $('#summernote').summernote('destroy');
                    // $('textarea[name="description"]').html(data.description).addClass('w-100').attr('readonly', true);
                    // $("#summernote").summernote({height:70,inheritPlaceholder: true})
                    // $('#imagePreview').attr('src', data.banner).css({height: '150px'});
                    // if (data.status == 1)
                    // {
                    //     $('input[name="status"]').attr({
                    //         'checked': true,
                    //         'readonly': true
                    //     });
                    // } else {
                    //     $('input[name="status"]').attr({
                    //         'checked': false,
                    //         'readonly': true
                    //     });
                    // }
                    $('.append-image').empty().html(data);
                    $('#showGalleryImages').modal('show');
                }
            })
        })
    </script>

<script>
    $(document).on('click', '.blog-category-add-btn', function () {
        event.preventDefault();
        var courseId = $(this).attr('data-blog-category-id'); //change value
        $('input[name="gallery_id"]').val(courseId);
        $.ajax({
            url: base_url+"galleries/get-images/"+courseId,
            method: "GET",
            // dataType: "JSON",
            success: function (data) {
                console.log(data);
                $('.append-image').empty().html(data);
                $('#galleryImage').modal('show');
            }
        })

    })
    $(document).on('click', '.delete-gallery-image', function () {
        event.preventDefault();
        var courseId = $(this).attr('data-gallery-image-id'); //change value
        $.ajax({
            url: base_url+"galleries/delete-image/"+courseId,
            method: "GET",
            // dataType: "JSON",
            success: function (data) {
                // console.log(data);
                toastr.success('Gallery Image Deleted Successfully.');
                $('.append-image').empty().html(data);
                // $('#galleryImage').modal('show');
            }
        })

    })
    $(document).on('click', 'input[name="is_multiple"]', function () {
        if ($(this).is(':checked'))
        {
            $('.description').addClass('d-none');
            $('input[name="images"]').attr('multiple', true);
        } else {
            $('.description').removeClass('d-none').css('transition', '1s');
            $('input[name="images"]').attr('multiple', false);
        }
    })
</script>

    <script>
        $(document).ready(function() {
            $('#image').change(function() {
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
