@extends('backend.master')

@section('title', 'Model Tests')

@section('body')
    <div class="row py-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">Model Tests</h4>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#modelTestModal" class="rounded-circle open-modal text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4"><i class="fa-solid fa-circle-plus"></i></button>
                </div>
                <div class="card-body">
                    <table class="table" id="file-datatable">
                        <thead>
                        <tr>
                            {{--                            <th>#</th>--}}
                            <th>Title</th>
                            <th>Category</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($modelTests))
                            @foreach($modelTests as $modelTest)
                                <tr>
                                    {{--                                    <td>{{ $loop->iteration }}</td>--}}
                                    <td>{{ $modelTest->title }}</td>
                                    <td>{{ $modelTest->modelTestCategory->name  }}</td>
                                    <td>
                                        <img src="{{ asset($modelTest->image) }}" alt="" style="height: 70px" />
                                    </td>
                                    <td>
                                        <a href="" class="badge badge-sm bg-primary">{{ $modelTest->status == 1 ? 'Published' : 'Unpublished' }}</a>
                                    </td>
                                    <td>
                                        <button type="button" data-model-test-id="{{ $modelTest->id }}" class="btn btn-sm btn-warning edit-model-test-btn" title="Edit Model Test">
                                            <i class="fa-solid fa-edit"></i>
                                        </button>
                                        <form class="d-inline" action="{{ route('model-tests.destroy', $modelTest->id) }}" method="post" onsubmit="return confirm('Are you sure to delete this? Once deleted, It can not be undone.')">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete Model Test">
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
    <div class="modal fade modal-div" id="modelTestModal" data-bs-backdrop="static" data-modal-parent="coursesModal" >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" id="modalForm">
                @include('backend.model-test-management.model-test.form')
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
        // edit notice
        $(document).on('click', '.edit-model-test-btn', function () {
            var modelTestId = $(this).attr('data-model-test-id');
            $.ajax({
                url: base_url+"model-tests/"+modelTestId+"/edit",
                method: "GET",
                success: function (data) {
                    console.log(data);
                    $('#modalForm').empty().append(data);
                    $('.select2').select2();
                    $('#image').change(function () {
                        var imageURL = URL.createObjectURL(event.target.files[0]);
                        $('#imagePreview').attr('src', imageURL).css({
                            height: '150px',
                            width: '150px',
                            marginTop: '0px',
                        })
                    });
                    $('#modelTestModal').modal('show');
                }
            })
        })
    </script>
@endpush
