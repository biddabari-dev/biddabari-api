@extends('backend.master')

@section('title', 'Roles')

@section('body')
    <div class="row py-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">Roles</h4>
                    @can('create-role')
                        <a href="{{ route('roles.create') }}" class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4">
                            <i class="fa-solid fa-circle-plus"></i>
                        </a>
                    @endcan
                </div>
                <div class="card-body">
                    <table class="table" id="file-datatable" >
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Note</th>
                                <th>Permissions</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $role->title }}</td>
                                <td>{!! $role->note !!}</td>
                                <td>
                                    @foreach($role->permissions as $permission)
                                        <span class="badge badge-sm bg-primary">{{ $permission->title }}</span>
                                    @endforeach
                                </td>
                                <td>{{ $role->slug }}</td>
                                <td>{{ $role->status == 1 ? 'Published' : 'Unpublished' }}</td>
                                <td class="">
                                    @can('edit-role')
                                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fa-solid fa-edit"></i>
                                        </a>
                                    @endcan
                                    @can('delete-role')
                                        <form class="d-inline" action="{{ route('roles.destroy', $role->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger data-delete-form">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    @endcan
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
    <!-- DataTables -->
{{--    <link href="{{ asset('/') }}backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />--}}
{{--    <link href="{{ asset('/') }}backend/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />--}}
@endpush

@push('script')
{{--    <!-- Required datatable js -->--}}
{{--    <script src="{{ asset('/') }}backend/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>--}}
{{--    <script src="{{ asset('/') }}backend/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>--}}
{{--    <!-- Buttons examples -->--}}
{{--    <script src="{{ asset('/') }}backend/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>--}}
{{--    <script src="{{ asset('/') }}backend/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>--}}
{{--    <script src="{{ asset('/') }}backend/assets/libs/jszip/jszip.min.js"></script>--}}
{{--    <script src="{{ asset('/') }}backend/assets/libs/pdfmake/build/pdfmake.min.js"></script>--}}
{{--    <script src="{{ asset('/') }}backend/assets/libs/pdfmake/build/vfs_fonts.js"></script>--}}
{{--    <script src="{{ asset('/') }}backend/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>--}}
{{--    <script src="{{ asset('/') }}backend/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>--}}
{{--    <script src="{{ asset('/') }}backend/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>--}}

{{--    <!-- Responsive examples -->--}}
{{--    <script src="{{ asset('/') }}backend/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>--}}
{{--    <script src="{{ asset('/') }}backend/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>--}}

{{--    <!-- Datatable init js -->--}}
{{--    <script src="{{ asset('/') }}backend/assets/js/pages/datatables.init.js"></script>--}}
{{--    <script>--}}
{{--        // $('#datatable-buttons_wrapper').DataTable();--}}
{{--    </script>--}}
    @include('backend.includes.assets.plugin-files.datatable')
@endpush
