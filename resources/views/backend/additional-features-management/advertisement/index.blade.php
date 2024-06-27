@extends('backend.master')

@section('title', 'Advertisements')

@section('body')
    <div class="row py-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">Advertisements</h4>
                    @can('create-advertisement')
                        <button type="button" data-bs-toggle="modal" data-bs-target="#advertisementModal" class="rounded-circle open-modal text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4"><i class="fa-solid fa-circle-plus"></i></button>
                    @endcan
                </div>
                <div class="card-body">
                    <table class="table" id="file-datatable">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Content Type</th>
                            <th>Description</th>
                            <th>Link</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($advertisements))
                            @foreach($advertisements as $advertisement)
                                <tr>
                                    {{--                                        <td>{{ $loop->iteration }}</td>--}}
                                    <td>{{ $advertisement->title }}</td>
                                    <td>{{ $advertisement->content_type }}</td>
                                    <td>{!! str()->words(strip_tags($advertisement->description), 30) !!}</td>
                                    <td><a href="{{ $advertisement->link }}" target="_blank">Page Link</a></td>
                                    <td>
                                        <img src="{{ asset($advertisement->image) }}" alt="" style="height: 70px" />
                                    </td>
                                    <td>
                                        <a href="" class="badge badge-sm bg-primary">{{ $advertisement->status == 1 ? 'Published' : 'Unpublished' }}</a>
                                    </td>
                                    <td>
                                        @can('edit-advertisement')
                                        <a data-advertisement-id="{{ $advertisement->id }}" class="btn btn-sm btn-warning edit-btn" title="Edit Advertisement">
                                            <i class="fa-solid fa-edit"></i>
                                        </a>
                                        @endcan
                                        @can('delete-advertisement')
                                        <form class="d-inline" action="{{ route('advertisements.destroy', $advertisement->id) }}" method="post" >
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger data-delete-form" title="Delete Advertisement">
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
    <div class="modal fade modal-div" id="advertisementModal" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" id="modalForm">
                @include('backend.additional-features-management.advertisement.form')
            </div>
        </div>
    </div>
@endsection

@push('script')
    {{--    datatable--}}
    @include('backend.includes.assets.plugin-files.datatable')
    @include('backend.includes.assets.plugin-files.editor')

    <script>
        $(function () {
            $('.summernote').summernote();
        })
        // image preview
        $(document).ready(function () {
            $('#imagex').change(function () {
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
        // edit advertisement
        $(document).on('click', '.edit-btn', function () {
            var advertisementId = $(this).attr('data-advertisement-id');
            $.ajax({
                url: base_url+"advertisements/"+advertisementId+"/edit",
                method: "GET",
                success: function (data) {
                    $('#modalForm').empty().append(data);
                    $('.select2').select2();
                    $('.summernote').summernote();
                    $('#advertisementModal').modal('show');
                }
            })
        })
    </script>
    <script>
        $(document).on('keyup', 'input,textarea', function () {
            var selectorId = $(this).attr('name');
            if ($('#'+selectorId).text().length)
            {
                $('#'+selectorId).text('');
            }
        })
        $(document).on('change', 'select', function () {
            var selectorId = $(this).attr('name');
            if ($('#'+selectorId).text().length)
            {
                $('#'+selectorId).text('');
            }
        })
    </script>
@endpush
