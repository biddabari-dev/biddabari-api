@extends('backend.master')

@section('title', 'Model Test Categories')

@section('body')
    <div class="row py-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">Model Test Categories</h4>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#modelTestCategoryModal" class="rounded-circle open-modal text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4"><i class="fa-solid fa-circle-plus"></i></button>
                </div>
                <div class="card-body">
                    <table class="table" id="file-datatable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Sub Category Of</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($modelTestCategories))
                            @foreach($modelTestCategories as $modelTestCategory)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $modelTestCategory->name }}</td>
                                    @if($modelTestCategory->model_test_category_id != 0)
                                        <td>{{ $modelTestCategory->modelTestCategory->name }}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    <td>
                                        <img src="{{ asset($modelTestCategory->image) }}" alt="" style="height: 70px" />
                                    </td>
                                    <td>
                                        <a href="" class="badge badge-sm bg-primary">{{ $modelTestCategory->status == 1 ? 'Published' : 'Unpublished' }}</a>
                                    </td>
                                    <td>
                                        <button type="button" data-model-test-category-id="{{ $modelTestCategory->id }}" class="btn btn-sm btn-info add-sub-category-btn" title="Add Sub Category">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                        <button type="button" data-model-test-category-id="{{ $modelTestCategory->id }}" class="btn btn-sm btn-warning edit-model-test-category-btn" title="Edit Model Test Category">
                                            <i class="fa-solid fa-edit"></i>
                                        </button>
                                        <form class="d-inline" action="{{ route('model-test-categories.destroy', $modelTestCategory->id) }}" method="post" onsubmit="return confirm('Are you sure to delete this? Once deleted, It can not be undone.')">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete Model Test Category">
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
    <div class="modal fade modal-div" id="modelTestCategoryModal" data-bs-backdrop="static" data-modal-parent="coursesModal" >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" id="modalForm">
                @include('backend.model-test-management.model-test-category.form')
            </div>
        </div>
    </div>
@endsection

@push('script')
    {{--    datatable--}}
    @include('backend.includes.assets.plugin-files.datatable')

    <script>
        // image preview
        $(document).ready(function () {
            $('#image').change(function () {
                var imageURL = URL.createObjectURL(event.target.files[0]);
                $('#imagePreview').attr('src', imageURL).css({
                    height: '150px',
                    width: '150px',
                    marginTop: '5px',
                })
            })
        })
    </script>

    <script>
        // edit notice category
        $(document).on('click', '.edit-model-test-category-btn', function () {
            var modelTestCategoryId = $(this).attr('data-model-test-category-id');
            $.ajax({
                url: base_url+"model-test-categories/"+modelTestCategoryId+"/edit",
                method: "GET",
                success: function (data) {
                    console.log(data);
                    $('#modalForm').empty().append(data);

                    $('#image').change(function () {
                        var imageURL = URL.createObjectURL(event.target.files[0]);
                        $('#imagePreview').attr('src', imageURL).css({
                            height: '150px',
                            width: '150px',
                            marginTop: '0px',
                        })
                    });
                    $('#modelTestCategoryModal').modal('show');
                }
            })
        })
    </script>

    <script>
        // add sub category
        $(document).on('click', '.add-sub-category-btn', function () {
            var modelTestCategoryId = $(this).attr('data-model-test-category-id');
            $.ajax({
                url: base_url+"model-test-categories/add-sub-category/"+modelTestCategoryId,
                method: "GET",
                success: function (data) {
                    console.log(data);
                    $('#modalForm').empty().append(data);
                    $('#image').change(function () {
                        var imageURL = URL.createObjectURL(event.target.files[0]);
                        $('#imagePreview').attr('src', imageURL).css({
                            height: '150px',
                            width: '150px',
                            marginTop: '0px',
                        })
                    });
                    $('#modelTestCategoryModal').modal('show');
                }
            })
        })
    </script>
@endpush
