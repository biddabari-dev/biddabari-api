@extends('frontend.student-master')

@section('student-body')
    <section class="py-5">
        <div class="container">
            @if(isset($allExams))
                <div class="row">
                    @if(!empty($allExams))
                        @forelse($allExams as $allExam)
                            <div class="col-lg-4 col-md-6">
                                <a href="{{ route('front.student.batch-exam-contents', ['xm_id' => $allExam->id, 'master' => base64_encode($allExam->is_master_exam), 'slug' => $allExam->slug]) }}" @if($allExam->status == 'pending') onclick="event.preventDefault(); toastr.error('Your request is pending. Please wait till your request is approved.')" @endif >
                                    <div class="courses-item">
                                        <img src="{{ asset($allExam->banner) }}" alt="Courses" class="img-fluid w-100" style="height: 230px" />
                                        <div class="content">
                                            <h3>{{ $allExam->title }}</h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div class="col-lg-12">
                                <div class="courses-item">
                                    <p class="text-center">No Exams Enrolled Yet</p>
                                </div>
                            </div>
                        @endforelse
                    @endif
                </div>
            @endif
            @if(isset($batchExam))
                <div class="row">
                    <div class="section-title text-center">
                        <h2> {!! $batchExam->title !!}</h2>
                        <hr class="w-25 mx-auto bg-danger"/>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="courses-details-tab-content">
                                <div class="courses-details-accordion">
                                    <ul class="accordion">
                                        @if(!empty($batchExam->batchExamSections))
                                            @forelse($batchExam->batchExamSections as $batchExamSection)
                                                <li class="accordion-item">
                                                    <a class="accordion-title f-s-26" href="javascript:void(0)">
                                                        <i class="ri-add-fill"></i>
                                                        {{ $batchExamSection->title }}
                                                    </a>
                                                    @if(!empty($batchExamSection->batchExamSectionContents))
                                                        <div class="accordion-content">
                                                            @foreach($batchExamSection->batchExamSectionContents as $batchExamSectionContent)
                                                                @if($batchExamSectionContent->content_type == 'pdf')
                                                                    <a href="{{ route('front.student.show-batch-exam-pdf', ['content_id' => $batchExamSectionContent->id]) }}" data-content-id="{{ $batchExamSectionContent->id }}" class="w-100 show-pdf">
                                                                        <div class="accordion-content-list pt-2 pb-0">
                                                                            <div class="accordion-content-left">

    {{--                                                                            PDF--}}
                                                                                <p class="f-s-20">
{{--                                                                                    <i class="ri-file-text-line"></i>--}}
                                                                                    <img src="{{ asset('/') }}backend/assets/images/icons-bb/pdf.jpg" alt="pdf icon" class="img-16" />
                                                                                    {{ $batchExamSectionContent->title }}</p>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                @endif
                                                                @if($batchExamSectionContent->content_type == 'note')
                                                                        <a href="javascript:void(0)" class="w-100 get-text-data" data-content-id="{{ $batchExamSectionContent->id }}">
                                                                            <div class="accordion-content-list pt-2 pb-0">
                                                                                <div class="accordion-content-left">
    {{--                                                                                Note--}}
                                                                                    <p class="f-s-20"><i class="ri-file-text-line"></i> {{ $batchExamSectionContent->title }}</p>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                @endif
                                                                @if($batchExamSectionContent->content_type == 'exam')
                                                                        <a href="javascript:void(0)" class="w-100 get-text-data" data-content-id="{{ $batchExamSectionContent->id }}">
                                                                            <div class="accordion-content-list pt-2 pb-0">
                                                                                <div class="accordion-content-left">
                                                                                    <p class="f-s-20">
{{--                                                                                        <i class="ri-file-text-line"></i> --}}
                                                                                        <img src="{{ asset('/') }}backend/assets/images/icons-bb/MCQ.jpg" alt="pdf icon" class="img-16" />
                                                                                        {{ $batchExamSectionContent->title }}
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                @endif
                                                                @if($batchExamSectionContent->content_type == 'written_exam')
                                                                        <a href="javascript:void(0)" class="w-100 get-text-data" data-content-id="{{ $batchExamSectionContent->id }}">
                                                                            <div class="accordion-content-list pt-2 pb-0">
                                                                                <div class="accordion-content-left">
                                                                                    {{--                                                                        Written Exam--}}
                                                                                    <p class="f-s-20">
{{--                                                                                        <i class="ri-file-text-line"></i> --}}
                                                                                        <img src="{{ asset('/') }}backend/assets/images/icons-bb/Written-exam-icon.jpg" alt="pdf icon" class="img-16" />
                                                                                        {{ $batchExamSectionContent->title }}
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </li>
                                            @empty
                                                <li class="accordion-item">
                                                    <a class="accordion-title" href="javascript:void(0)">
                                                        No Content Available Yet
                                                    </a>
                                                </li>
                                            @endforelse
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="" id="">

                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <div class="modal fade " id="commonPrintModel" data-bs-backdrop="static" data-modal-parent="courseContentModal" >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" >
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View Content</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="card card-body p-0">
                        <div class="" id="printHere"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade video-modal" id="videoModal" data-modal-parent="courseContentModal" >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" >
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Watch Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="card card-body">
                        <div class="private d-none">
                            <video class="w-100 video" height="500" controls="controls" controlist="nodownload">
                                <source id="privatVid" src="//samplelib.com/lib/preview/mp4/sample-5s.mp4" type="video/mp4">
                            </video>
                        </div>
                        <div class="youtube d-none">
                            <iframe width="100%" id="youtubePlayer" height="500" src="" title="YouTube video player" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; " allowfullscreen></iframe>
                        </div>
                        <div class="vimeo d-none">
                            <div style="padding:56.25% 0 0 0;position:relative;">
                                <iframe id="vimeoPlayer" src="" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade show-pdf-modal" id="pdfModal" data-bs-backdrop="static" data-modal-parent="courseContentModal" >
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content" >
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View Class Pdf</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="card card-body p-0" id="pdfContentPrintDiv">
                        <div class="my-box px-3 mx-auto mt-5" style="position: relative!important; height: auto;">
                            <div id="pdf-container"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <style>
        .mcq-xm th {font-size: 24px}
        .mcq-xm td {font-size: 22px}
        .written-xm th {font-size: 24px}
        .written-xm td {font-size: 22px}
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--<link rel="stylesheet" href="{{ asset('/') }}backend/assets/plugins/pdf-draw/pdfannotate.css">-->
    <!--<link rel="stylesheet" href="{{ asset('/') }}backend/assets/plugins/pdf-draw/styles.css">-->
    <style>
        .canvas-container, canvas { /*width: 100%!important;*/ margin-top: 10px!important;}
    </style>
    
    <link rel="stylesheet" href="{{ asset('/') }}backend/ppdf/css/pdfviewer.jquery.css" />
    <style>
        .pdf-toolbar {display: none;}
        #pdf-container {overflow: scroll; height: 500px;}
        .aks-video-player { width: 99%!important;/* min-height: 450px*/}
    </style>

