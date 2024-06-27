<div class="comments-form">
    <div class="contact-form">
        <h4>Leave A Reply</h4>
        <form id="" action="{{ route('front.new-comment') }}" method="post">
            @csrf
            <input type="hidden" name="type" value="{{ $type }}">
            <input type="hidden" name="parent_model_id" value="{{ $contentId }}">
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
@if(isset($comments))
    @foreach($comments as $comment)
            <div class="py-2 px-3">
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
@endif
