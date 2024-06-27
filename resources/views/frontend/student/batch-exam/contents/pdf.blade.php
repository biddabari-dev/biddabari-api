@extends('frontend.student-master')

{{--@section('title', 'Exam Sheets')--}}

@section('student-body')
    <div class="row">
        <div class="col-12">
            <p>
                <a href="" class="float-end nav-link">Download Now</a>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="my-box px-3 mx-auto mt-5" style="position: relative!important; height: auto;">
                <div id="pdf-container"></div>
            </div>
        </div>
    </div>

@endsection

@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}backend/assets/plugins/pdf-draw/pdfannotate.css">
    <link rel="stylesheet" href="{{ asset('/') }}backend/assets/plugins/pdf-draw/styles.css">
    <style>
        .canvas-container, canvas {}
    </style>
@endpush

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js"></script>
    <script>pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.worker.min.js';</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.3.0/fabric.min.js"></script>
    <script src="{{ asset('/') }}backend/assets/plugins/pdf-draw/arrow.fabric.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.2.0/jspdf.umd.min.js"></script>
    <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
    <script src="{{ asset('/') }}backend/assets/plugins/pdf-draw/pdfannotate.js"></script>
    <script>
        var pdf = new PDFAnnotate("pdf-container", "{{ !empty($sectionContent->pdf_link) ? $sectionContent->pdf_link : asset($sectionContent->pdf_file) }}", {
            onPageUpdated(page, oldData, newData) {
                console.log(page, oldData, newData);
            },
            ready() {
                console.log("Plugin initialized successfully");
            },
            scale: 1.5,
            pageImageCompression: "MEDIUM", // FAST, MEDIUM, SLOW(Helps to control the new PDF file size)
        });

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
@endpush

