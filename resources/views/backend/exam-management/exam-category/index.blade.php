@extends('backend.master')

@section('title', 'Exam Categories')

@section('body')
    <div class="row py-5">
        <div class="col-md-11 mx-auto">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">Exam Category</h4>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#courseCategoryModal" class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4"><i class="fa-solid fa-circle-plus"></i></button>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12 ">
{{--                            <ol class="dd-list list-group">--}}
{{--                                @foreach($categories as $k => $category)--}}
{{--                                    <li class="dd-item list-group-item" data-id="{{ $category['id'] }}" >--}}
{{--                                        <div class="dd-handle" >{{ $category['name'] }}</div>--}}
{{--                                        <div class="dd-option-handle">--}}
{{--                                            <a href="{{ route('exam-categories.edit', $category['id']) }}" data-category-id="{{ $category['id'] }}" class="btn btn-success btn-sm category-edit-btn" >Edit</a>--}}
{{--                                            <form action="{{ route('exam-categories.destroy', $category['id']) }}" method="post" class="d-inline" onsubmit="return confirm('Are you sure to delete this?')">--}}
{{--                                                @csrf--}}
{{--                                                @method('delete')--}}
{{--                                                <button type="submit" data-category-id="{{ $category['id'] }}" class="btn btn-danger btn-sm" >Delete</button>--}}
{{--                                            </form>--}}
{{--                                            <a href="{{ route('course-categories.edit', ['id' => $category['id'] ]) }}" class="btn btn-success btn-sm" >Edit</a>--}}
{{--                                            <a href="{{ route('course-categories.destroy', ['category_id' => $category['category_id'] ]) }}" class="btn btn-danger btn-sm" >Delete</a>--}}
{{--                                        </div>--}}

{{--                                        @if(!empty($category->examCategories))--}}
{{--                                            @include('backend.exam-management.exam-category.child-category-view', [ 'category' => $category])--}}
{{--                                        @endif--}}
{{--                                    </li>--}}
{{--                                @endforeach--}}
{{--                            </ol>--}}
                            @if(!empty($categories))
                                <div class="accordion" id="accordionExample">
                                    @foreach($categories as $category)
                                        <div class="accordion-item">
                                            <div class="accordion-header" id="headingOne">
                                                <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                                    <div class="row w-100">
                                                        <div class="col-sm-8">
                                                            <span class="me-auto">{{ $loop->iteration }}. {{ $category->name }}</span>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div>
{{--                                                                @if(count($category->examCategories) > 0)--}}
                                                                    <button data-href="{{ route('exam-categories.index', ['q-c-id' => $category->id]) }}" class="btn sub-cat-btn bg-transparent">Sub Category</button>
{{--                                                                @endif--}}
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <span class="float-end d-flex">
{{--                                                                <a href="" class="btn btn-primary btn-sm ms-1"><i class="fas fa-eye"></i></a>--}}
                                                                <a href="" class="btn btn-success btn-sm category-edit-btn" data-category-id="{{ $category->id }}"><i class="fas fa-edit"></i></a>
{{--                                                                <a href="" class="btn btn-danger btn-sm ms-1"><i class="fas fa-trash"></i></a>--}}
                                                                <form action="{{ route('exam-categories.destroy', $category->id) }}" method="post" class="d-inline" onsubmit="return confirm('Are you sure to delete this?')">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button type="submit" class="btn btn-danger btn-sm ms-1" ><i class="fas fa-trash"></i></button>
                                                                </form>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if(isset($x))
                                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table">
                                                        <tbody>
                                                            <tr class="">
                                                                <td>Accordion Item #22</td>
                                                                <td>Sub Category</td>
                                                                <td>
                                                                    <a href="" class="btn btn-primary btn-sm ms-1"><i class="fas fa-eye"></i></a>
        {{--                                                            <a href="" class="btn btn-success btn-sm ms-1"><i class="fas fa-edit"></i></a>--}}
        {{--                                                            <a href="" class="btn btn-danger btn-sm ms-1"><i class="fas fa-trash"></i></a>--}}
                                                                </td>
                                                            </tr>
                                                            <tr class="">
                                                                <td>Accordion Item #22</td>
                                                                <td>Sub Category</td>
                                                                <td>
                                                                    <a href="" class="btn btn-primary btn-sm ms-1"><i class="fas fa-eye"></i></a>
        {{--                                                            <a href="" class="btn btn-success btn-sm ms-1"><i class="fas fa-edit"></i></a>--}}
        {{--                                                            <a href="" class="btn btn-danger btn-sm ms-1"><i class="fas fa-trash"></i></a>--}}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center">
                                    <span >No data available..</span>
                                </div>
                            @endif
                        </div>
                    </div>

