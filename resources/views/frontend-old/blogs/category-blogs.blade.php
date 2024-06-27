@extends('frontend.master')

@section('body')

    <div class="inner-banner inner-banner-bg5">
        <div class="container">
            <div class="inner-title text-center">
                <h3>Blog Category </h3>
                <ul>
                    <li>
                        <a href="{{ route('front.home') }}">Home</a>
                    </li>
                    <li>{{ $blogCategory->name }} Blogs </li>
                </ul>
            </div>
        </div>
    </div>


    <div class="blog-widget-area pt-100 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row justify-content-center">
                        @forelse($blogs as $blog)
                        <div class="col-md-4 col-sm-6">
                            <div class="blog-card">
                                <a href="{{ route('front.blog-details', ['id' => $blog->id, 'slug' => $blog->slug]) }}">
                                    <img src="{{ asset(isset($blog->image) ? $blog->image : 'frontend/logo/biddabari-card-logo.jpg') }}" alt="Blog" class="w-100 img-fluid" style="height: 280px" />
                                </a>
                                <div class="content">
                                    <ul>
                                        <li><i class="ri-calendar-todo-fill"></i> {{ $blog->created_at->format('M d, Y') }} </li>
                                        <li><i class="ri-price-tag-3-fill"></i> <a href="{{ route('front.category-blogs', ['id' => $blog->blogCategory->id, 'slug' => $blog->blogCategory->slug]) }}">{{ $blog->blogCategory->name }}</a></li>
                                    </ul>
                                    <h3><a href="{{ route('front.blog-details', ['id' => $blog->id, 'slug' => $blog->slug]) }}">{{ $blog->title }}</a></h3>
                                    <p>{!! str()->words($blog->body, 8) !!}</p>
                                    <a href="{{ route('front.blog-details', ['id' => $blog->id, 'slug' => $blog->slug]) }}" class="read-btn">Read More</a>
                                </div>
                            </div>
                        </div>
                        @empty
                            <div class="col-md-12">
                                <div class="card card-body">
                                    <h2 class="text-center">No Blogs Published Yet.</h2>
                                </div>
                            </div>
                        @endforelse

                            @if($blogs->lastPage() > 1 )
                                <div class="col-lg-12 col-md-12 text-center">
                                    <div class="pagination-area">

                                        {{ $blogs->links() }}
                                    </div>
                                </div>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
