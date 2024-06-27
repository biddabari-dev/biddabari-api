@extends('frontend.student-master')

@section('student-body')
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="section-title text-center">
                    <h2> আজকের ক্লাস সমূহ</h2>
                    <hr class="w-25 mx-auto bg-danger"/>
                </div>
                <div class="col-md-6">
                    <div class="courses-details-tab-content">
                        <div class="courses-details-accordion">
                            <ul class="accordion">
                                @if(!empty($courseClassContents))
                                    @forelse($courseClassContents as $courseSectionContent)
                                        <li class="accordion-item">

                                            @if($courseSectionContent->content_type == 'pdf')
                                                <a href="javascript:void(0)" data-content-id="{{ $courseSectionContent->id }}" data-has-class-xm="{{ $courseSectionContent->has_class_xm }}" data-complete-class-xm="{{ $courseSectionContent->classXmStatus }}" class="w-100 show-pdf accordion-title f-s-26">
                                                    <span class="f-s-26"><i class="ri-file-text-line"></i> {{ $courseSectionContent->title }}</span>
                                                </a>
                                            @endif
                                            @if($courseSectionContent->content_type == 'video')
                                                <a href="javascript:void(0)" class="w-100 open-video-modal accordion-title f-s-26" data-has-class-xm="{{ $courseSectionContent->has_class_xm }}" data-complete-class-xm="{{ $courseSectionContent->classXmStatus }}" data-video-link="{{ $courseSectionContent->video_link }}" data-video-vendor="{{ $courseSectionContent->video_vendor }}" data-content-id="{{ $courseSectionContent->id }}">
                                                    <span class="f-s-26"><i class="ri-file-text-line"></i> {{ $courseSectionContent->title }}</span>
                                                </a>
                                            @endif
                                            @if($courseSectionContent->content_type == 'note')
                                                <a href="javascript:void(0)" class="w-100 get-text-data accordion-title f-s-26" data-has-class-xm="{{ $courseSectionContent->has_class_xm }}" data-complete-class-xm="{{ $courseSectionContent->classXmStatus }}" data-content-id="{{ $courseSectionContent->id }}">
                                                    <span class="f-s-26"><i class="ri-file-text-line"></i> {{ $courseSectionContent->title }}</span>
                                                </a>
                                            @endif
                                            @if($courseSectionContent->content_type == 'live')
                                                <a href="javascript:void(0)" class="w-100 get-text-data accordion-title f-s-26" data-has-class-xm="{{ $courseSectionContent->has_class_xm }}" data-complete-class-xm="{{ $courseSectionContent->classXmStatus }}" data-content-id="{{ $courseSectionContent->id }}">
                                                    <span class="f-s-26"><i class="ri-file-text-line"></i> {{ $courseSectionContent->title }}</span>
                                                </a>
                                            @endif
                                            @if($courseSectionContent->content_type == 'link')
                                                <a href="javascript:void(0)" class="w-100 get-text-data accordion-title f-s-26" data-has-class-xm="{{ $courseSectionContent->has_class_xm }}" data-complete-class-xm="{{ $courseSectionContent->classXmStatus }}" data-content-id="{{ $courseSectionContent->id }}">
                                                    <span class="f-s-26"><i class="ri-file-text-line"></i> {{ $courseSectionContent->title }}</span>
                                                </a>
                                            @endif
                                            @if($courseSectionContent->content_type == 'assignment')
                                                <a href="javascript:void(0)" class="w-100 get-text-data accordion-title f-s-26" data-has-class-xm="{{ $courseSectionContent->has_class_xm }}" data-complete-class-xm="{{ $courseSectionContent->classXmStatus }}" data-content-id="{{ $courseSectionContent->id }}">
                                                    <span class="f-s-26"><i class="ri-file-text-line"></i> {{ $courseSectionContent->title }}</span>
                                                </a>
                                            @endif
                                            @if($courseSectionContent->content_type == 'testmoj')
                                                <a href="javascript:void(0)" class="w-100 get-text-data accordion-title f-s-26" data-has-class-xm="{{ $courseSectionContent->has_class_xm }}" data-complete-class-xm="{{ $courseSectionContent->classXmStatus }}" data-content-id="{{ $courseSectionContent->id }}">
                                                    <span class="f-s-26"><i class="ri-file-text-line"></i> {{ $courseSectionContent->title }}</span>
                                                </a>
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
                    <div class="" id="printHere">

                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade video-modal" id="videoModal" data-bs-backdrop="static" data-modal-parent="courseContentModal" >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" >
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Watch Class Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="card card-body p-0">
                        <div class="private d-none">
                            <video class="w-100 video" height="500" controls="controls" controlist="nodownload">
                                <source id="privatVid" src="//samplelib.com/lib/preview/mp4/sample-5s.mp4" type="video/mp4">
                            </video>
                        </div>
                        <div class="youtube d-none">
                            {{--                            <iframe style="width: 100%!important;" id="youtubePlayer" height="500" src="" title="YouTube video player" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; " allowfullscreen></iframe>--}}
                            {{--                            <iframe width="560" height="315" src="https://www.youtube.com/embed/PNF0OJITows" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>--}}
                            <div class="video-container" >
                                <div class="video-foreground">
                                    <iframe style="width: 100%!important;" height="500" id="youtubePlayer" src="" title="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" ></iframe>
                                </div>
                            </div>
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
    <link rel="stylesheet" href="{{ asset('/') }}backend/assets/plugins/pdf-draw/pdfannotate.css">
    <link rel="stylesheet" href="{{ asset('/') }}backend/assets/plugins/pdf-draw/styles.css">
    <style>
        .canvas-container, canvas { /*width: 100%!important;*/ margin-top: 10px!important;}
    </style>
    <style>
        .video-container{
            width:100%!important;
            height: 440px;
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
            /*height: calc(80% + 100px);*/
            height: 500px!important;
        }
        .video-foreground{
            pointer-events:auto;
        }

    </style>
@endpush

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js"></script>
    <script>pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.worker.min.js';</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.3.0/fabric.min.js"></script>
    <script src="{{ asset('/') }}backend/assets/plugins/pdf-draw/arrow.fabric.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.2.0/jspdf.umd.min.js"></script>
    <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
    <script src="{{ asset('/') }}backend/assets/plugins/pdf-draw/pdfannotate.js"></script>
    {{--    <script src="{{ asset('/') }}backend/assets/plugins/pdf-draw/functions.js"></script>--}}
    <script>


        function changeActiveTool(event) {
            var element = $(event.target).hasClass("tool-button")
                ? $(event.target)
                : $(event.target).parents(".tool-button").first();
            $(".tool-button.active").removeClass("active");
            $(element).addClass("active");
        }

        function enableSelector(event) {
            event.preventDefault();
            changeActiveTool(event);
            pdf.enableSelector();
        }

        function enablePencil(event) {
            event.preventDefault();
            changeActiveTool(event);
            pdf.enablePencil();
        }

        function enableAddText(event) {
            event.preventDefault();
            changeActiveTool(event);
            pdf.enableAddText();
        }

        function enableAddArrow(event) {
            event.preventDefault();
            changeActiveTool(event);
            pdf.enableAddArrow();
        }

        function addImage(event) {
            event.preventDefault();
            pdf.addImageToCanvas()
        }

        function enableRectangle(event) {
            event.preventDefault();
            changeActiveTool(event);
            pdf.setColor('rgba(255, 0, 0, 0.3)');
            pdf.setBorderColor('blue');
            pdf.enableRectangle();
        }

        function deleteSelectedObject(event) {
            event.preventDefault();
            pdf.deleteSelectedObject();
        }

        function savePDF() {
            // pdf.savePdf();
            pdf.savePdf("written-ans"); // save with given file name
        }

        function clearPage() {
            pdf.clearActivePage();
        }

        function showPdfData() {
            var string = pdf.serializePdf();
            $('#dataModal .modal-body pre').first().text(string);
            PR.prettyPrint();
            $('#dataModal').modal('show');
        }

        $(function () {
            $('.color-tool').click(function () {
                $('.color-tool.active').removeClass('active');
                $(this).addClass('active');
                color = $(this).get(0).style.backgroundColor;
                pdf.setColor(color);
            });

            $('#brush-size').change(function () {
                var width = $(this).val();
                pdf.setBrushSize(width);
            });

            $('#font-size').change(function () {
                var font_size = $(this).val();
                pdf.setFontSize(font_size);
            });
        });

    </script>
    {{--    note--}}
    <script>
        $(document).on('click', '.get-text-data', function () {
            var status = checkHasClassXm($(this));
            if (status == true)
            {
                var contentId = $(this).attr('data-content-id');
                $.ajax({
                    url:"{{ route('front.student.get-text-type-content') }}",
                    method: "GET",
                    data: {content_id:contentId},
                    success: function (data) {
                        // console.log(data);
                        $('#printHere').html(data);
                    }
                })
            } else {
                return false;
            }
        })
        function checkHasClassXm(elementObject) {
            var hasClassXm = elementObject.attr('data-has-class-xm');
            var isClassXmComplete = elementObject.attr('data-complete-class-xm');
            if (isClassXmComplete == 1)
            {
                return true;
            } else {
                if (hasClassXm == 0)
                {
                    return true;
                } else {
                    $.ajax({
                        url:"{{ route('front.student.show-class-exam-ajax') }}",
                        method: "GET",
                        data: {content_id:elementObject.attr('data-content-id')},
                        success: function (data) {
                            // console.log(data);
                            $('#printHere').html(data);
                        }
                    })
                }
            }
        }
    </script>
    {{--    video --}}
    <script src="https://player.vimeo.com/api/player.js"></script>
    <script>
        $(document).on('click', '.open-video-modal', function () {
            var status = checkHasClassXm($(this));
            if (status == true)
            {

                var videoVendor = $(this).attr('data-video-vendor');
                var videoLink = $(this).attr('data-video-link');
                if (videoVendor == 'youtube')
                {
                    // const arrayOne = videoLink.split('https://www.youtube.com/watch?v=')
                    const arrayOne = videoLink.split('https://youtu.be/')
                    var splitVidUrl = arrayOne[1].split('&')[0];
                    $('.youtube').removeClass('d-none');
                    $('.private').addClass('d-none');
                    $('.vimeo').addClass('d-none');
                    $('#youtubePlayer').attr('src', 'https://www.youtube.com/embed/'+splitVidUrl+'?rel=0&amp;modestbranding=1');
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

            } else {

                return false;
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
    <script>
        $(document).on('click', '.show-pdf', function () {
            event.preventDefault();
            var status = checkHasClassXm($(this));
            if (status == true)
            {
                var sectionContentId = $(this).attr('data-content-id');
                $.ajax({
                    // url: base_url+"student/show-pdf/"+sectionContentId,
                    url: "https://biddabari-bucket.obs.as-south-208.rcloud.reddotdigitalit.com/student/show-pdf/"+sectionContentId,
                    method: "GET",
                    success: function (data) {
                        var pdflink = '';
                        if(data.sectionContent.pdf_link != null )
                        {
                            pdflink = data.sectionContent.pdf_link;
                        } else {
                            pdflink = base_url+data.sectionContent.pdf_file;
                        }
                        var pdf = new PDFAnnotate("pdf-container", pdflink, {
                            onPageUpdated(page, oldData, newData) {
                                console.log(page, oldData, newData);
                            },
                            ready() {
                                console.log("Plugin initialized successfully");
                            },
                            scale: 1.5,
                            pageImageCompression: "MEDIUM", // FAST, MEDIUM, SLOW(Helps to control the new PDF file size)
                        });
                        // $('#pdfContentPrintDiv').html(data);
                        $('.show-pdf-modal').modal('show');
                    }
                })
            } else {
                return false;
            }

        })
        function LoadCss(url) {
            var link = document.createElement("link");
            link.type = "text/css";
            link.rel = "stylesheet";
            link.href = url;
            document.getElementsByTagName("head")[0].appendChild(link);
        }
        function LoadScript(url) {
            var script = document.createElement('script');
            script.setAttribute('src', url);
            script.setAttribute('async', false);
            document.body.appendChild(script);
        }

    </script>

    <script>

    </script>
@endsection
