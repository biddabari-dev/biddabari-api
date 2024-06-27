@extends('backend.master')

@section('title', 'Permission')

@section('body')
    <div class="row py-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">Manage Users</h4>
                    @can('create-user')
                        <a href="{{ route('users.create') }}" class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4">
                            <i class="fa-solid fa-circle-plus"></i>
                        </a>
                    @endcan
                </div>
                <div class="card-body">
                    {!! $dataTable->table() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
@endpush

@push('script')

    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <!-- yo -->
    @include('backend.includes.assets.plugin-files.datatable')
@endpush
