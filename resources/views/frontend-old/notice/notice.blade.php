@extends('frontend.master')

@section('body')

    <div class="courses-area-two section-bg py-5">
        <div class="container">
            <div class="section-title text-center mb-3">
                <!--   <span>কোর্স সমূহ</span>-->
                <h2> সকল নোটিশ  সমূহ</h2>
                <hr class="w-25 mx-auto bg-danger"/>
            </div>
            <div class="row">
                <div class="col-md-8">
                    @if(count($notices) > 0)
                        @forelse($notices as $key => $notice)
                            @if(isset($_GET['notice-id']))
                                @if($notice->id == $_GET['notice-id'])
                                    <div class="courses-item notice-content">
                                        <div class="content ">
                                            <h3><a href="javascript:void(0)">{{ $notice->title }}</a></h3>
                                            @if(isset($notice->image))
                                                <div class="row">
                                                    <div class="col-md-6 mx-auto">
                                                        <img src="{{ asset($notice->image) }}" alt="" class="img-fluid" />
                                                    </div>
                                                </div>
                                            @endif
                                            <span class="dis-course-amount">{!! $notice->body !!}</span>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="courses-item notice-content">
                                    <div class="content ">
                                        <h3><a href="javascript:void(0)">{{ $notices[0]->title }}</a></h3>
                                        @if(isset($notices[0]->image))
                                            <div class="row">
                                                <div class="col-md-6 mx-auto">
                                                    <img src="{{ asset($notices[0]->image) }}" alt="" class="img-fluid" />
                                                </div>
                                            </div>
                                        @endif
                                        <span class="dis-course-amount">{!! $notices[0]->body !!}</span>
                                    </div>
                                </div>
                                @break
                            @endif
                        @empty
                        <div class="courses-item notice-content">
                            <div class="content ">
                                <p><a href="javascript:void(0)">No Notices Published Yet.</a></p>
                            </div>
                        </div>
                        @endforelse
                    @endif

                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header py-0" style="background-color: #F18345;">
                            <p class="text-center text-white f-s-38 mb-0">Latest Notices</p>
                        </div>
                        @forelse($notices as $notice)
                            <div class="card-body py-2 border-bottom">
                                <a href="{{ route('front.notices', ['notice-id' => $notice->id]) }}" class="w-100">
                                    <div class="row">
                                        <div class="col-md-4 px-0">
                                            <img src="{{ !empty($notice->image) ? asset($notice->image) : asset('/frontend/logo/biddabari-card-logo.jpg') }}" alt="" class="img-fluid">
                                        </div>
                                        <div class="col-md-8">
                                            <div>
                                                <span class="text-muted">{{ showDateFormatTwo($notice->created_at) }}</span>
                                                <p class="f-s-20 p-0">{{ $notice->title }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div class="card-body">
                                <p><a href="javascript:void(0)">No Notices Published Yet.</a></p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
