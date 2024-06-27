@extends('backend.master')

@section('title', 'Product Authors')

@section('body')
    <div class="row py-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">Service</h4>
{{--                    @can('create-product')--}}
{{--                        <button type="button" class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4 product-category-modal-btn"><i class="fa-solid fa-circle-plus"></i></button>--}}
{{--                    @endcan--}}
                </div>
                <div class="card-body">
                    <table class="table" id="file-datatable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Service</th>
                            <th>User</th>
                            <th>order_invoice_number</th>
                            <th>Complain</th>
                            <th>Service Status</th>
                            {{--                            <th>Stock</th>--}}
                            {{--                            <th>Image</th>--}}
                            <th>Admin Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($services))
                            @foreach($services as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $product->complainIssuedBy->name }}</td>
                                    <td>{{ $product->studentUser->name }}</td>
                                    <td>{{ $product->parentOrder->order_invoice_number }}</td>
                                    <td>{{ $product->complain_text }}</td>
                                    <td>{{ $product->status }}</td>
                                    <td>{{ $product->admin_status }}</td>
{{--                                    <td>--}}
{{--                                        <select class="form-select" name="status" aria-label="Default select example">--}}
{{--                                            <option value="{{ $product->admin_status }}"  selected>{{ $product->admin_status }}</option>--}}
{{--                                            <option value="pending">pending</option>--}}
{{--                                            <option value="satisfy">satisfy</option>--}}
{{--                                            <option value="not_satisfy">not_satisfy</option>--}}
{{--                                        </select>--}}
{{--                                    </td>--}}

                                    <td>
                                        @can('admin-service-status-edit')
                                            <a href="" data-service-id="{{ $product->id }}" class="btn btn-sm btn-primary service-edit-btn mt-1" title="Change Order Status">
                                                <i class="fa-solid fa-edit"></i>
                                            </a>
                                        @endcan
                                        @can('delete-service-complain')
                                            <form class="d-inline" action="{{ route('my_services.destroy', $product->id) }}" method="post">
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

    <div class="modal fade modal-div" id="blogCategoryCourseModal" data-modal-parent="blogCategoryCourseModal" data-bs-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" id="">
                <form id="courseServiceForm" action="" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="">Update Admin Service Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body">

                        <div class="card card-body">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6 select2-div">
                                    <label for="paymentStatus">Service Status</label>
                                    <select name="status" class="form-control select2" id="" data-placeholder="Set service Status">
                                        <option value=""></option>
                                        <option value="pending">pending</option>
                                        <option value="complete">complete</option>
                                        <option value="processing">processing</option>
                                        <option value="canceled">canceled</option>
                                    </select>
                                </div>
                                <div class="col-sm-6 select2-div">
                                    <label for="paymentStatus">Admin Status</label>
                                    <select name="admin_status" class="form-control select2" id="" data-placeholder="Set Admin Status">
                                        <option value=""></option>
                                        <option value="pending">pending</option>
                                        <option value="satisfy">satisfy</option>
                                        <option value="not_satisfy">not_satisfy</option>
                                    </select>
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

        {{--$(function () {--}}
        {{--    $('#dateTime1').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm', minDate : new Date()});--}}
        {{--    $('#summernote1').summernote();--}}
        {{--    $('#summernote2').summernote();--}}
        {{--    $('#summernote3').summernote();--}}
        {{--    @if($errors->any())--}}
        {{--    $('#blogCategoryModal').modal('show');--}}
        {{--    @endif--}}
        {{--});--}}
        {{--$(document).on('click', '.product-category-modal-btn', function () {--}}
        {{--    event.preventDefault();--}}
        {{--    // resetInputFields();--}}
        {{--    if ($('input[name="_method"]').length)--}}
        {{--    {--}}
        {{--        $('input[name="_method"]').remove();--}}
        {{--    }--}}
        {{--    $('#courseSectionForm').attr('action', "{{ route('products.store') }}");--}}
        {{--    $('#blogCategoryModal').modal('show');--}}
        {{--})--}}
    </script>
    <script>
        $(document).on('click', '.service-edit-btn', function () {
            event.preventDefault();
            var serviceId = $(this).attr('data-service-id'); //change value
            // alert(productCategoryId);
            $.ajax({
                url: base_url+"adminservice/"+serviceId+"/edit",
                method: "GET",
                dataType: "JSON",
                success: function (data) {
                    console.log(data);
                    // if (data.paid_amount > 0)
                    // {
                    //     $('input[name="paid_amount"]').val(data.paid_amount);
                    // } else {
                    //     $('input[name="paid_amount"]').val(data.total_amount);
                    // }
                    // $('input[name="paid_amount"]').attr('data-total-amount', data.total_amount);
                    // $.each($('select[name="payment_status"] option'), function (paymentIndex, payment) {
                    //     if ($(this).val() == data.payment_status)
                    //     {
                    //         $(this).attr('selected', true);
                    //     }
                    // })
                    $.each($('select[name="admin_status"] option'), function (contactIndex, contact) {
                        if ($(this).val() == data.admin_status)
                        {
                            $(this).attr('selected', true);
                        }
                    })
                    $.each($('select[name="status"] option'), function (contactIndex, contact) {
                        if ($(this).val() == data.status)
                        {
                            $(this).attr('selected', true);
                        }
                    })
                    // $.each($('select[name="status"] option'), function (statusIndex, status) {
                    //     if ($(this).val() == data.status)
                    //     {
                    //         $(this).attr('selected', true);
                    //     }
                    // })
                    $(".select2").select2({
                        minimumResultsForSearch: "",
                        width: "100%",

                    })
                    $('#courseServiceForm').attr('action', base_url+"admin_status_update/"+serviceId);
                    $('#blogCategoryCourseModal').modal('show');
                }
            })
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
                                option += '<option value="'+val.id+'">'+val.title+'</option>';
                            }else if(data.old_seofor == 'batch_exam_category'){
                                option += '<option value="'+val.id+'">'+val.title+'</option>';
                            }else if(data.old_seofor == 'product_category'){
                                option += '<option value="'+val.id+'">'+val.name+'</option>';
                            }else if(data.old_seofor == 'blog_category'){
                                option += '<option value="'+val.id+'">'+val.name+'</option>';
                            }else if(data.old_seofor == 'product_category'){
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


@endpush
