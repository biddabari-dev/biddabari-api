@extends('frontend.master')

@section('body')

    <div class="instructors-area instructors-area-rs py-3">
        <div class="container">
            <div class="section-title text-center mb-30">
                <h2>Meet our top instructor</h2>
            </div>
            <div class="row justify-content-center">
                @forelse($teachers as $teacher)
                    <div class="col-lg-3 col-md-6">
                        <div class="instructors-card ab-shadow">
                            <a href="{{ route('front.instructor-details', ['id' => $teacher->id, 'slug' => str_replace(' ', '-', $teacher->name)]) }}">
                                <img src="{{ asset(file_exists_obs($teacher->user->user_photo_path) ? $teacher->user->user_photo_path : (file_exists_obs($teacher->image) ? $teacher->image :'https://png.pngtree.com/png-vector/20190710/ourmid/pngtree-user-vector-avatar-png-image_1541962.jpg') ) }}" alt="Team Images">
                            </a>
                            <div class="content py-3">

                                <h3><a href="{{ route('front.instructor-details', ['id' => $teacher->id, 'slug' => str_replace(' ', '-', $teacher->name)]) }}">{{ $teacher->user->name ?? '' }}</a></h3>
                                <span>{{ $teacher->subject ?? '' }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12">
                        <div class="card card-body">
                            <p class="text-center fw-bolder">No Instructor Found</p>
                        </div>
                    </div>
                @endforelse
                <div class="col-lg-12 col-md-12 text-center">
                    <div class="pagination-area">

                        {{ $teachers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
