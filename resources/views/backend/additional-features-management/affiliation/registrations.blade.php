@extends('backend.master')

@section('title', 'Affiliations')

@section('body')
    <div class="row py-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">Affiliations</h4>
{{--                        <button type="button" data-bs-toggle="modal" data-bs-target="#advertisementModal" class="rounded-circle open-modal text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4"><i class="fa-solid fa-circle-plus"></i></button>--}}
                </div>
                <div class="card-body">
                    <table class="table" id="file-datatable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Code</th>
                                <th>Total Earnings</th>
                                <th>Total Withdraws</th>
                                <th>Current Balance</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(isset($affiliationRegistrations))
                            @foreach($affiliationRegistrations as $affiliationRegistration)
                                <tr>
                                    {{--                                        <td>{{ $loop->iteration }}</td>--}}
                                    <td>{{ $affiliationRegistration->user->name }}</td>
                                    <td>{{ $affiliationRegistration->user->mobile }}</td>
                                    <td>{{ $affiliationRegistration->affiliate_code }}</td>
                                    <td>{{ $affiliationRegistration->total_earning }}</td>
                                    <td>{{ $affiliationRegistration->total_withdraw }}</td>
                                    <td>{{ $affiliationRegistration->balance }}</td>
                                    <td>
                                        <a href="javascript:(0)" class="badge badge-sm bg-primary">{{ $affiliationRegistration->status == 1 ? 'Approved' : 'Pending' }}</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('show-affiliate-history', ['id' => $affiliationRegistration->id]) }}" class="btn btn-sm btn-warning edit-btn" title="View History">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>

{{--                                            <form class="d-inline" action="{{ route('advertisements.destroy', $affiliationRegistration->id) }}" method="post" >--}}
{{--                                                @csrf--}}
{{--                                                @method('delete')--}}
{{--                                                <button type="submit" class="btn btn-sm btn-danger data-delete-form" title="Delete Advertisement">--}}
{{--                                                    <i class="fa-solid fa-trash"></i>--}}
{{--                                                </button>--}}
{{--                                            </form>--}}
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
@endsection

@push('script')
    {{--    datatable--}}
    @include('backend.includes.assets.plugin-files.datatable')
    @include('backend.includes.assets.plugin-files.editor')
@endpush
