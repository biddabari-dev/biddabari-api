@extends('frontend.master')

@section('body')

    <div class="container">
        <div class="inner-title text-center">
            <p style="margin: 30px 0; font-size: 50px; color: black;"> <span style="padding: 5px 10px; border: 1px solid #f38344; border-radius: 20px;">জব সার্কুলার </span></p>
        </div>
    </div>

    <div class="blog-widget-area pt-100 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">



                    <div>
                        <div>
                            <ul class="nav nav-pills all-course-page-nav-pills text-center">
                                @foreach($circularCategories as $index => $circularCategoryx)
                                    <li class="nav-item mb-3"><button type="button" class="nav-link border-danger btn py-0 mx-2 text-dark" style="border: 1px solid #F18C53" data-bs-toggle="pill" data-bs-target="#{{ 'id'.$index }}"><span class="f-s-35">{{ $circularCategoryx->title }}</span></button></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="tab-content mt-5">
                            @foreach($circularCategories as $key => $circularCategory)
                                <div class="tab-pane fade show active" id="{{ 'id'.$key }}">
                                    @if(count($circularCategory->circulars) > 0)
                                        <div class="row pb-5">
                                            @foreach($circularCategory->circulars as $circular)
                                                <div class="col-lg-4 col-md-6">
                                                    <a href="{{ route('front.job-circular-details', ['id' => $circular->id,'slug' => $circular->slug]) }}" class="w-100">
                                                        <div class="card h-100 d-flex align-items-stretch" style="border: none; border-radius: 20px 20px 0 0">
                                                                <img src="{{ asset(!empty($circular->image) ? $circular->image : 'frontend/assets/images/biddabari-image.jpg') }}" alt="Circular" class="w-100 img-fluid" style="height: 250px; border-radius: 20px 20px 0 0" />
                                                            <div class="card-body" style="background-color: #fef4f2;">
                                                                <p style="color: #0a080e" class="f-s-18">{{ $circular->circularCategory->title }}</p>
                                                                <h3 class="f-s-28">{{ $circular->post_title }}</h3>
                                                                <p class="f-s-21">{{ $circular->job_title }}</p>
                                                            </div>
                                                            <div class="card-footer position-relative" style="border-radius: 0 0 20px 20px; background-color: #fcd9c6;">
                                                                <h3 style="color: #5c636a; margin: 0; font-size: 25px">{{ $circular->user->name }}</h3>
                                                                <p style="margin: 0; font-size: 19px; color: #f38344;">{{ \Carbon\Carbon::parse($circular->created_at)->format('M d, Y') }}</p>
                                                                <button type="button" class="btn btn-light position-absolute end-0 me-3" style="top: 20%;">Read More</button>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="row pb-5">
                                            <div class="col-md-12">
                                                <div class="text-center">
                                                    <h2>কোনো কোর্স চালু হয়নি।  খুব দ্রুত কোর্স চালু হবে। </h2>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


@endsection
