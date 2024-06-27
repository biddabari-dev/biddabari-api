@extends('frontend.master')

@section('body')


    <div class="blog-details-area pt-100 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h2 style="color: black">{{ $circular->post_title }}</h2>
                    <div class="blog-details-content pr-20">
                        <div class="blog-preview-img text-center">
                            <img src="{{ asset(!empty($circular->image) ? $circular->image : 'frontend/assets/images/biddabari-image.jpg') }}" alt="Circular Details" class="img-fluid" style="max-height: 300px">
                        </div>
                        <div class="">
                            <div class="" >
                                <p>Published By: {{ $circular->user->name }} at {{ \Carbon\Carbon::parse($circular->created_at)->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <p class="text-muted">{{ $circular->job_title }}</p>
                        <div class="row mt-4">
                            <div class="col-md-3">
                                <p class="mb-0">Vacancy</p>
                                <p class="mb-0">{{ $circular->vacancy }}</p>
                            </div>
                            <div class="col-md-3">
                                <p class="mb-0">Publish Date</p>
                                <p class="mb-0">{{ $circular->publish_date }}</p>
                            </div>
                            <div class="col-md-3">
                                <p class="mb-0">Expire Date</p>
                                <p class="mb-0">{{ $circular->expire_date }}</p>
                            </div>
                        </div>

                        <div class="mt-3">
                            {!! $circular->description !!}
                        </div>

                        <div class="article-share">
                            <div class="row align-items-center">
                                <div class="col-lg-6 col-md-6">

                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="article-social-icon">
                                        <ul class="social-icon">
                                            <li class="title">Share :</li>
                                            <li>
                                                <a href="https://www.facebook.com/" target="_blank">
                                                    <i class="ri-facebook-fill"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="https://twitter.com/" target="_blank">
                                                    <i class="ri-twitter-fill"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="https://www.pinterest.com/" target="_blank">
                                                    <i class="ri-instagram-line"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="col-lg-4">
                        <div class="side-bar-widget">
                            <h3 class="title">Recent posts</h3>
                            <div class="widget-popular-post">
                                @forelse($recentPosts as $recentPost)
                                    <article class="item">
                                        <a href="{{ route('front.job-circular-details', ['id' => $recentPost->id, 'slug' => $recentPost->slug]) }}" class="thumb">
                                            <img src="{{ asset(isset($recentPost->image) ? $recentPost->image : 'frontend/assets/images/biddabari-image.jpg' ) }}" height="76" width="80" alt="Post">
                                        </a>
                                        <div class="info">
                                            <p>{{ \Carbon\Carbon::parse($recentPost->created_at)->isoFormat('D MMMM, YYYY') }}</p>
                                            <h4 class="title-text">
                                                <a href="{{ route('front.job-circular-details', ['id' => $recentPost->id, 'slug' => $recentPost->slug]) }}">
                                                    {{ str()->words($recentPost->post_title, 8) }}
                                                </a>
                                            </h4>
                                        </div>
                                    </article>
                                @empty
                                    <article class="item">
                                        <p>No Circulars Available</p>
                                    </article>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
