
@extends('backend.master')

@section('title', 'teachers')

@section('body')
<div class="row py-5">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-warning">
                <h4 class="float-start text-white">Teachers</h4>
                {{--                    @can('create-product')--}}
                {{--                        <button type="button" class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4 product-category-modal-btn"><i class="fa-solid fa-circle-plus"></i></button>--}}
                {{--                    @endcan--}}
            </div>
            <div class="card-body">


                <table class="table" id="file-datatable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>User name</th>
                        <th>Full name</th>
{{--                        <th>Last name</th>--}}
                        <th>Designation</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($teachers))
                        @foreach($teachers as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $product->user->name }}</td>
                                <td>{{ $product->first_name }} {{ $product->last_name }}</td>
                                <td>{{ $product->subject }}</td>
                                <td>{{ $product->email }}</td>
                                <td>{{ $product->mobile }}</td>
                                <td>
                                    <img src="{{asset($product->image)}}" alt="" style="height: 100px;width: 100px">
                                </td>
{{--                                <td>--}}
{{--                                    <a href="javascript:void(0)" class="badge bg-primary">{{ $product->status == 1 ? 'Published' : 'Unpublished' }}</a>--}}
{{--                                    --}}{{--                                        <a href="javascript:void(0)" class="badge bg-primary">{{ $product->is_featured == 1 ? 'Featured' : 'Not Featured' }}</a>--}}
{{--                                </td>--}}
                                <td>
{{--                                    @can('edit-product')--}}
                                        <a href="{{route('teachers_profile.edit',$product->id)}}"  class="btn btn-sm btn-warning product-category-edit-btn" title="Edit Blog Category">
                                            <i class="fa-solid fa-edit"></i>
                                        </a>
{{--                                    @endcan--}}
{{--                                    @can('delete-product')--}}
{{--                                        <form class="d-inline" action="{{ route('teachers_profile.destroy', $product->id) }}" method="post">--}}
{{--                                            @csrf--}}
{{--                                            @method('delete')--}}
{{--                                            <button type="submit" class="btn btn-sm btn-danger data-delete-form" title="Delete Category">--}}
{{--                                                <i class="fa-solid fa-trash"></i>--}}
{{--                                            </button>--}}
{{--                                        </form>--}}
{{--                                    @endcan--}}
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
                                {{--                                    <select name="product_category_id[]" required id="productCategories" class="form-control select2" multiple data-placeholder="Select Product Categories" >--}}
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
                                        <option value="product_category">product_category</option>
                                        <option value="custom_page">custom_page</option>
                                        {{--                                        @foreach($productCategories as $productCategory)--}}
                                        {{--                                            <option value="{{ $productCategory->id }}">{{ $productCategory->name }}</option>--}}
                                        {{--                                        @endforeach--}}
                                    </select>
                                    <span class="text-danger">{{ $errors->has('seofor') ? $errors->first('seofor') : '' }}</span>
                            </div>
                            <div class="col-md-5 mt-2 select2-div" id="parent_model_div" >
                                <label for="">parent_model</label>
                                <select name="parent_model_id" id="parent_model_id"  class="form-control select2 js-example-basic-single"  data-placeholder="Select"  >
                                    <option disabled>Author Name</option>
                                    {{--                                        <option >Name1</option>--}}
                                    {{--                                        <option >Name2</option>--}}
                                    {{--                                        @foreach($productAuthors as $productAuthor)--}}
                                    {{--                                            <option value="{{ $productAuthor->id }}">{{ $productAuthor->name }}</option>--}}
                                    {{--                                        @endforeach--}}
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
                                {{--                                    <img src="" id="imagePreview" alt="">--}}
                            </div>
                            <div class="col-md-4 mt-2">
                                <label for="">Meta Tags</label>
                                <input data-role="tagsinput" type="text"  name="meta_tags" class="form-control taginput " placeholder="meta_tags" />
                                <span class="text-danger">{{ $errors->has('meta_tags') ? $errors->first('meta_tags') : '' }}</span>
                                {{--                                    <img src="" id="imagePreview" alt="">--}}
                            </div>
                            <div class="col-md-4 mt-2">
                                <label for="">Slug</label>
                                <input type="text"  name="slug" class="form-control" placeholder="Slug"  />
                                <span class="text-danger">{{ $errors->has('slug') ? $errors->first('slug') : '' }}</span>
                                {{--                                    <img src="" id="imagePreview" alt="">--}}
                            </div>
                            {{--                                <div class="col-md-4 mt-2">--}}
                                {{--                                    <label for="">Featured PDF</label>--}}
                                {{--                                    <input type="file"  name="featured_pdf" class="form-control" placeholder="Featured PDF" accept="application/pdf" />--}}
                                {{--                                    <span class="text-danger">{{ $errors->has('featured_pdf') ? $errors->first('featured_pdf') : '' }}</span>--}}
                                {{--                                    <a href="" id="pdfPreview" >download</a>--}}
                                {{--                                </div>--}}
                            {{--                                <div class="col-md-4 mt-2">--}}
                                {{--                                    <label for="">Book PDF</label>--}}
                                {{--                                    <input type="file"  name="pdf" class="form-control" placeholder="Featured PDF" accept="application/pdf" />--}}
                                {{--                                    <span class="text-danger">{{ $errors->has('pdf') ? $errors->first('pdf') : '' }}</span>--}}
                                {{--                                    <a href="" id="bookPdfPreview" >download</a>--}}
                                {{--                                </div>--}}
                            {{--                                <div class="col-md-4 mt-2">--}}
                                {{--                                    <label for="">Price</label>--}}
                                {{--                                    <input type="number" required name="price" class="form-control" placeholder="price" />--}}
                                {{--                                    <span class="text-danger">{{ $errors->has('price') ? $errors->first('price') : '' }}</span>--}}
                                {{--                                </div>--}}
                            {{--                                <div class="col-md-4 mt-2">--}}
                                {{--                                    <label for="">Stock Amount</label>--}}
                                {{--                                    <input type="text" required name="stock_amount" class="form-control" placeholder="Stock Amount" />--}}
                                {{--                                    <span class="text-danger">{{ $errors->has('stock_amount') ? $errors->first('stock_amount') : '' }}</span>--}}
                                {{--                                </div>--}}
                            {{--                                <div class="col-md-4 mt-2">--}}
                                {{--                                    <label for="">Affiliate Amount</label>--}}
                                {{--                                    <input type="text" class="form-control" name="affiliate_amount" placeholder="Affiliate Amount" />--}}
                                {{--                                    <span class="text-danger" id="affiliate_amount"></span>--}}
                                {{--                                </div>--}}
                            {{--                                <div class="col-md-4 mt-2 d-none">--}}
                                {{--                                    <label for="">Discount Type</label>--}}
                                {{--                                    <select name="discount_type" id="" class="form-control">--}}
                                    {{--                                        <option value="1" selected>Fixed</option>--}}
                                    {{--                                        <option value="2" >Percentage</option>--}}
                                    {{--                                    </select>--}}
                                {{--                                    <span class="text-danger">{{ $errors->has('discount_type') ? $errors->first('discount_type') : '' }}</span>--}}
                                {{--                                </div>--}}
                            {{--                                <div class="col-md-4 mt-2">--}}
                                {{--                                    <label for="">Discount Amount</label>--}}
                                {{--                                    <input type="text" id="discountAmount" name="discount_amount" class="form-control" placeholder="discount Amount" />--}}
                                {{--                                    <span class="text-danger" id="discount_amount">{{ $errors->has('discount_amount') ? $errors->first('discount_amount') : '' }}</span>--}}
                                {{--                                </div>--}}
                            {{--                                <div class="col-md-4 mt-2">--}}
                                {{--                                    <label for="">Discount Start Date</label>--}}
                                {{--                                    <input type="text"  name="discount_start_date" id="dateTime" data-dtp="dtp_Nufud"  class="form-control" placeholder="discount Start Date" />--}}
                                {{--                                    <span class="text-danger">{{ $errors->has('discount_start_date') ? $errors->first('discount_start_date') : '' }}</span>--}}
                                {{--                                </div>--}}
                            {{--                                <div class="col-md-4 mt-2">--}}
                                {{--                                    <label for="">Discount End Date</label>--}}
                                {{--                                    <input type="text"  name="discount_end_date" id="dateTime1" data-dtp="dtp_Nufud" class="form-control" placeholder="discount End Date" />--}}
                                {{--                                    <span class="text-danger">{{ $errors->has('discount_end_date') ? $errors->first('discount_end_date') : '' }}</span>--}}
                                {{--                                </div>--}}


                            {{--                                <div class="col-md-12 mt-2">--}}
                                {{--                                    <label for="">About</label>--}}
                                {{--                                    <textarea name="about" id="summernote3"  placeholder="about" class="form-control" cols="30" rows="5"></textarea>--}}
                                {{--                                    <span class="text-danger">{{ $errors->has('about') ? $errors->first('about') : '' }}</span>--}}
                                {{--                                </div>--}}

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
                            {{--                                <div class="col-md-12 mt-2 mb-2">--}}
                                {{--                                    <label for="">Other Details</label>--}}
                                {{--                                    <textarea name="other_details" class="form-control" id="summernote2" placeholder="other details" cols="30" rows="5"></textarea>--}}
                                {{--                                    <span class="text-danger">{{ $errors->has('other_details') ? $errors->first('other_details') : '' }}</span>--}}
                                {{--                                </div>--}}

                            {{--                                <div class="col-md-4 mt-3">--}}
                                {{--                                    <label for="">is Featured</label>--}}
                                {{--                                    <div class="material-switch">--}}
                                    {{--                                                                                <label for="featuredChecked"><input type="radio" name="is_featured" id="featuredChecked" value="on" checked>Featured</label>--}}
                                    {{--                                                                                <label for="featuredNotChecked"><input type="radio" name="is_featured" id="featuredNotChecked" value="">Not Featured</label>--}}
                                    {{--                                        <input id="someSwitchOptionInfo1" name="is_featured" type="checkbox" checked />--}}
                                    {{--                                        <label for="someSwitchOptionInfo1" class="label-info"></label>--}}
                                    {{--                                    </div>--}}
                                {{--                                    <span class="text-danger">{{ $errors->has('is_featured') ? $errors->first('is_featured') : '' }}</span>--}}
                                {{--                                </div>--}}
                            <div class="col-md-4 mt-3">
                                <label for="">Status</label>
                                <div class="material-switch">
                                    {{--                                        <label for="statusChecked"><input type="radio" name="status" id="statusChecked" value="on" checked>Published</label>--}}
                                    {{--                                        <label for="statusNotChecked"><input type="radio" name="status" id="statusNotChecked" value="">Not Published</label>--}}
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
{{--    @include('backend.includes.assets.plugin-files.date-time-picker')--}}
{{--    @include('backend.includes.assets.plugin-files.editor')--}}
{{--    store course--}}

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
            // $('#custom_page_link_div').addClass
            // $('#parent_model_div').hide()
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
                    // document.querySelector('.select2-search__field').focus();
                }
            })
        }
        // alert($seofor);

    })
