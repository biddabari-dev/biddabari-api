@extends('backend.master')

@section('title', 'Payments')

@section('body')
    <div class="row mt-5">
        <div class="col-sm-8 mx-auto">
            <div class="card card-body">
                <h2 class="text-capitalize ">Payments functionality will be available after integrating payment getway. </h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Manage Payments</h2>
                </div>
                <div class="card-body">
                    <table class="table" id="file-datatable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer Name</th>
                            <th>Order No.</th>
                            <th>P.Type</th>
                            <th>Ordered For</th>
                            <th>Module Name</th>
{{--                            <th>Amount</th>--}}
                            <th>Payment Info</th>
                            <th>Bank Tran Id</th>
                            <th>Gateway Val Id</th>
                            <th>Enroll Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($sslPayments))
                            @foreach($sslPayments as $sslPayment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>#{{ $sslPayment->user->name }}</td>
                                    <td>#{{ $sslPayment->order_invoice_number }}</td>
                                    <td>{{ $sslPayment->payment_method }}</td>
                                    <td>{{ $sslPayment->ordered_for }}</td>
                                    <td>
                                        {{ $sslPayment->ordered_for == 'course' ? $sslPayment->course->title : '' }}
                                        {{ $sslPayment->ordered_for == 'batch_exam' ? $sslPayment->batchExam->title : '' }}
                                        {{ $sslPayment->ordered_for == 'product' ? $sslPayment->product->title : '' }}
                                    </td>
                                    <td>
                                        Total: {{ $sslPayment->total_amount }} <br>
                                        Paid: {{ $sslPayment->paid_amount ?? 0 }} <br>
                                        Due: {{ $sslPayment->total_amount - $sslPayment->paid_amount }}
                                    </td>
                                    <td>{{ $sslPayment->bank_tran_id }}</td>
                                    <td>{{ $sslPayment->gateway_val_id }}</td>
                                    <td>{{ $sslPayment->created_at->format('d M, Y') }}</td>
                                    <td>
                                        <span href="javascript:void(0)" class="badge bg-primary m-1">Order - {{ $sslPayment->status }}</span>
                                    </td>
                                    <td>
                                        <a href="" data-order-id="{{ $sslPayment->id }}" class="btn btn-sm btn-warning show-order-details" title="Change Order Status">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>


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
    <div class="modal fade modal-div" id="courseDetailsModal" data-modal-parent="blogCategoryModal" data-bs-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" id="">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Course Order Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="card card-body" id="courseDetailsCard">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')

{{--    @include('backend.includes.assets.plugin-files.datatable')--}}
    {{--    @include('backend.includes.assets.plugin-files.date-time-picker')--}}
    {{--    @include('backend.includes.assets.plugin-files.editor')--}}
<script src="{{ asset('/backend/assets/plugins/printThis/printThis.js') }}"></script>
<script>
    $(document).on('click', '.show-order-details', function () {
        event.preventDefault();
        var orderId = $(this).attr('data-order-id'); //change value
        $.ajax({
            url: base_url+"get-order-details/"+orderId,
            method: "GET",
            // dataType: "JSON",
            success: function (data) {
                console.log(data);
                $('#courseDetailsCard').empty().append(data);
                $('#courseDetailsModal').modal('show');
            }
        })
    })
    $(document).on('click', '.print-btn', function () {
        event.preventDefault();
        $("#print-div").printThis({
            debug: false,               // show the iframe for debugging
            importCSS: true,            // import parent page css
            importStyle: false,         // import style tags
            printContainer: true,       // print outer container/$.selector
            loadCSS: "",                // path to additional css file - use an array [] for multiple
            pageTitle: "",              // add title to print page
            removeInline: false,        // remove inline styles from print elements
            removeInlineSelector: "*",  // custom selectors to filter inline styles. removeInline must be true
            printDelay: 333,            // variable print delay
            header: null,               // prefix to html
            footer: null,               // postfix to html
            base: false,                // preserve the BASE tag or accept a string for the URL
            formValues: true,           // preserve input/form values
            canvas: false,              // copy canvas content
            doctypeString: '',       // enter a different doctype for older markup
            removeScripts: false,       // remove script tags from print content
            copyTagClasses: false,      // copy classes from the html & body tag
            beforePrintEvent: null,     // function for printEvent in iframe
            beforePrint: null,          // function called before iframe is filled
            afterPrint: null            // function called before iframe is removed
        });
    })
</script>
@endpush
