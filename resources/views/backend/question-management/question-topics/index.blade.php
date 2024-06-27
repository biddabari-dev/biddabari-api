@extends('backend.master')

@section('title', 'Question Topics')

@section('body')
    <div class="row py-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">Manage {{ $_GET['q-type'] == 'mcq' ? 'MCQ' : 'WRITTEN' }} Store</h4>
                    @can('create-question-topic')
                        <button type="button" data-bs-toggle="modal" data-bs-target="#questionTopicsModal" class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4"><i class="fa-solid fa-circle-plus"></i></button>
                    @endcan
                </div>
                <div class="card-body">

                    <table class="table table-borderless table-hover" id="">
                        <thead>
                            <tr>
{{--                                <th>#</th>--}}
                                <th>Exam Name</th>
                                <th>{{ isset($_GET['q-type']) && $_GET['q-type'] == 'mcq' ? 'MCQ' : 'WRITTEN' }} STORE</th>
                                <th>SUB CATEGORY</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($questionTopics as $questionTopic)
                                <tr>
{{--                                    <td>{{ $loop->iteration }}</td>--}}
                                    <td>
                                        {{ $questionTopic->name }}
                                    </td>
                                    <td>
                                        @can('manage-question-store')
                                            <a href="{{ route('question-stores.index', ['topic_id' => $questionTopic->id, 'q-type' => $_GET['q-type']]) }}">{{ $_GET['q-type'] == 'mcq' ? 'MCQ' : 'WRITTEN' }} STORE</a>
                                        @endcan
                                    </td>
                                    <td>
                                        @can('manage-question-topic')
                                            <a href="{{ route('question-topics.index', ['topic_id' => $questionTopic->id, 'q-type' => $_GET['q-type']]) }}">SUB CATEGORY</a>
                                        @endcan
                                    </td>
                                    <td class="">
{{--                                        <a href="" class="btn btn-sm btn-primary nested-add" data-topic-id="{{ $questionTopic->id }}"><i class="fa-solid fa-circle-plus"></i></a>--}}
                                        @can('create-question-topic')
                                            <a href="{{ route('question-topics.edit', $questionTopic->id) }}" data-topic-id="{{ $questionTopic->id }}" class="btn btn-sm btn-warning topic-edit-btn">
                                                <i class="fa-solid fa-edit"></i>
                                            </a>
                                        @endcan
                                        @can('create-question-topic')
                                            <form class="d-inline" action="{{ route('question-topics.destroy', $questionTopic->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-danger data-delete-form">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <span class="">No Data Available</span>
                                        </td>
                                    </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-div shadow" id="questionTopicsModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('question-topics.store', ['q-type' => $_GET['q-type']]) }}" method="post" enctype="multipart/form-data" id="questionTopicForm">
                    <div class="modal-header">
                        <h5 class="modal-title">Create Question Topic</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="question_topic_id" value="{{ isset($_GET['topic_id']) ? $_GET['topic_id'] : 0 }}">
                        <div class="row mt-2">
                            <div class="col-md-8">
                                <label for="">Exam Name</label>
                                <input type="text" name="name" required class="form-control" placeholder="Name" />
                                <span class="text-danger" id="name">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
                            </div>
                            <div class="col-md-4 position-relative d-none">
                                <label for="" class="switch-label">Active</label>
                                <div class="material-switch">
                                    <input id="someSwitchOptionInfo" name="status" checked type="checkbox" />
                                    <label for="someSwitchOptionInfo" class="label-info" ></label>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary submit-btn" value="save">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <!-- DataTables -->
{{--    <link href="{{ asset('/') }}backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />--}}
{{--    <link href="{{ asset('/') }}backend/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />--}}
    <style>
        input[switch]+label {
            margin-bottom: 0px;
        }
    </style>
@endpush

@push('script')
    <!-- Required datatable js -->
    @include('backend.includes.assets.plugin-files.datatable')
    <script>
        {{--    edit course category--}}
        $(document).on('click', '.topic-edit-btn', function () {
            event.preventDefault();
            var categoryId = $(this).attr('data-topic-id');
            $.ajax({
                url: base_url+"question-topics/"+categoryId+"/edit",
                method: "GET",
                dataType: "JSON",
                success: function (data) {
                    $('input[name="name"]').val(data.name);
                    if (data.status == 1)
                    {
                        $('input[name="status"]').attr('checked', true);
                    } else {
                        $('input[name="status"]').attr('checked', false);
                    }
                    $('.submit-btn').addClass('update-btn').removeClass('submit-btn');
                    $('#questionTopicForm').attr('action', base_url+'question-topics/'+data.id+'?q-type={{ $_GET['q-type'] }}{{ isset($_GET['topic_id']) ? '&topic_id='.$_GET['topic_id'] : '' }}');
                    $('#questionTopicsModal').modal('show');
                }
            })
        })
    </script>
    <script>
        // update course category
        $(document).on('click', '.update-btn', function () {
            event.preventDefault();
            var formData = $('#questionTopicForm').serialize();
            $.ajax({
                url: $('#questionTopicForm').attr('action'),
                method: "PUT",
                data: formData,
                dataType: "JSON",
                // async: false,
                // cache: false,
                // contentType: false,
                // processData: false,
                // enctype: 'multipart/form-data',
                success: function (message) {
                    // console.log(formData);
                    toastr.success(message);
                    $('.update-btn').addClass('submit-btn').removeClass('update-btn');
                    $('#questionTopicForm').attr('action', '');
                    $('#questionTopicsModal').modal('hide');
                    // resetInputFields();
                    window.location.reload();
                }
            })
        })
    </script>

    <script>
        {{--    store course category--}}
        $(document).on('click', '.nested-add', function () {
            event.preventDefault();
            var form =  $('#questionTopicForm');
            var parentId = $(this).attr('data-topic-id');
            form.append('<input type="hidden" name="question_topic_id" value="'+parentId+'" id="topicId" />');
            $('#questionTopicsModal').modal('show');

        })
    </script>

    @if(!empty($errors->any()))
        <script>
            $(function () {
                $('#questionTopicsModal').modal('show');
            })
        </script>
    @endif
@endpush