{{--                    <div class="row">--}}
{{--                        <form action="{{ route('examCategories.saveNestedCategories') }}" method="post" id="nestedCategoryOrderForm">--}}
{{--                            @csrf--}}
{{--                            <textarea style="display: none;" name="nested_category_array" id="nestable-output"></textarea>--}}
{{--                            <button type="submit" class="btn btn-success" style="margin-top: 15px;display: none" >Update Order</button>--}}
{{--                        </form>--}}
{{--                    </div>--}}

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-div" data-bs-backdrop="static" id="courseCategoryModal">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable-body">
            <div class="modal-content">
                <form action="" method="post" enctype="multipart/form-data" id="courseCategoryForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Exam Category</h5>
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
{{--                    <input type="hidden" name="category_id" >--}}
                    <div class="modal-body">
                        @if(isset($_GET['q-c-id']))
                            <input type="hidden" name="exam_category_id" value="{{ $_GET['q-c-id'] }}">
                        @endif
                        <div class="row mt-2">
                            <div class="col-md-4 mt-2">
                                <label for="">Name</label>
                                <input type="text" name="name" required class="form-control" placeholder="Name" />
                            </div>
                            <div class="col-md-4 mt-2">
                                <label for="">Priec</label>
                                <input type="text" name="price" class="form-control" placeholder="Price">
                            </div>
                            <div class="col-md-4 mt-2">
                                <label for="">XM Subscription Duration</label>
                                <input type="text" name="xm_subscription_duration" class="form-control" placeholder="XM Subscription Duration">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label for="">Description</label>
                                <textarea name="description" class="form-control" id="summernote" placeholder="Description" cols="30" rows="10"></textarea>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label for="">Icon Class <br><span class="text-warning">[Use Font Awesome 6.4.0 classes]</span></label>
                                <input type="text" name="icon_class_code" class="form-control" placeholder="Icon CLass">
                            </div>
                            <div class="col-md-4 mt-2">
                                <label for="">Image</label>
                                <input type="file" name="image" id="categoryImage" accept="images/*">
                            </div>
                            <div class="col-md-4 mt-2">
                                <div>
                                    <img src="" id="imagePreview" style=""/>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 position-relative">
                                <div class="float-start">
                                    <div class="material-switch">
                                        <input id="someSwitchOptionInfo" name="status" type="checkbox" checked />
                                        <label for="someSwitchOptionInfo" class="label-info"></label>
                                    </div>
                                    <label for="" class="switch-label">Active</label>
                                </div>
                            </div>
                            <div class="col-md-4 position-relative">
                                <div class="float-start">
                                    <label for="" class="switch-label">Open For Sale</label>
                                    <div class="material-switch">
                                        <input id="someSwitchOptionWarning" name="open_for_sale" type="checkbox" />
                                        <label for="someSwitchOptionWarning" class="label-info"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 position-relative">
                                <div class="float-start">
                                    <label for="" class="switch-label">Is Master Exam</label>
                                    <div class="material-switch">
                                        <input id="someSwitchOptionWarning" name="is_master_exam" type="checkbox" />
                                        <label for="someSwitchOptionWarning" class="label-info"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
{{--                        <button type="reset" class="btn btn-warning">Reset</button>--}}
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary submit-btn" value="save">Save</button>
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
        #imagePreview {
            display: none;
        }
        .accordion-button::after{ display: none; }
        .table tbody tr:hover{
            cursor: pointer;
            box-shadow:0 .5rem 1rem rgba(0,0,0,.15)!important
        }
    </style>
@endpush

