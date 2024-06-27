@extends('backend.master')

@section('title', 'Product Authors')

@section('body')
    <div class="row py-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">SEO</h4>
                    @can('create-product')
                        <button type="button" class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4 product-category-modal-btn"><i class="fa-solid fa-circle-plus"></i></button>
                    @endcan
                </div>
                <div class="card-body">


                    <table class="table" id="file-datatable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>seo_for</th>
                            <th>parent_model_id</th>
                            <th>custom_page_link</th>
                            <th>meta_keywords</th>
                            <th>mata_tags</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($seos))
                            @foreach($seos as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $product->seo_for }}</td>
                                    @if($product->seo_for == 'course')
                                        <td>{{ $product->course->title }}</td>
                                    @elseif($product->seo_for == 'batch_exam')
                                        <td>{{ $product->batchExam->title }}</td>
                                    @elseif($product->seo_for == 'product')
                                        <td>{{ $product->product->title }}</td>
                                    @elseif($product->seo_for == 'blog')
                                        <td>{{ $product->blog->title }}</td>
                                    @elseif($product->seo_for == 'course_category')
                                        <td>{{ $product->courseCategory->title }}</td>
                                    @elseif($product->seo_for == 'batch_exam_category')
                                        <td>{{ $product->batchExamCategory->title }}</td>
                                    @elseif($product->seo_for == 'product_category')
                                        <td>{{ $product->productCategory->title }}</td>
                                    @elseif($product->seo_for == 'blog_category')
                                        <td>{{ $product->blogCategory->title }}</td>
                                    @else
                                        <td>-------</td>
                                    @endif
                                    @if(isset( $product->custom_page_link))
                                        <td>{{ $product->custom_page_link }}</td>
                                    @else
                                        <td>-------</td>
                                    @endif
                                    <td>{{ $product->meta_keywords}}</td>
                                    <td>{{ $product->meta_tags }}</td>
                                    <td>
                                        <a href="javascript:void(0)" class="badge bg-primary">{{ $product->status == 1 ? 'Published' : 'Unpublished' }}</a>
{{--                                        <a href="javascript:void(0)" class="badge bg-primary">{{ $product->is_featured == 1 ? 'Featured' : 'Not Featured' }}</a>--}}
                                    </td>
                                    <td>
                                        @can('edit-product')
                                            <a href="{{route('seos.edit',$product->id)}}"  class="btn btn-sm btn-warning product-category-edit-btn" title="Edit Blog Category">
                                                <i class="fa-solid fa-edit"></i>
                                            </a>
                                        @endcan
                                        @can('delete-product')
                                            <form class="d-inline" action="{{ route('seos.destroy', $product->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-danger data-delete-form" title="Delete Category">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-div" id="blogCategoryModal" data-modal-parent="blogCategoryModal" data-bs-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" id="">
                <form id="" action="{{ route('seos.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="">Create SEO</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="card card-body">
                            <div class="row mt-2">
                                <div class="col-md-7 mt-2 select2-div">
                                    <label for="">SEO For</label>
                                    <select name="seo_for" required id="seofor" class="form-control select2"  data-placeholder="Select SEO for" >
                                        <option >Select a option</option>
                                        <option value="course">course</option>
                                        <option value="batch_exam">batch_exam</option>
                                        <option value="product">product</option>
                                        <option value="blog">blog</option>
                                        <option value="course_category">course_category</option>
                                        <option value="batch_exam_category">batch_exam_category</option>
                                        <option value="product_category">product_category</option>
                                        <option value="blog_category">blog_category</option>
                                        <option value="custom_page">custom_page</option>
                                    </select>
                                    <span class="text-danger">{{ $errors->has('seofor') ? $errors->first('seofor') : '' }}</span>
                                </div>
                                <div class="col-md-5 mt-2 select2-div" id="parent_model_div" >
                                    <label for="">parent_model</label>
                                    <select name="parent_model_id" id="parent_model_id"  class="form-control select2 js-example-basic-single"  data-placeholder="Select"  >
                                        <option disabled>Author Name</option>
                                    </select>
                                    <span class="text-danger">{{ $errors->has('parent_model_id') ? $errors->first('parent_model_id') : '' }}</span>
                                </div>
                                <div class="col-md-12 mt-2" id="custom_page_link_div" >
                                    <label for="">Custom Page link</label>
                                    <input type="text"  name="custom_page_link"  class="form-control" placeholder="custom_page_link" />
                                    <span class="text-danger">{{ $errors->has('custom_page_link') ? $errors->first('custom_page_link') : '' }}</span>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <label for="">Meta Keyword</label>
                                    <input type="text"  name="meta_keywords" class="form-control" placeholder="meta_keywords"  />
                                    <span class="text-danger">{{ $errors->has('meta_keywords') ? $errors->first('meta_keywords') : '' }}</span>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <label for="">Meta Tags</label>
                                    <input data-role="tagsinput" type="text"  name="meta_tags" class="form-control taginput " placeholder="meta_tags" />
                                    <span class="text-danger">{{ $errors->has('meta_tags') ? $errors->first('meta_tags') : '' }}</span>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <label for="">Slug</label>
                                    <input type="text"  name="slug" class="form-control" placeholder="Slug"  />
                                    <span class="text-danger">{{ $errors->has('slug') ? $errors->first('slug') : '' }}</span>
                                </div>
                                <div class="col-md-12 mt-2 mb-2">
                                    <label for="">Meta Description</label>
                                    <textarea name="meta_description" class="form-control" id="meta_description" placeholder="meta_description" cols="30" rows="5"></textarea>
                                    <span class="text-danger">{{ $errors->has('meta_description') ? $errors->first('meta_description') : '' }}</span>
                                </div>
                                <div class="col-md-12 mt-2 mb-2">
                                    <label for="">meta_image_description</label>
                                    <textarea name="meta_image_description" class="form-control" id="meta_image_description" placeholder="meta_image_description" cols="30" rows="5"></textarea>
                                    <span class="text-danger">{{ $errors->has('meta_image_description') ? $errors->first('meta_image_description') : '' }}</span>
                                </div>
                                <div class="col-md-4 mt-3">
                                    <label for="">Status</label>
                                    <div class="material-switch">
                                        <input id="someSwitchOptionInfo" name="status" type="checkbox" checked />
                                        <label for="someSwitchOptionInfo" class="label-info"></label>
                                    </div>
                                    <span class="text-danger">{{ $errors->has('status') ? $errors->first('status') : '' }}</span>
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

    </style>
