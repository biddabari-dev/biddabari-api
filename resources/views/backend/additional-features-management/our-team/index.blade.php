@extends('backend.master')

@section('title', 'Manage Our Team')

@section('body')
    <div class="row py-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">Our Team</h4>

                    <a href="{{ route('our-teams.create') }}" class="rounded-circle open-modal text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4"><i class="fa-solid fa-circle-plus"></i></a>

                </div>
                <div class="card-body">
                    <table class="table" id="file-datatable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Content Show Type</th>
                            <th>Video Link</th>
                            <th>Video File</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($ourTeams as $ourTeam)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $ourTeam->name }}</td>
                                    <td>{{ $ourTeam->designation }}</td>
                                    <td>{{ $ourTeam->content_show_type }}</td>
                                    <td>{{ $ourTeam->video_link }}</td>
                                    <td>
                                        @if(!empty($ourTeam->video_file))
                                        <video src="{{ asset($ourTeam->video_file) }}" controls class="" style="height: 75px">
                                            <source src="{{ asset($ourTeam->video_file) }}" type="video/mp4" />
                                        </video>
                                        @endif
                                    </td>
                                    <td><img src="{{ asset($ourTeam->image) }}" alt="" style="height: 60px" /></td>
                                    <td>{{ $ourTeam->status == 1 ? 'Published' : 'Unpublished' }}</td>
                                    <td class="d-flex">
                                        <a href="{{ route('our-teams.edit', $ourTeam->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                        <form action="{{ route('our-teams.destroy', $ourTeam->id) }}" method="post" >
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
