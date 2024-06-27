@extends('backend.master')

@section('title', 'Home Counter')

@section('body')
    <div class="row py-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">Number Counter</h4>

                    <a href="{{ route('number-counters.create') }}" class="rounded-circle open-modal text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4"><i class="fa-solid fa-circle-plus"></i></a>

                </div>
                <div class="card-body">
                    <table class="table" id="file-datatable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Label</th>
                            <th>Icon Code</th>
                            <th>Total Number</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($numberCounters as $numberCounter)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $numberCounter->label }}</td>
                                    <td>{{ $numberCounter->icon_code }}</td>
                                    <td>{{ $numberCounter->total_number }}</td>
                                    <td><img src="{{ asset($numberCounter->image) }}" alt="" style="height: 60px" /></td>
                                    <td>{{ $numberCounter->status == 1 ? 'Published' : 'Unpublished' }}</td>
                                    <td class="d-flex">
                                        <a href="{{ route('number-counters.edit', $numberCounter->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                        <form action="{{ route('number-counters.destroy', $numberCounter->id) }}" method="post" >
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger ms-1 data-delete-form"><i class="fa fa-trash"></i></button>
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

@push('style')
    <!-- DragNDrop Css -->
    {{--    <link href="{{ asset('/') }}backend/assets/css/dragNdrop.css" rel="stylesheet" type="text/css" />--}}

@endpush

@push('script')
    {{--    datatable--}}
    @include('backend.includes.assets.plugin-files.datatable')
{{--    @include('backend.includes.assets.plugin-files.editor')--}}



    <script>
        $(document).ready(function() {
            $('#imagez').change(function() {
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