@push('script')
    @include('backend.includes.assets.plugin-files.date-time-picker')
    <script>
        $(function () {
            $('#dateTime').bootstrapMaterialDatePicker({
                format: 'YYYY-MM-DD HH:mm',
                minDate : new Date()
            });
        })
    </script>
    <!-- INTERNAL Summernote Editor js -->
    <script src="{{ asset('/') }}backend/assets/plugins/summernote-editor/summernote1.js"></script>
    <script src="{{ asset('/') }}backend/assets/js/summernote.js"></script>
    <!-- DragNDrop js -->
{{--    <script src="{{ asset('/') }}backend/assets/plugins/dragNdrop/jquery.nestable.js"></script>--}}
{{--    <script src="{{ asset('/') }}backend/assets/plugins/dragNdrop/init.js"></script>--}}

    <script>
        $(document).on('click', '.sub-cat-btn', function () {
            window.location = $(this).attr('data-href');
        })
    </script>
    <script>
        {{--    store course category--}}
        $(document).on('click', '.submit-btn', function () {
            event.preventDefault();
            var form = $('#courseCategoryForm')[0];
            var formData = new FormData(form);
            $.ajax({
                url: "{{ route('exam-categories.store') }}",
                method: "POST",
                data: formData,
                dataType: "JSON",
                contentType: false,
                processData: false,
                success: function (message) {
                    toastr.success(message);
                    $('#courseCategoryModal').modal('hide');
                    window.location.reload();
                    // resetInputFields();
                }
            })
        })
    </script>
    <script>
        {{--    edit course category--}}
        $(document).on('click', '.category-edit-btn', function () {
            event.preventDefault();
            var categoryId = $(this).attr('data-category-id');
            $.ajax({
                url: base_url+"exam-categories/"+categoryId+"/edit",
                method: "GET",
                dataType: "JSON",
                success: function (data) {
                    console.log(data.note)
                    $('input[name="exam_category_id"]').val(data.exam_category_id);
                    $('input[name="name"]').val(data.name);
                    $('input[name="price"]').val(data.price);
                    $('input[name="xm_subscription_duration"]').val(data.xm_subscription_duration);
                    $('input[name="icon_class_code"]').val(data.icon_class_code);
                    if (data.status == 1)
                    {
                        $('input[name="status"]').attr('checked', true);
                    } else {
                        $('input[name="status"]').attr('checked', false);
                    }
                    if (data.is_master_exam == 1)
                    {
                        $('input[name="is_master_exam"]').attr('checked', true);
                    } else {
                        $('input[name="is_master_exam"]').attr('checked', false);
                    }
                    if (data.open_for_sale == 1)
                    {
                        $('input[name="open_for_sale"]').attr('checked', true);
                    } else {
                        $('input[name="open_for_sale"]').attr('checked', false);
                    }

                    $('#summernote').summernote('destroy');
                    $('textarea[name="description"]').html(data.note);
                    $("#summernote").summernote({height:70})
                    $('.submit-btn').addClass('update-btn').removeClass('submit-btn');
                    if (data.image != null)
                    {
                        $('#imagePreview').attr('src', data.image).css({height: '150px', width: '150px', marginTop: '5px', display: 'block'});
                    }
                    $('#courseCategoryForm').attr('action', base_url+'exam-categories/update/'+data.id);
                    $('#courseCategoryModal').modal('show');
                }
            })
        })
    </script>

    <script>
        // update course category
        // $(document).on('click', '.update-btn', function () {
        //     event.preventDefault();
        //     var form = $('#courseCategoryForm')[0];
        //     var formData = new FormData(form);
        //     $.ajax({
        //         url: $('#courseCategoryForm').attr('action'),
        //         method: "POST",
        //         data: formData,
        //         dataType: "JSON",
        //         async: false,
        //         cache: false,
        //         contentType: false,
        //         processData: false,
        //         // enctype: 'multipart/form-data',
        //         success: function (message) {
        //             toastr.success(message);
        //             $('.update-btn').addClass('submit-btn').removeClass('update-btn');
        //             $('#courseCategoryForm').attr('action', '');
        //             $('#courseCategoryModal').modal('hide');
        //             resetInputFields();
        //             window.location.reload();
        //         }
        //     })
        // })
    </script>
{{--    <script>--}}
{{--        $(document).on('change', '#nestable-wrapper', function () {--}}
{{--            setTimeout(function () {--}}
{{--                var data = $('#nestedCategoryOrderForm').serialize();--}}
{{--                $.ajax({--}}
{{--                    url: "{{ route('examCategories.saveNestedCategories') }}",--}}
{{--                    method: "POST",--}}
{{--                    data: data,--}}
{{--                    dataType: "JSON",--}}
{{--                    success: function (message) {--}}
{{--                        console.log(message);--}}
{{--                        toastr.success(message);--}}
{{--                    }--}}
{{--                })--}}
{{--            }, 800)--}}
{{--        })--}}
{{--    </script>--}}



{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.3.2/tinymce.min.js" integrity="sha512-9w/jRiVYhkTCGR//GeGsRss1BJdvxVj544etEHGG1ZPB9qxwF7m6VAeEQb1DzlVvjEZ8Qv4v8YGU8xVPPgovqg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>--}}
{{--    <script>--}}
{{--        tinymce.init({--}}
{{--            selector: 'textarea#elm1',--}}
{{--            height: 200,--}}
{{--            menubar: false,--}}
{{--            plugins: [--}}
{{--                'advlist autolink lists link image charmap print preview anchor',--}}
{{--                'searchreplace visualblocks code fullscreen',--}}
{{--                'insertdatetime media table paste code help wordcount'--}}
{{--            ],--}}
{{--            toolbar: 'undo redo | formatselect | ' +--}}
{{--                'bold italic backcolor | alignleft aligncenter ' +--}}
{{--                'alignright alignjustify | bullist numlist outdent indent | ' +--}}
{{--                'removeformat | help',--}}
{{--            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'--}}
{{--        });--}}
{{--    </script>--}}


    <script>
        $(document).ready(function() {
            $('#categoryImage').change(function() {
                var imgURL = URL.createObjectURL(event.target.files[0]);
                $('#imagePreview').attr('src', imgURL).css({
                    height: 150+'px',
                    width: 150+'px',
                    marginTop: '5px',
                    display: 'block'
                });
            });
        });
    </script>
@endpush
