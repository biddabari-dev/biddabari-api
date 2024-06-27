@extends('frontend.master')

@section('body')
   

    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="fw-bold text-center pb-2 border-bottom">Galleries</h2>
                    <div class="row mt-4">
                        @forelse($galleries as $gallery)
                            <div class="col-md-4 mt-3">
                                <a href="{{ route('front.show-gallery-images', ['id' => $gallery->id, 'title' => str_replace(' ', '-', $gallery->title)]) }}" class="w-100">
                                    <div class="card">
                                        <img src="{{ asset(isset($gallery->banner) ? $gallery->banner : 'frontend/logo/biddabari-card-logo.jpg') }}" alt="gallery-img" class="card-img-top" style="height: 280px" />
                                        <div class="card-body py-0">
                                            <h2 class="mb-0">{{ $gallery->title }}</h2>
                                            <p class="pb-3">{{ $gallery->sub_title }}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="fw-bold">No gallery Images Published Yet..</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
