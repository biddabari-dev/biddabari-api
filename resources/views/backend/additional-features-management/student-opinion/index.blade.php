@extends('backend.master')

@section('title', 'Student Opinions')

@section('body')
    <div class="row py-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">All Student Opinions</h4>
                        <a href="{{ route('student-opinions.create') }}" class="btn btn-success btn-sm position-absolute me-5" style="right: 0"><i class="fa fa-plus-circle"></i></a>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Select Student Type</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Student Comment</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($opinions as $opinion)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $opinion->show_type }}</td>
                                    <td>{{ $opinion->name }}</td>
                                    <td><img src="{{ asset($opinion->image) }}" alt="" style="height: 60px"></td>
                                    <td>{!! $opinion->comment !!}</td>
                                    <td>{{ $opinion->status == 1 ? 'Published' : 'Unpublished' }}</td>
                                    <td class="d-flex">
                                        <a href="{{ route('student-opinions.edit', $opinion->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                        <form action="{{ route('student-opinions.destroy', $opinion->id) }}" method="post" onsubmit="return confirm('Are you sure to delete?')">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger ms-1"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
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
