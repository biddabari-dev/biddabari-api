@extends('backend.master')

@section('title', 'Users')

@section('body')
    <div class="row py-5">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">User Create</h4>
                    <a href="{{ route('users.index') }}" class="btn rounded-circle position-absolute end-0 me-3">
                        <i class="fa-regular fa-file-lines fa-2x text-white"></i>
                    </a>
                </div>
                <div class="card-body modal-fix" id="roleForm" data-modal-parent="roleForm" >
                    <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" method="post">
                        @csrf
                        @if(isset($user))
                            @method('put')
                        @endif

                        <div class="mt-2">
                            <label for="">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ isset($user) ? $user->name : '' }}" />
                        </div>

{{--                        <div class="mt-2">--}}
{{--                            <label for="">Email</label>--}}
{{--                            <input type="email" name="email" class="form-control" value="{{ isset($user) ? $user->email : '' }}" />--}}
{{--                        </div>--}}
                        <div class="mt-2">
                            <label for="">Mobile</label>
                            <input type="text" name="mobile" {{ isset($user) ? 'readonly' : '' }} class="form-control" value="{{ isset($user) ? $user->mobile : '' }}" />
                        </div>
{{--                        @if(!isset($user))--}}
                        <div class="mt-2">
                            <label for="">Password</label>
                            <input type="password" name="password" class="form-control" value="" placeholder="{{ isset($user) ? 'Change' : 'Enter' }} Password" />
                        </div>
{{--                        @endif--}}
                        <div class="mt-2 select2-div">
                            <label for="">Roles</label>
                            <select name="roles[]" class="form-control select2" multiple required data-placeholder="Select A Role" id="">
{{--                                <option value="" disabled> <-- Select User Roles --> </option>--}}
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" @if(isset($user)) @if(!empty($user->roles)) @foreach($user->roles as $userRole) @if($role->id == $userRole->id) selected @endif @endforeach @endif @endif >{{ $role->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-2">
                            <label for="">Is Published</label>
                            <div class="material-switch">
                                <input id="someSwitchOptionInfo" name="status" type="checkbox" {{ isset($user) && $user->status == 0 ? '' : 'checked' }} />
                                <label for="someSwitchOptionInfo" class="label-info"></label>
                            </div>
                        </div>
                        <div>
                            <input type="submit" class="btn btn-success btn-sm float-end" value="{{ isset($user) ? 'Update' : 'Create' }} User" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
@push('style')
{{--    <link href="{{ asset('/') }}backend/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />--}}
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
