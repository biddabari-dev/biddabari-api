@extends('backend.master')

@section('title', 'Affiliations History')

@section('body')
    <div class="row py-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">Affiliation history of {{ $affiliationRegistration->user->name }}</h4>
{{--                        <button type="button" data-bs-toggle="modal" data-bs-target="#advertisementModal" class="rounded-circle open-modal text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4"><i class="fa-solid fa-circle-plus"></i></button>--}}
                </div>
                <div class="card-body">

                    <div>
                        <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-insert" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Earnings</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-withdraw" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Withdraw</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-insert" role="tabpanel" aria-labelledby="pills-home-tab">
                                <table class="table" id="">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Course Name</th>
                                            <th>Referred Student</th>
                                            <th>Earnings</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($affiliationRegistration))
                                        @foreach($affiliationRegistration->affiliationHistories as $history)
                                            @if($history->affiliate_type == 'insert')
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        @if($history->model_type == 'course')
                                                            {{ $history->course->title }}
                                                        @elseif($history->model_type == 'batch_exam')
                                                            {{ $history->batchExam->title }}
                                                        @elseif($history->model_type == 'product')
                                                            {{ $history->product->title }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $history->user->name }}</td>
                                                    <td>{{ $history->amount }}</td>
                                                    <td>{{ $history->status == 1 ? 'Approved' : 'Pending' }}</td>

                                                </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="pills-withdraw" role="tabpanel" aria-labelledby="pills-profile-tab">
                                <table class="table" id="">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Course Name</th>
                                        <th>Referred Student</th>
                                        <th>Earnings</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($affiliationRegistration))
                                            @foreach($affiliationRegistration->affiliationHistories as $withdrawHistory)
                                                @if($withdrawHistory->affiliate_type == 'withdraw')
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>
                                                            @if($withdrawHistory->model_type == 'course')
                                                                {{ $withdrawHistory->course->title }}
                                                            @elseif($withdrawHistory->model_type == 'batch_exam')
                                                                {{ $withdrawHistory->batchExam->title }}
                                                            @elseif($withdrawHistory->model_type == 'product')
                                                                {{ $withdrawHistory->product->title }}
                                                            @endif
                                                        </td>
                                                        <td>{{ $withdrawHistory->user->name }}</td>
                                                        <td>{{ $withdrawHistory->amount }}</td>
                                                        <td>{{ showDate($withdrawHistory->created_at) }}</td>
                                                        <td>{{ $withdrawHistory->status == 1 ? 'Approved' : 'Pending' }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>




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
