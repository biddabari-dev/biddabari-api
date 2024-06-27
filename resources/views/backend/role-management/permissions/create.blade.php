@extends('backend.master')

@section('title', 'Permissions')

@section('body')
    <div class="row py-5">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-light">Permission Create</h4>
                    <a href="{{ route('permissions.index') }}" class="btn rounded-circle position-absolute end-0 me-3">
                        {{--                        <i class="bx bx-plus-circle"></i>--}}
                        <i class="fa-regular fa-file-lines fa-2x text-white"></i>
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ isset($permission) ? route('permissions.update', $permission->id) : route('permissions.store') }}" method="post">
                        @csrf
                        @if(isset($permission))
                            @method('put')
                        @endif
                        <div class="mt-2 select2-div">
                            <label for="">Permission Category</label>
                            <select name="permission_category_id" class="form-control select2" required data-placeholder="<-- Select a Permission Category -->" id="">
                                <option value=""></option>
                                @foreach($permissionCategories as $permissionCategory)
                                    <option value="{{ $permissionCategory->id }}" {{ isset($permission) && $permission->permission_category_id == $permissionCategory->id ? 'selected' : '' }}>{{ $permissionCategory->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-2">
                            <label for="">Title</label>
                            <input type="text" name="title" class="form-control" value="{{ isset($permission) ? $permission->title : '' }}" />
                        </div>

                        <div class="mt-2">
                            <label for="">Is Published</label>
                            <div class="material-switch">
                                <input id="someSwitchOptionInfo" name="status" type="checkbox" {{ isset($permission) && $permission->status == 0 ? '' : 'checked' }}>
                                <label for="someSwitchOptionInfo" class="label-info"></label>
                            </div>
                        </div>
                        <div>
                            <input type="submit" class="btn btn-success btn-sm float-end" value="{{ isset($permission) ? 'Update' : 'Create' }} Permission" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
@push('style')
{{--    <link href="{{ asset('/') }}backend/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />--}}
{{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" integrity="sha512-2L0dEjIN/DAmTV5puHriEIuQU/IL3CoPm/4eyZp3bM8dnaXri6lK8u6DC5L96b+YSs9f3Le81dDRZUSYeX4QcQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />--}}

@endpush

@push('script')
{{--    <script src="{{ asset('/') }}backend/assets/libs/select2/js/select2.min.js"></script>--}}
{{--    <script>--}}
{{--        $(document).ready(function () {--}}
{{--            $('.select2').select2({--}}
{{--                placeholder: $(this).attr('data-placeholder')--}}
{{--            });--}}
{{--        })--}}
{{--    </script>--}}
@endpush
