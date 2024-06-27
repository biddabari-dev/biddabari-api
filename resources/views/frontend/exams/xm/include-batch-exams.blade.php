<div class="col-md-4 col-sm-6 px-1 open-modal" data-xm-id="{{ $batchExam->id }}" style="cursor: pointer;">
    <div class="courses-item pb-0">
        {{--                                <a href="{{ route('front.category-exams', ['xm_cat_id' => $batchExam->id, 'name' => $batchExam->name]) }}">--}}

        <img src="{{ !empty($batchExam->banner) ? asset($batchExam->banner) : asset('/frontend/logo/biddabari-card-logo.jpg') }}" alt="Batch Exams" class="w-100" style="height: 230px"/>

        <div class="px-3 pt-3">
            <h3>{{ $batchExam->title }}</h3>
        </div>

        <div class="d-flex px-3 pb-3">
            {{--                                        <span class="me-auto">Price: {{ $batchExam->price }} BDT</span> <br>--}}
            @if($batchExam->purchase_status == 'true')
             <a href="{{route('front.student.batch-exam-contents',$batchExam->id)}}">Purchased</a>
                <!--<button type="button" class="btn text-success ms-auto">Purchased</button>-->
            @elseif($batchExam->purchase_status == 'pending')
                <button type="button" class="btn text-success ms-auto">Pending</button>
            @else
            <button type="button" class="btn btn-outline-success btn-sm ms-auto " >কোর্সটি কিনুন</button>
                <!--<button type="button" class="btn btn-outline-success btn-sm ms-auto " >View</button>-->
            @endif
        </div>
    </div>
</div>
