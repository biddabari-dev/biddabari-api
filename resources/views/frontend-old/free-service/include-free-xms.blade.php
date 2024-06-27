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
                    <a href="{{ route('front.student.start-exam', ['xm_id' => $exam->id, 'slug' => $exam->slug]) }}" class="btn btn-outline-primary">টেস্ট দিন</a>
                </div>
            </div>
        </div>
    </div>
</div>
