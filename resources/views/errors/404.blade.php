@extends('frontend.master')

@section('body')
    {{-- <div class="error-area ptb-100">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="error-content">
                    <h1>4 <span>0</span> 4</h1>
                    <h3>Oops! Page Not Found</h3>
                    <p>The page you are looking for might have been removed had its name changed or is temporarily unavailable.</p>
                    <a href="{{ url()->previous() }}" class="default-btn">
                        Return To Previous Page
                    </a>
                    <a href="{{ url('/') }}" class="default-btn">
                        Return To Home Page
                    </a>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="ud-main-content">
        <div class="ud-container error__container">
            <img src="https://s.udemycdn.com/error_page/error-desktop-v1.jpg"
                srcset="https://s.udemycdn.com/error_page/error-desktop-v1.jpg 1x, https://s.udemycdn.com/error_page/error-desktop-2x-v1.jpg 2x"
                alt="" width="480" height="360">
            <h1 class="ud-heading-serif-xxl error__greeting">
                We can’t find the page you’re looking for
            </h1>
            <p class="error__cta ud-text-with-links">
                Visit our <a href="/contact-us">support page</a> for further assistance.
            </p>
        </div>
    </div>
@endsection
