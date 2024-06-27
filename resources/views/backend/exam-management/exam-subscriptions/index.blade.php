@extends('backend.master')

@section('title', 'Exam Subscriptions')

@section('body')
    <div class="row py-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">Exam Subscriptions</h4>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#courseCategoryModal" class="rounded-circle open-modal text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4"><i class="fa-solid fa-circle-plus"></i></button>
                </div>
                <div class="card-body">

                    <table class="table" id="file-datatable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Banner</th>
                            <th>Valid From</th>
                            <th>Valid To</th>
                            <th>Total Ordered</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($subscriptions))
                            @foreach($subscriptions as $subscription)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $subscription->name }}</td>
                                    <td>{{ $subscription->price }}</td>
                                    <td>
                                        <img src="{{ asset($subscription->banner) }}" alt="" style="height: 60px">
                                    </td>
                                    <td>{{ $subscription->valid_form }}</td>
                                    <td>{{ $subscription->valid_to }}</td>
                                    <td>{{ $subscription->sell_qtn }}</td>
                                    <td>
                                        <a href="javascript:void(0)" class="badge bg-primary change-status" data-id="{{ $subscription->id }}">{{ $subscription->status == 1 ? 'Published' : 'Unpublished' }}</a>
                                    </td>
                                    <td>
                                        {{--                                            <a href="{{ route('course-section-contents.index', ['section_id' => $subscription->id]) }}" data-course-section-id="{{ $subscription->id }}" class="btn btn-sm btn-success content-add-btn" title="Edit Course">--}}
                                        {{--                                                <i class="fa-solid fa-circle-plus"></i>--}}
                                        {{--                                            </a>--}}
                                        <a href="" data-course-section-id="{{ $subscription->id }}" class="btn btn-sm btn-warning course-section-edit-btn" title="Edit Exam Subscription">
                                            <i class="fa-solid fa-edit"></i>
                                        </a>
                                        <form class="d-inline" action="{{ route('exam-subscriptions.destroy', $subscription->id) }}" method="post" onsubmit="return confirm('Are you sure to delete this? Once deleted, It can not be undone.')">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete Exam Subscription">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
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
    <div class="modal fade modal-div" data-bs-backdrop="static" id="courseCategoryModal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable-body">
            <div class="modal-content">
                <form action="{{ route('exam-subscriptions.store') }}" method="post" enctype="multipart/form-data" id="courseCategoryForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Exam Subscription Package</h5>
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
{{--                    <input type="hidden" name="category_id" >--}}
                    <div class="modal-body">
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Name" />
                            </div>
                            <div class="col-md-6 position-relative">
                                <label for="price">Price</label>
                                <input type="text" name="price" class="form-control" placeholder="Price">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label for="">Valid From</label>
                                <input type="text" name="valid_form" id="dateTime" data-dtp="dtp_Nufud" class="form-control" placeholder="Valid From" />
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="">Valid To</label>
                                <input type="text" name="valid_to" id="dateTime1" data-dtp="dtp_Nufud" class="form-control" placeholder="Valid To" />
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="">Banner</label>
                                <input type="file" name="banner" id="categoryImage" accept="images/*">
                            </div>
                            <div class="col-md-6 mt-2">
                                <div>
                                    <img src="" id="imagePreview" style=""/>
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
    <style>
        #imagePreview {
            display: none;
        }
    </style>
@endpush

@push('script')
    @include('backend.includes.assets.plugin-files.datatable')
    @include('backend.includes.assets.plugin-files.date-time-picker')
    {{--    @include('backend.includes.assets.plugin-files.editor')--}}
    <script>
        $(function () {
            $('#dateTime').bootstrapMaterialDatePicker({
                format: 'YYYY-MM-DD HH:mm',
                minDate : new Date(),
            });
            $('#dateTime1').bootstrapMaterialDatePicker({
                format: 'YYYY-MM-DD HH:mm',
                minDate : new Date(),
            });
        })
    </script>

    <script>
        {{--    change Status--}}
        // $(document).on('click', '.change-status', function () {
        //     event.preventDefault();
        //     var subscriptionId = $(this).attr('data-id');
        //     $.ajax({
        //         url: base_url+"exam-subscriptions/"+subscriptionId,
        //         method: "GET",
        //         dataType: "JSON",
        //         success: function (message) {
        //
        //             if (message == 'pub')
        //             {
        //                 console.log(message);
        //                 $(this).text('Published');
        //                 toastr.success('Status changed to Published');
        //             } else if (message == 'unPub')
        //             {
        //                 console.log(message);
        //                 $(this).text('Unpublished');
        //                 toastr.success('Status changed to Unpublished');
        //             }
        //         }
        //     })
        // })
    </script>
    <script>
        {{--    edit course category--}}
        $(document).on('click', '.course-section-edit-btn', function () {
            event.preventDefault();
            var categoryId = $(this).attr('data-category-id');
            $.ajax({
                url: base_url+"exam-subscriptions/"+categoryId+"/edit",
                method: "GET",
                dataType: "JSON",
                success: function (data) {
                    console.log(data.note)
                    $('input[name="name"]').val(data.name);
                    $('input[name="price"]').val(data.price);
                    $('input[name="valid_form"]').val(data.valid_form);
                    $('input[name="valid_to"]').val(data.valid_to);
                    $('#dateTime').bootstrapMaterialDatePicker({
                        format: 'YYYY-MM-DD HH:mm',
                        minDate : new Date(),
                    });
                    $('#dateTime1').bootstrapMaterialDatePicker({
                        format: 'YYYY-MM-DD HH:mm',
                        minDate : new Date(),
                    });
                    $('.submit-btn').addClass('update-btn').removeClass('submit-btn');
                    if (data.banner != null)
                    {
                        $('#imagePreview').attr('src', data.banner).css({height: '150px', width: '150px', marginTop: '5px', display: 'block'});
                    }
                    $('#courseCategoryForm').attr('action', base_url+'exam-subscriptions/update/'+data.id);
                    $('#courseCategoryModal').modal('show');
                }
            })
        })
    </script>

    <script>
        // update course category
        $(document).on('click', '.open-modal', function () {
            event.preventDefault();
            $('#courseCategoryForm').attr('action', "{{ route('exam-subscriptions.store') }}");
            $('#courseCategoryModal').modal('show');
        })
    </script>

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
