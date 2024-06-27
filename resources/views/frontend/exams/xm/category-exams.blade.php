@extends('frontend.master')

@section('body')
    <div class="courses-area-two section-bg pt-100 pb-70">
        <div class="container">
            <div class="col-md-12">
                <div class="text-center mb-5">
                    <a href="javascript:void(0)" class="btn border-main-color"><span class="fw-bolder fs-2">{{ count($examCategories) > 0 ? 'আমাদের এক্সাম ক্যাটাগরি সমূহ' : 'আমাদের এক্সাম সমূহ' }}</span></a>
                </div>
                <div class="row">
                    @if(count($examCategories) > 0)
                        @foreach($examCategories as $examCategory)
                            <div class="col-md-4 col-sm-6 px-1">
                                <div class="courses-item pb-0">
                                    <a href="{{ route('front.category-exams', ['xm_cat_id' => $examCategory->id, 'name' => $examCategory->name]) }}">
                                        <img src="{{ !empty($examCategory->image) ? asset($examCategory->image) : 'https://i.ibb.co/vjLMjf4/302781896-3331421830467947-4650783196296068552-n.jpg' }}" alt="Courses" class="w-100" style="height: 230px"/>

                                        <div class="content">
                                            <h3>{{ $examCategory->name }}</h3>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        @forelse($exams as $exam)
                            <div class="col-md-4 col-sm-6 px-0">
                                <div class="courses-item">
                                    <a href="javascript:void(0)">
                                        <img src="{{ !empty($exam->image) ? asset($exam->image) : 'https://i.ibb.co/vjLMjf4/302781896-3331421830467947-4650783196296068552-n.jpg' }}" alt="Courses" class="w-100" style="height: 230px"/>
                                    </a>
                                    <div class="content">
                                        <h3><a href="javascript:void(0)">{{ $exam->title }}</a></h3>

                                        <div class="bottom-content">
                                            <a href="javascript:void(0)" class="">
                                                <i class="fas fa-clock"></i> {{ $exam->xm_duration }} min
                                            </a>
                                            <div class="rating ">
                                                <a href="{{ route('front.view-exam', ['xm_id' => $exam->id, 'slug' => $exam->slug]) }}" class="btn btn-outline-primary">বিস্তারিত</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-md-12">
                                <div class="text-center">
                                    <h2>কোনো কোর্স চালু হয়নি।  খুব দ্রুত কোর্স চালু হবে। </h2>
                                </div>
                            </div>
                        @endforelse
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
