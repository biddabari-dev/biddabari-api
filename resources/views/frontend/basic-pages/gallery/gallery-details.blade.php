@extends('frontend.master')

@section('body')

    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="fw-bold text-center pb-2 border-bottom">{{ $gallery->title }} Pictures</h2>
                    <div class="row mt-4">
                        @forelse($gallery->galleryImages as $galleryImage)
                            <div class="col-md-4 mt-3">
                                <a href="{{ asset(isset($galleryImage->image_url) ? $galleryImage->image_url : 'frontend/logo/biddabari-card-logo.jpg') }}" class="w-100" style="" data-toggle="lightbox" data-gallery="{{ str_replace(' ', '-', $gallery->title) }}-gallery" data-caption="image-description">
                                    <img src="{{ asset(isset($galleryImage->image_url) ? $galleryImage->image_url : 'frontend/logo/biddabari-card-logo.jpg') }}" alt="" class="img-fluid w-100" style="height: 350px;">
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

@push('script')
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" integrity="sha512-Velp0ebMKjcd9RiCoaHhLXkR1sFoCCWXNp6w4zj1hfMifYB5441C+sKeBl/T/Ka6NjBiRfBBQRaQq65ekYz3UQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />--}}
@endpush

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/bs5-lightbox@1.8.3/dist/index.bundle.min.js"></script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js" integrity="sha512-Y2IiVZeaBwXG1wSV7f13plqlmFOx8MdjuHyYFVoYzhyRr3nH/NMDjTBSswijzADdNzMyWNetbLMfOpIPl6Cv9g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>--}}
@endpush