@endpush

@push('script')

    @include('backend.includes.assets.plugin-files.datatable')

    <script>
        $('input').tagsinput({
            typeahead: {
                source: function(query) {
                    return $.getJSON('citynames.json');
                }
            }
        });
    </script>
    <script>

        $(function () {
            $('#dateTime1').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm', minDate : new Date()});
            $('#summernote1').summernote();
            $('#summernote2').summernote();
            $('#summernote3').summernote();
            @if($errors->any())
            $('#blogCategoryModal').modal('show');
            @endif
        });
        $(document).on('click', '.product-category-modal-btn', function () {
            event.preventDefault();
            // resetInputFields();
            if ($('input[name="_method"]').length)
            {
                $('input[name="_method"]').remove();
            }
            $('#courseSectionForm').attr('action', "{{ route('products.store') }}");
            $('#blogCategoryModal').modal('show');
        })
    </script>
    <script>
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });

        $(document).on('change','#seofor',function (){
            $seofor=$(this).val();
            if ($seofor == 'custom_page'){
                $('#custom_page_link_div').removeClass('d-none').attr('data-active', '');
                $('#parent_model_div').addClass('d-none').attr('data-active', '');
            }else {
                $('#custom_page_link_div').addClass('d-none').attr('data-active', '');
                $('#parent_model_div').removeClass('d-none').attr('data-active', '');
                $.ajax({
                    url:base_url+"select_seofor/"+$seofor,
                    method:'GET',
                    datatype:'json',
                    success:function (data){
                        // console.log(data.old_seofor);
                        var option = '';

                        $.each(data.data,function (key,val){
                            if (data.old_seofor == 'course'){
                                option += '<option value="'+val.id+'">'+val.title+'</option>';
                            }else if(data.old_seofor == 'batch_exam'){
                                option += '<option value="'+val.id+'">'+val.title+'</option>';
                            }else if(data.old_seofor == 'product'){
                                option += '<option value="'+val.id+'">'+val.title+'</option>';
                            }else if(data.old_seofor == 'blog'){
                                option += '<option value="'+val.id+'">'+val.title+'</option>';
                            }else if(data.old_seofor == 'course_category'){
                                option += '<option value="'+val.id+'">'+val.name+'</option>';
                            }else if(data.old_seofor == 'batch_exam_category'){
                                option += '<option value="'+val.id+'">'+val.name+'</option>';
                            }else if(data.old_seofor == 'product_category'){
                                option += '<option value="'+val.id+'">'+val.name+'</option>';
                            }else if(data.old_seofor == 'blog_category'){
                                option += '<option value="'+val.id+'">'+val.name+'</option>';
                            }

                        });

                        $('#parent_model_id').empty().append(option).select2({
                            tags: true
                        });
                    }
                })
            }
        })
    </script>
@endpush
