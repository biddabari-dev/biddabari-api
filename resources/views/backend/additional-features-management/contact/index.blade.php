@extends('backend.master')

@section('title', 'Contacts')

@section('body')
    <div class="row py-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">INBOX</h4>
                    <button type="button" class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4 blog-category-modal-btn"><i class="fa-solid fa-circle-plus"></i></button>
                </div>
                <div class="card-body">



                    <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pageComments" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Contact Us Page</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#otherComments" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Other Sources</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pageComments" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="row">
                                <table class="table table-borderless" id="file-datatable">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User Info</th>
                                        <th>Message</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($contacts))
                                        @foreach($contacts as $contact)
                                            @if($contact->type == 'page')
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <span>Name: {{ $contact->user->name }}</span> <br>
                                                        <span>Mobile: {{ $contact->user->mobile }}</span> <br>
                                                        @if($contact->type == 'course')
                                                            <span>{{ $contact->course->title }}</span> <br>
                                                        @elseif($contact->type == 'batch_exam')
                                                            <span>{{ $contact->batchExam->title }}</span> <br>
                                                        @endif
                                                        <span>Date: {{ $contact->created_at->format('M d, Y g:i') }}</span>
                                                    </td>
                                                    <td>{!! str()->words(strip_tags($contact->message), 80) !!}</td>
                                                    <td>
                                                        <a href="" class="badge change-seen-status-{{ $contact->id }} badge-sm bg-primary">{{ $contact->is_seen == 1 ? 'Seen' : 'Unseen' }}</a>
                                                    </td>
                                                    <td>
                                                        @if($contact->is_seen == 0)
                                                            @can('show-contact')
                                                                <a data-contact-id="{{ $contact->id }}" class="btn btn-sm btn-warning change-seen-btn change-seen-btn-{{ $contact->id }}" title="Edit Advertisement">
                                                                    <i class="fa-solid fa-eye"></i>
                                                                </a>
                                                            @endcan
                                                        @endif
                                                        @can('delete-contact')
                                                            <form class="d-inline" action="{{ route('contacts.destroy', $contact->id) }}" method="post">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit" class="btn btn-sm btn-danger data-delete-form" title="Delete Advertisement">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        @endcan
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="otherComments" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <div class="row">
                                <table class="table table-borderless" id="file-datatable">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User Info</th>
                                        <th>Model Name</th>
                                        <th>Content Name</th>
                                        <th>Message</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($contacts))
                                        @foreach($contacts as $contact)
                                            @if($contact->type != 'page')
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <span>Name: {{ $contact->user->name }}</span> <br>
                                                        <span>Mobile: {{ $contact->user->mobile }}</span> <br>
                                                        @if($contact->type == 'course')
                                                            <span>{{ $contact->course->title }}</span> <br>
                                                        @elseif($contact->type == 'batch_exam')
                                                            <span>{{ $contact->batchExam->title }}</span> <br>
                                                        @endif
                                                        <span>Date: {{ $contact->created_at->format('M d, Y g:i') }}</span>
                                                    </td>
                                                    <td>
                                                        @if($contact->type =='course')
                                                            {{ $contact->course->title }}
                                                        @elseif($contact->type =='batch_exam')
                                                            {{ $contact->batchExam->title }}
                                                        @elseif($contact->type =='product')
                                                            {{ $contact->product->title }}
                                                        @elseif($contact->type =='blog')
                                                            {{ $contact->blog->title }}
                                                        @elseif($contact->type =='course_content')
                                                            {{ $contact->courseSectionContent->courseSection->course->title }}
                                                        @elseif($contact->type =='batch_exam_content')
                                                            {{ $contact->batchExamSectionContent->batchExamSection->batchExam->title }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($contact->type =='course_content')
                                                            {{ $contact->courseSectionContent->title }}
                                                        @elseif($contact->type =='batch_exam_content')
                                                            {{ $contact->batchExamSectionContent->title }}
                                                        @endif
                                                    </td>
                                                    <td>{!! str()->words(strip_tags($contact->message), 80) !!}</td>
                                                    <td>
                                                        <a href="" class="badge change-seen-status-{{ $contact->id }} badge-sm bg-primary">{{ $contact->is_seen == 1 ? 'Seen' : 'Unseen' }}</a>
                                                    </td>
                                                    <td>
                                                        @if($contact->is_seen == 0)
                                                            @can('show-contact')
                                                                <a data-contact-id="{{ $contact->id }}" class="btn btn-sm btn-warning change-seen-btn change-seen-btn-{{ $contact->id }}" title="Edit Advertisement">
                                                                    <i class="fa-solid fa-eye"></i>
                                                                </a>
                                                            @endcan
                                                        @endif
                                                        @can('delete-contact')
                                                            <form class="d-inline" action="{{ route('contacts.destroy', $contact->id) }}" method="post" onsubmit="return confirm('Are you sure to delete this? Once deleted, It can not be undone.')">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete Advertisement">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        @endcan
                                                    </td>
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
@push('style')
    <!-- DragNDrop Css -->
    {{--    <link href="{{ asset('/') }}backend/assets/css/dragNdrop.css" rel="stylesheet" type="text/css" />--}}
    <style>
        input[switch]+label {
            margin-bottom: 0px;
        }
    </style>
@endpush

@push('script')

        @include('backend.includes.assets.plugin-files.datatable')
    {{--    @include('backend.includes.assets.plugin-files.date-time-picker')--}}
{{--    @include('backend.includes.assets.plugin-files.editor')--}}
    {{--    store course--}}

        <script>
            $(document).on('click', '.change-seen-btn', function () {
                event.preventDefault();
                var contactId = $(this).attr('data-contact-id');
                $.ajax({
                    url: base_url+"contacts/"+contactId,
                    method: "GET",
                    success: function (data) {
                        if (data.is_seen == 1)
                        {
                            $('.change-seen-status-'+contactId).text('Seen');
                            $('.change-seen-btn-'+contactId).remove();
                        }
                    }
                })
            })
        </script>

@endpush
