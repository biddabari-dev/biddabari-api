@extends('frontend.master')

@section('body')
    <div class="blog-details-area pt-100 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="blog-details-content pr-20">
                        <h2 class="text-center f-s-36 ">{{ $blog->title }}</h2>
                        <div class="blog-preview-img text-center">
                            @if(!empty($blog->video_url))

                                <div class="video-container" >
                                    <div class="video-foreground">
                                        <iframe style="width: 100%;" height="500" src="https://www.youtube.com/embed/{{ $blog->video_url }}?rel=0&amp;modestbranding=1" title="blog video title" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" ></iframe>
                                    </div>
                                </div>
                                @else
                            <img src="{{ asset($blog->image) }}" alt="Blog Details" class="img-fluid" style="max-height: 400px">
                                @endif
                        </div>
                        <ul class="tag-list">
                            <li><i class="ri-calendar-todo-fill"></i> {{ $blog->created_at->format('M d, Y') }}</li>
                            <li><i class="ri-price-tag-3-fill"></i> {{ $blog->blogCategory->name }}</li>
                        </ul>
                        <p>{!! $blog->body !!}</p>

                        <div class="comments-form">
                            <div class="contact-form">
                                <h4>Leave A Reply</h4>
                                <form id="" action="{{ route('front.new-comment') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="type" value="blog">
                                    <input type="hidden" name="parent_model_id" value="{{ $blog->id }}">
                                    <input type="hidden" name="name" value="{{ auth()->check() ? auth()->user()->name : '' }}">
                                    <input type="hidden" name="email" value="{{ auth()->check() ? auth()->user()->email : '' }}">
                                    <input type="hidden" name="mobile" value="{{ auth()->check() ? auth()->user()->mobile : '' }}">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <textarea name="message" class="form-control" id="" cols="30" rows="3" required placeholder="Comment..."></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <button type="submit" @if(!auth()->check()) onclick="event.preventDefault(); toastr.error('Please Login First');" @endif class="default-btn">
                                                Post A Comment
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{--dynamic data--}}
                        @foreach($comments as $comment)
                            <div class="py-2">
                                <div class="d-flex flex-row w-100">
                                    <div class="d-flex flex-column">
                                        <div class="com-img-box">
                                            @if(isset($comment->user->profile_photo_path))
                                                <img src="{{ asset( $comment->user->profile_photo_path ) }}" alt="user-image" class="comment-user-image">
                                            @else
                                                <img src="https://www.vhv.rs/dpng/d/509-5096993_login-icon-vector-png-clipart-png-download-user.png" alt="user-image" class="comment-user-image">
                                            @endif
                                        </div>
                                    </div>

                                    <div class="d-flex flex-column bg-light ml-2 w-100 px-2">
                                        <p class="mb-0 f-s-20 ">{{ $comment->user->name }}</p>
                                        <p class="text-justify ps-3">{{ $comment->message }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header py-0" style="background-color: #F18345;">
                            <p class="text-center text-white f-s-38 mb-0">Latest Blogs</p>
                        </div>
                        @forelse($recentBlogs as $recentBlog)
                            <div class="card-body py-2 border-bottom">
                                <a href="{{ route('front.blog-details', ['id' => $recentBlog->id, 'slug' => $recentBlog->slug]) }}">
                                    <div class="row">
                                        <div class="col-md-4 px-0">
                                            <img src="{{ !empty($recentBlog->image) ? asset($recentBlog->image) : asset('/frontend/logo/biddabari-card-logo.jpg') }}" alt="" class="img-fluid" style="height: 100px"/>
                                        </div>
                                        <div class="col-md-8">
                                            <div>
                                                <span class="text-muted">{{ showDateFormatTwo($recentBlog->created_at) }}</span>
                                                <p class="f-s-20 p-0">{{ \Illuminate\Support\Str::words($recentBlog->title, 8,'...') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div class="card-body">
                                <p><a href="javascript:void(0)">No Blogs Published Yet.</a></p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('style')
    <style>
        /*review section*/
        .no-pad p {
            margin-bottom: 2px!important;
        }
        .comment-user-image {
            border-radius: 60%;
            width: 40px;
            height: 40px;
        }
        .com-img-box {
            /*height: 78px;*/
            width: 56px;
        }
        .main-comment p {
            margin-bottom: 2px!important;
        }
        .sub-replay p {
            margin-bottom: 2px !important;
        }
        .bb-1px {
            border-bottom: 1px solid black;
        }
    </style>
    <style>
        .video-container{
            width:100%;
            height:500px;
            overflow:hidden;
            position:relative;
        }
        .video-container iframe{
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        .video-container iframe{
            position: absolute;
            top: -60px;
            left: 0;
            width: 100%;
            /*height: calc(50% + 100px);*/
            height: 500px;
        }
        .video-foreground{
            pointer-events:auto;
        }

    </style>
@endpush
@push('script')
    <script src="{{ asset('/') }}frontend/assets/js/page-js/product-comments.js"></script>
    <script>
        function equalheight() {
            var maxHeight = 0;
            $('.card-body').each(function (index) {
                if ($(this).height() > maxHeight)
                    maxHeight = $(this).height();
            });
            $('.card-body').height(maxHeight);
        }
        $(document).ready(function () {
            equalheight();
        });
    </script>
@endpush
