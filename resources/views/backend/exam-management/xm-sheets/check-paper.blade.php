@extends('backend.master')

@section('title', 'Exam Sheets')

@section('body')
    <div class="row mt-5">
        <div class="col-sm-8 mx-auto">
            <div class="card card-body">
                <form action="{{ route('update-written-xm-result', ['id' => $examSheet->id, 'examOf' => $examOf, 'sectionContentType' => $sectionContentType]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row" >
                        <div class="col select2-div">
                            <label for="">Total Mark</label>
                            <input type="text" class="form-control" name="result_mark" />
                        </div>
                        <div class="col select2-div">
                            <label for="">Update Script</label>
                            <input type="file" class="form-control" name="written_xm_file" accept="application/pdf" />
                        </div>
                        <div class="col-auto">
                            <input type="submit" class="btn btn-success ms-4 " style="margin-top: 18px" value="Update" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="my-box mx-auto mt-5" style="position: relative!important; height: auto;">
                <div class="toolbar" style="position: sticky!important;">
                    <div class="tool">
                        <span>Bidda Bari</span>
                    </div>
                    <div class="tool">
                        <label for="">Brush size</label>
                        <input type="number" class="form-control text-center" value="1" id="brush-size" max="50">
                    </div>
                    <div class="tool">
                        <label for="">Font size</label>
                        <select id="font-size" class="">
                            <option value="10">10</option>
                            <option value="12">12</option>
                            <option value="16" selected>16</option>
                            <option value="18">18</option>
                            <option value="24">24</option>
                            <option value="32">32</option>
                            <option value="48">48</option>
                            <option value="64">64</option>
                            <option value="72">72</option>
                            <option value="108">108</option>
                        </select>
                    </div>
                    <div class="tool mt-1">
                        <button class="color-tool active" style="background-color: #212121;"></button>
                        <button class="color-tool" style="background-color: red;"></button>
                        <button class="color-tool" style="background-color: blue;"></button>
                        <button class="color-tool" style="background-color: green;"></button>
                        <button class="color-tool" style="background-color: yellow;"></button>
                    </div>
                    <div class="tool">
                        <button class="tool-button active"><i class="fa fa-hand-paper-o" title="Free Hand" onclick="enableSelector(event)"></i></button>
                    </div>
                    <div class="tool">
                        <button class="tool-button"><i class="fa fa-pencil" title="Pencil" onclick="enablePencil(event)"></i></button>
                    </div>
                    <div class="tool">
                        <button class="tool-button"><i class="fa fa-font" title="Add Text" onclick="enableAddText(event)"></i></button>
                    </div>
                    <div class="tool">
                        <button class="tool-button"><i class="fa fa-long-arrow-right" title="Add Arrow" onclick="enableAddArrow(event)"></i></button>
                    </div>
                    <div class="tool">
                        <button class="tool-button"><i class="fa fa-square-o" title="Add rectangle" onclick="enableRectangle(event)"></i></button>
                    </div>
                    <div class="tool">
                        <button class="tool-button"><i class="fa fa-picture-o" title="Add an Image" onclick="addImage(event)"></i></button>
                    </div>
                    <div class="tool">
                        <button class="btn btn-danger btn-sm" onclick="deleteSelectedObject(event)"><i class="fa fa-trash"></i></button>
                    </div>
                    <div class="tool">
                        <button class="btn btn-danger btn-sm" onclick="clearPage()">Clear Page</button>
                    </div>
{{--                                                <div class="tool">--}}
{{--                                                    <button class="btn btn-info btn-sm" onclick="showPdfData()">{}</button>--}}
{{--                                                </div>--}}
                    <div class="tool">
                        <button class="btn btn-primary btn-sm" onclick="savePDF()"><i class="fa fa-save"></i> Save</button>
                    </div>
                </div>
                <div id="pdf-container">

                </div>
            </div>
        </div>
    </div>

@endsection

@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}backend/assets/plugins/pdf-draw/pdfannotate.css">
    <link rel="stylesheet" href="{{ asset('/') }}backend/assets/plugins/pdf-draw/styles.css">
    <style>
        .canvas-container, canvas { width: 100%!important; margin-top: 10px!important;}
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
        var pdf = new PDFAnnotate("pdf-container", "{{ asset($sectionContentType =='assignment' ? $examSheet->file : $examSheet->written_xm_file) }}", {
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
            pdf.savePdf("written-ans-{{ $examSheet->id }}"); // save with given file name
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