@endpush

@section('js')


<script>

    $(document).on('click', '.get-text-data', function () {
        var contentId = $(this).attr('data-content-id');
        $.ajax({
            url:"{{ route('front.student.get-batch-exam-text-type-content') }}",
            method: "GET",
            data: {content_id:contentId},
            success: function (data) {
                console.log(data);
                $('#printHere').html(data);
                $('#commonPrintModel').modal('show');
            }
        })
    })
</script>


 <!--ppdf-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js"></script>
    <script src="{{ asset('/') }}backend/ppdf/js/pdfviewer.jquery.js"></script>

<script>
    $(document).on('click', '.show-pdf', function () {
        event.preventDefault();
        var sectionContentId = $(this).attr('data-content-id');
        $.ajax({
            url: base_url+"student/batch-exam-show-pdf/"+sectionContentId,
            method: "GET",
            success: function (data) {
                var pdflink = '';
                if(data.sectionContent.pdf_link != null )
                {
                    pdflink = data.sectionContent.pdf_link;
                } else {
                    pdflink = base_url+data.sectionContent.pdf_file;
                }
                $('#pdf-container').empty().pdfViewer(pdflink);
                // var pdf = new PDFAnnotate("pdf-container", pdflink, {
                //     onPageUpdated(page, oldData, newData) {
                //         console.log(page, oldData, newData);
                //     },
                //     ready() {
                //         console.log("Plugin initialized successfully");
                //     },
                //     scale: 1.5,
                //     pageImageCompression: "MEDIUM", // FAST, MEDIUM, SLOW(Helps to control the new PDF file size)
                // });
                // $('#pdfContentPrintDiv').html(data);
                $('.show-pdf-modal').modal('show');
            }
        })

    })
</script>
{{--    video --}}
    <script src="https://player.vimeo.com/api/player.js"></script>
    <script>
        $(document).on('click', '.open-video-modal', function () {
            var videoVendor = $(this).attr('data-video-vendor');
            var videoLink = $(this).attr('data-video-link');
            if (videoVendor == 'youtube')
            {
                const arrayOne = videoLink.split('https://www.youtube.com/watch?v=')
                var splitVidUrl = arrayOne[1].split('&')[0];
                $('.youtube').removeClass('d-none');
                $('.private').addClass('d-none');
                $('.vimeo').addClass('d-none');
                $('#youtubePlayer').attr('src', 'https://www.youtube.com/embed/'+splitVidUrl);
                $('.video-modal').modal('show');
            } else if (videoVendor == 'private')
            {
                $('.private').removeClass('d-none');
                $('.youtube').addClass('d-none');
                $('.vimeo').addClass('d-none');
                $('#privatVid').attr('src', videoLink);
                $('.video-modal').modal('show');
            } else if (videoVendor == 'vimeo')
            {
                $('.private').removeClass('d-none');
                $('.youtube').addClass('d-none');
                $('.vimeo').addClass('d-none');
                $('#vimeoPlayer').attr('src', 'https://player.vimeo.com/video/'+videoLink+'?h=627084a88d&autoplay=0&loop=1&title=0&byline=0&portrait=0');
                $('.video-modal').modal('show');
            }
        })
    </script>
    <script>
        $(function () {
            $('.video').bind('contextmenu',function () {
                return false;
            })
        })
    </script>
@endsection
