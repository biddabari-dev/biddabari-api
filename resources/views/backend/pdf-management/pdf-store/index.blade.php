@extends('backend.master')

@section('title', 'PDF Stores')

@section('body')
    <div class="row py-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">PDF Store</h4>
                    @can('create-pdf')
                        <button type="button" data-bs-toggle="modal" data-bs-target="#coursesModal" class="rounded-circle open-modal text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4"><i class="fa-solid fa-circle-plus"></i></button>
                    @endcan
                </div>
                <div class="card-body">
                    <table class="table" id="file-datatable">
                        <thead>
                            <tr>
{{--                                <th>#</th>--}}
                                <th>PDF Category</th>
                                <th>Title</th>
{{--                                <th>Ext Link</th>--}}
{{--                                <th>PDF file</th>--}}
{{--                                <th>Size</th>--}}
                                <th>Can Download?</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($pdfStores))
                                @foreach($pdfStores as $pdfStore)
                                    <tr>
{{--                                        <td>{{ $loop->iteration }}</td>--}}
                                        <td>{{ $pdfStore->pdfStoreCategory->title }}</td>
                                        <td>{{ $pdfStore->title }}</td>
{{--                                        <td><a href="{{ $pdfStore->file_external_link }}" target="_blank">External Link</a></td>--}}
{{--                                        <td>--}}
{{--                                            <a href="{{ asset($pdfStore->file_url) }}" class="show-pdf" data-id="{{ $pdfStore->id }}">{{ $pdfStore->title }}</a>--}}
{{--                                        </td>--}}
                                        <td>{{ $pdfStore->can_download == 1 ? 'Downloadable' : 'Not Downloadable' }}</td>
                                        <td>
                                            <a href="" data-id="{{ $pdfStore->id }}" class="btn btn-sm btn-secondary show-pdf" title="View Pdf">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            @can('edit-pdf')
                                                <a href="" data-blog-id="{{ $pdfStore->id }}" class="btn btn-sm btn-warning edit-btn" title="Edit Pdf">
                                                    <i class="fa-solid fa-edit"></i>
                                                </a>
                                            @endcan
                                            @can('delete-pdf')
                                                <form class="d-inline" action="{{ route('pdf-stores.destroy', $pdfStore->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-sm btn-danger data-delete-form" title="Delete Pdf">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                                @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-div" id="coursesModal" data-bs-backdrop="static" data-modal-parent="coursesModal" >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" id="modalForm">
                @include('backend.pdf-management.pdf-store.form')
            </div>
        </div>
    </div>
    <div class="modal fade show-pdf-modal" id="pdfModal" data-bs-backdrop="static" data-modal-parent="courseContentModal" >
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content" >
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View Class Pdf</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
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
    <!-- DragNDrop Css -->
{{--    <link href="{{ asset('/') }}backend/assets/css/dragNdrop.css" rel="stylesheet" type="text/css" />--}}
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
@endpush

@push('script')
{{--    datatable--}}
@include('backend.includes.assets.plugin-files.datatable')
@include('backend.includes.assets.plugin-files.editor')

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js"></script>
<script>pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.worker.min.js';</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.3.0/fabric.min.js"></script>
<script src="{{ asset('/') }}backend/assets/plugins/pdf-draw/arrow.fabric.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.2.0/jspdf.umd.min.js"></script>
<script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
<script src="{{ asset('/') }}backend/assets/plugins/pdf-draw/pdfannotate.js"></script>
{{--    <script src="{{ asset('/') }}backend/assets/plugins/pdf-draw/functions.js"></script>--}}
<script>
    {{--var pdf = new PDFAnnotate("pdf-container", "{{ !empty($sectionContent->pdf_link) ? $sectionContent->pdf_link : asset($sectionContent->pdf_file) }}", {--}}
    {{--    onPageUpdated(page, oldData, newData) {--}}
    {{--        console.log(page, oldData, newData);--}}
    {{--    },--}}
    {{--    ready() {--}}
    {{--        console.log("Plugin initialized successfully");--}}
    {{--    },--}}
    {{--    scale: 1.5,--}}
    {{--    pageImageCompression: "MEDIUM", // FAST, MEDIUM, SLOW(Helps to control the new PDF file size)--}}
    {{--});--}}

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

<script>
    $(document).on('click', '.show-pdf', function () {
        event.preventDefault();
        var sectionContentId = $(this).attr('data-id');
        $.ajax({
            url: base_url+"get-pdf-store-file/"+sectionContentId,
            method: "GET",
            success: function (data) {
                console.log(data);
                var pdflink = '';
                if(data.file_url != null )
                {
                    pdflink = base_url+data.file_url;
                }
                $('#pdf-container').empty();
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
    $(document).on('click', '.open-modal', function () {
        event.preventDefault();
        // resetForm('coursesForm');
        $('#coursesModal').modal('show');
    })
</script>

    {{--    store course--}}
    <script>
        $(document).on('click', '.submit-btn', function () {
            event.preventDefault();
            var form = $('#coursesForm')[0];
            var formData = new FormData(form);
            $.ajax({
                url: "{{ route('pdf-stores.store') }}",
                method: "POST",
                data: formData,
                dataType: "JSON",
                contentType: false,
                processData: false,
                success: function (message) {
                    // console.log(message);
                    toastr.success(message);
                    $('#coursesModal').modal('hide');
                    window.location.reload();
                },
                error: function (errors) {
                    if (errors.responseJSON)
                    {
                        $('span[class="text-danger"]').empty();
                        var allErrors = errors.responseJSON.errors;
                        for (key in allErrors)
                        {
                            $('#'+key).empty().append(allErrors[key]);
                        }
                    }
                }
            })
        })
    </script>

{{--    edit course category--}}
    <script>
        $(document).on('click', '.edit-btn', function () {
            event.preventDefault();
            var courseId = $(this).attr('data-blog-id');
            $.ajax({
                url: base_url+"pdf-stores/"+courseId+"/edit",
                method: "GET",
                success: function (data) {
                    $('#modalForm').empty().append(data);

                    $('#coursesModal').modal('show');
                }
            })
        })
    </script>
{{-- update course category--}}
    <script>
        // $(document).on('click', '.update-btn', function () {
        //     event.preventDefault();
        //     var formData = $('#courseCategoryForm').serialize();
        //     $.ajax({
        //         url: $('#courseCategoryForm').attr('action'),
        //         method: "PUT",
        //         data: formData,
        //         dataType: "JSON",
        //         // async: false,
        //         // cache: false,
        //         contentType: false,
        //         processData: false,
        //         // enctype: 'multipart/form-data',
        //         success: function (message) {
        //             // console.log(formData);
        //             toastr.success(message);
        //             $('.update-btn').addClass('submit-btn').removeClass('update-btn');
        //             $('#courseCategoryForm').attr('action', '');
        //             $('#courseCategoryModal').modal('hide');
        //             window.location.reload();
        //             resetInputFields();
        //         }
        //     })
        // })
    </script>

    <script>
        $(document).ready(function() {
            $('#image').change(function() {
                var imgURL = URL.createObjectURL(event.target.files[0]);
                $('#imagePreview').attr('src', imgURL).css({
                    height: 150+'px',
                    width: 150+'px',
                    marginTop: '5px'
                });
            });
        });
    </script>
<script>
    $(document).on('keyup', 'input:not(#discountAmount),textarea', function () {
        var selectorId = $(this).attr('name');
        if ($('#'+selectorId).text().length)
        {
            $('#'+selectorId).text('');
        }
    })
    $(document).on('change', 'select', function () {
        var selectorId = $(this).attr('name');
        if ($('#'+selectorId).text().length)
        {
            $('#'+selectorId).text('');
        }
    })
    {{--        // date time error empty not working--}}
    {{--        // $(document).on('click', '#dateTime', function () {--}}
    {{--        //     var selectorId = $(this).attr('name');--}}
    {{--        //     alert('hi');--}}
    {{--        //     if ($('#'+selectorId).text().length)--}}
    {{--        //     {--}}
    {{--        //         $('#'+selectorId).text('');--}}
    {{--        //     }--}}
    {{--        // })--}}
</script>
@endpush