</script>

{{--    edit course category--}}


{{--    <script>--}}
    {{--        $(document).ready(function() {--}}
        {{--            $('#image').change(function() {--}}
            {{--                var imgURL = URL.createObjectURL(event.target.files[0]);--}}
            {{--                $('#imagePreview').attr('src', imgURL).css({--}}
                {{--                    height: 150+'px',--}}
                {{--                    width: 150+'px',--}}
                {{--                    marginTop: '5px'--}}
                {{--                });--}}
            {{--            });--}}
        {{--        });--}}
    {{--    </script>--}}

{{--    <script>--}}
    {{--        $('#courseSectionForm').submit(function () {--}}
        {{--            event.preventDefault();--}}
        {{--            var discountAmount = Number($('input[name="discount_amount"]').val());--}}
        {{--            if(discountAmount != '')--}}
        {{--            {--}}
            {{--                var price = Number($('input[name="price"]').val());--}}
            {{--                if (discountAmount > price)--}}
            {{--                {--}}
                {{--                    $('#discount_amount').text('Discount amount should be lower then Price.');--}}
                {{--                    return false;--}}
                {{--                }--}}
            {{--            }--}}
        {{--            document.getElementById('courseSectionForm').submit();--}}
        {{--        });--}}
    {{--    </script>--}}

