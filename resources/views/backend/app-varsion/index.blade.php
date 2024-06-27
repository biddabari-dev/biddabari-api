@extends('backend.master')

@section('title', 'Product Authors')

@section('body')
    <div class="row py-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">App Varsion</h4>
                    @can('create-product')
                        <button type="button" class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4 product-category-modal-btn"><i class="fa-solid fa-circle-plus"></i></button>
                    @endcan
                </div>
                <div class="card-body">


                    <table class="table" id="file-datatable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>App varsion</th>
                            <th>App URL</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($apps))
                            @foreach($apps as $app)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $app->varsion }}</td>
                                    <td>{{ $app->url }}</td>
{{--                                    <td>{{ $app->status }}</td>--}}
                                    <td>
                                        <a href="javascript:void(0)" class="badge bg-primary">{{ $app->status == 1 ? 'Published' : 'Unpublished' }}</a>
{{--                                        <a href="javascript:void(0)" class="badge bg-primary">{{ $app->is_featured == 1 ? 'Featured' : 'Not Featured' }}</a>--}}
                                    </td>
                                    <td>
                                        @can('edit-product')
                                            <a href="{{route('app-varsions.edit',$app->id)}}" data-appvarsion-id="{{ $app['id'] }}"  class="btn btn-sm btn-warning appvarsion-edit-btn" title="Edit Blog Category">
                                                <i class="fa-solid fa-edit"></i>
                                            </a>
                                        @endcan
                                        @can('delete-product')
                                            <form class="d-inline" action="{{ route('app-varsions.destroy', $app->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-danger data-delete-form" title="Delete Category">
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

    <div class="modal fade modal-div" id="blogCategoryModal" data-modal-parent="blogCategoryModal" data-bs-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" id="">
                <form id="app_varsion_submit" action="{{ route('app-varsions.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
{{--                    {{csrf_field()}}--}}
                    {{ method_field('PUT') }}
                    <div class="modal-header">
                        <h5 class="modal-title" id="">App Varsion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="card card-body">
                            <div class="row mt-2">
                                <div class="col-md-4 mt-2">
                                    <label for="">Varsion</label>
                                    <input type="text"  name="varsion" class="form-control" placeholder="Varsion"  />
                                    <span class="text-danger">{{ $errors->has('varsion') ? $errors->first('varsion') : '' }}</span>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <label for="">Url</label>
                                    <input type="text"  name="url" class="form-control" placeholder="URL"  />
                                    <span class="text-danger">{{ $errors->has('url') ? $errors->first('url') : '' }}</span>
                                </div>
                                <div class="col-md-4 mt-3">
                                    <label for="">Status</label>
                                    <div class="material-switch">
{{--                                        <label for="statusChecked"><input type="radio" name="status" id="statusChecked" value="on" checked>Published</label>--}}
{{--                                        <label for="statusNotChecked"><input type="radio" name="status" id="statusNotChecked" value="">Not Published</label>--}}
                                        <input id="someSwitchOptionInfo" name="status" type="checkbox" checked />
                                        <label for="someSwitchOptionInfo" class="label-info"></label>
                                    </div>
                                    <span class="text-danger">{{ $errors->has('status') ? $errors->first('status') : '' }}</span>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary " value="save">Save</button>
                    </div>
                </form>
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
    <script>

        $(document).on('click', '.product-category-modal-btn', function () {
            event.preventDefault();
            // resetInputFields();
            if ($('input[name="_method"]').length)
            {
                $('input[name="_method"]').remove();
            }
            $('#blogCategoryModal').modal('show');
        })
    </script>
    <script>
        {{--    edit course category--}}
        $(document).on('click', '.appvarsion-edit-btn', function () {
            event.preventDefault();
            var categoryId = $(this).attr('data-appvarsion-id');
            $.ajax({
                url: base_url+"app_varsion/"+categoryId+"/edit",
                method: "get",
                dataType: "JSON",
                success: function (data) {
                    console.log(data);
                    $('span[class="text-danger"]').empty();
                    $('input[name="varsion"]').val(data.varsion);
                    $('input[name="url"]').val(data.url);
                    if (data.status == 1)
                    {
                        $('input[name="status"]').attr('checked', true);
                    } else {
                        $('input[name="status"]').attr('checked', false);
                    }
                    $('#app_varsion_submit').attr('action', base_url+'app_varsion/'+data.id);
                    $('#blogCategoryModal').modal('show');
                }
            })
        })
    </script>

@endpush