{{--    <script>--}}
    {{--        $(document).on('keyup', '#discountAmount', function () {--}}
        {{--            var discountAmount = Number($(this).val());--}}
        {{--            var discountType = $('select[name="discount_type"]').val();--}}
        {{--            var price = Number($('input[name="price"]').val());--}}
        {{--            var discountErrorMsg = $('#discount_amount');--}}
        {{--            // console.log('price-'+price);--}}
            {{--            // console.log('d-a-'+discountAmount);--}}
            {{--            if (discountType == '')--}}
            {{--            {--}}
                {{--                toastr.error('Please select a Discount type.');--}}
                {{--                return false;--}}
                {{--            }--}}
            {{--            if (discountType == 1)--}}
            {{--            {--}}
                {{--                if (discountAmount > price)--}}
                {{--                {--}}
                    {{--                    discountErrorMsg.empty().append('Discount can\'t be greater then Price');--}}
                    {{--                }else if (discountAmount <= price){--}}
                    {{--                    discountErrorMsg.empty();--}}
                    {{--                }--}}
                {{--            } else if (discountType == 2)--}}
            {{--            {--}}
                {{--                if (discountAmount > 100)--}}
                {{--                {--}}
                    {{--                    discountErrorMsg.empty().append('Discount can\'t be greater then 100%');--}}
                    {{--                }else if (discountAmount <= 100){--}}
                    {{--                    discountErrorMsg.empty();--}}
                    {{--                }--}}
                {{--            }--}}
            {{--        })--}}
            {{--    </script>--}}
{{--    <script>--}}
    {{--        $(document).on('keyup', 'input:not(#discountAmount),textarea', function () {--}}
        {{--            var selectorId = $(this).attr('name');--}}
        {{--            if ($('#'+selectorId).text().length)--}}
        {{--            {--}}
            {{--                $('#'+selectorId).text('');--}}
            {{--            }--}}
        {{--        })--}}
    {{--        $(document).on('change', 'select', function () {--}}
        {{--            var selectorId = $(this).attr('name');--}}
        {{--            if ($('#'+selectorId).text().length)--}}
        {{--            {--}}
            {{--                $('#'+selectorId).text('');--}}
            {{--            }--}}
        {{--        })--}}
    {{--    </script>--}}

@endpush
