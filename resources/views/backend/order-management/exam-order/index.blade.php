@extends('backend.master')

@section('title', 'Manage Batch Exam')

@section('body')

    @if(isset($examOrders) && !empty($examOrders))
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Manage Batch Exam Orders</h2>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table" id="file-datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Order No.</th>
                                    <th>Exam Title</th>
                                    <th>S. Name</th>
                                    <th>Payment</th>
                                    <th>Payment Info</th>
{{--                                    <th>Vendor</th>--}}
{{--                                    <th>Paid Form</th>--}}
{{--                                    <th>Paid to</th>--}}
                                    <th>Txt Id</th>
                                    <th>Enroll Date</th>

{{--                                    <th>Payment Status</th>--}}
{{--                                    <th>Contact Status</th>--}}
                                    <th>Status</th>
                                    @can('change-batch-exam-contact-status')
                                        <th>Contacted By</th>
                                    @endcan
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(isset($examOrders))
                                @foreach($examOrders as $examOrder)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>#{{ $examOrder->order_invoice_number }}</td>
                                        <td>{{ $examOrder->batchExam->title }}</td>
                                        <td>{{ $examOrder->user->name }} <br> {{ $examOrder->user->mobile }}</td>
                                        <td>
                                            Total: {{ $examOrder->total_amount }} <br>
                                            Paid: {{ $examOrder->paid_amount ?? 0 }} <br>
                                            Due: {{ $examOrder->total_amount - $examOrder->paid_amount }}
                                        </td>
                                        <td>
                                            @if($examOrder->payment_method == 'cod')
                                                Vendor- {{ $examOrder->vendor }} <br>
                                                From- {{ $examOrder->paid_from }} <br> To- {{ $examOrder->paid_to }}
                                            @elseif($examOrder->payment_method == 'ssl')
                                                TranId: {{ $examOrder->bank_tran_id }} <br>
                                                ValId: {{ $examOrder->gateway_val_id }} <br>
                                                GtStatus: {{ $examOrder->gateway_status }} <br>
                                            @endif
                                        </td>
{{--                                        <td>{{ $examOrder->vendor ?? '' }}</td>--}}
{{--                                        <td>{{ $examOrder->paid_from }}</td>--}}
{{--                                        <td>{{ $examOrder->paid_to }}</td>--}}
                                        <td>{{ $examOrder->txt_id }}</td>
                                        <td>{{ $examOrder->created_at->format('d M, Y') }}</td>

{{--                                        <td>{{ $examOrder->payment_status }}</td>--}}
                                        <td>
{{--                                            <span href="javascript:void(0)" class="badge bg-primary m-1">Contact - {{ $examOrder->contact_status }}</span>--}}
{{--                                            <br>--}}
{{--                                            <span href="javascript:void(0)" class="badge bg-primary m-1">Order - {{ $examOrder->status }}</span>--}}
                                            <a href="javascript:void(0)" class="badge bg-{{$examOrder->status=='approved' ? 'success':'danger'}} m-1">Order {{ $examOrder->status }}</a>
                                        </td>
{{--                                        <td>--}}
{{--                                            <a href="javascript:void(0)" class="badge bg-primary">{{ $examOrder->status }}</a>--}}
{{--                                        </td>--}}
                                        @can('change-batch-exam-contact-status')
                                            <td>{{ $examOrder->chckedBy->name ?? '' }}</td>
                                        @endcan
                                        <td>
                                            @can('update-batch-exam-order')
                                            <a href="" data-blog-category-id="{{ $examOrder->id }}" class="btn btn-sm btn-warning blog-category-edit-btn" title="Change Order Status">
                                                <i class="fa-solid fa-edit"></i>
                                            </a>
                                            @endcan
{{--                                            @can('change-batch-exam-contact-status')--}}
{{--                                            <a href="" data-blog-category-id="{{ $examOrder->id }}" class="btn btn-sm btn-primary blog-category-edit-btnx" title="Change Order Status">--}}
{{--                                                <i class="fa-solid fa-edit"></i>--}}
{{--                                            </a>--}}
{{--                                                @endcan--}}
                                            @can('delete-batch-exam-order')
                                            <form class="d-inline" action="{{ route('exam-orders.destroy', $examOrder->id) }}" method="post" >
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-danger data-delete-form" title="Delete Blog Category">
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
{{--                        {{ $examOrders->links() }}--}}
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="modal fade modal-div" id="blogCategoryModal" data-modal-parent="blogCategoryModal" data-bs-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" id="">
                <form id="courseSectionForm" action="" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="">Update Course Order Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body">

                        <div class="card card-body">
                            @csrf
                            @method('put')
{{--                            <input type="hidden" id="courseIdEdit" name="edit_course_id" />--}}
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="paidAmount">Paid Amount</label>
                                    <input type="text" class="form-control" name="paid_amount" placeholder="Paid Amount" />
                                    <span class="text-danger" id="paid_amount"></span>
                                </div>

                                <div class="col-sm-6 select2-div">
                                    <label for="paymentStatus">Order Status</label>
                                    <select name="status" class="form-control select2" id="paymentStatus" data-placeholder="Set Order Status">
                                        <option value=""></option>
                                        <option value="pending">Pending</option>
                                        <option value="approved">Approved</option>
                                        <option value="canceled">Canceled</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary " value="save">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade modal-div" id="contactStatusModal" data-modal-parent="blogCategoryModal" data-bs-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" id="">
                <form id="contactStatusForm" action="" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="">Update Course Order Contact Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body">

                        <div class="card card-body">
                            @csrf
{{--                            <input type="hidden" id="courseIdEdit" name="edit_course_id" />--}}
                            <div class="row">
                                <div class="col-sm-6 select2-div">
                                    <label for="paymentStatus">Contact Status</label>
                                    <select name="contact_status" class="form-control select2" id="paymentStatus" data-placeholder="Set Contact Status">
                                        <option value=""></option>
                                        <option value="pending">Pending</option>
                                        <option value="not_answered">Not Answered</option>
                                        <option value="confirmed">Confirmed</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary " value="save">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')

    @include('backend.includes.assets.plugin-files.datatable')
    {{--    @include('backend.includes.assets.plugin-files.date-time-picker')--}}
    {{--    @include('backend.includes.assets.plugin-files.editor')--}}

    {{--    edit course category--}}
    <script>
        $(document).on('click', '.blog-category-edit-btn', function () {
            event.preventDefault();
            var courseId = $(this).attr('data-blog-category-id'); //change value
            $.ajax({
                url: base_url+"exam-orders/"+courseId+"/edit",
                method: "GET",
                dataType: "JSON",
                success: function (data) {
                    // console.log(data);
                    if (data.paid_amount > 0)
                    {
                        $('input[name="paid_amount"]').val(data.paid_amount);
                    } else {
                        $('input[name="paid_amount"]').val(data.total_amount);
                    }
                    $('input[name="paid_amount"]').attr('data-total-amount', data.total_amount);
                    $.each($('select[name="payment_status"] option'), function (paymentIndex, payment) {
                        if ($(this).val() == data.payment_status)
                        {
                            $(this).attr('selected', true);
                        }
                    })
                    $.each($('select[name="contact_status"] option'), function (contactIndex, contact) {
                        if ($(this).val() == data.contact_status)
                        {
                            $(this).attr('selected', true);
                        }
                    })
                    $.each($('select[name="status"] option'), function (statusIndex, status) {
                        if ($(this).val() == data.status)
                        {
                            $(this).attr('selected', true);
                        }
                    })
                    $(".select2").select2({
                        minimumResultsForSearch: "",
                        width: "100%",

                    })
                    $('#courseSectionForm').attr('action', base_url+"exam-orders/"+courseId);
                    $('#blogCategoryModal').modal('show');
                }
            })
        })
    </script>


    <script>
        $(document).on('click', '.blog-category-edit-btnx', function () {
            event.preventDefault();
            var courseId = $(this).attr('data-blog-category-id'); //change value
            $.ajax({
                url: base_url+"exam-orders/"+courseId+"/edit",
                method: "GET",
                dataType: "JSON",
                success: function (data) {
                    // console.log(data);
                    $.each($('select[name="contact_status"] option'), function (contactIndex, contact) {
                        if ($(this).val() == data.contact_status)
                        {
                            $(this).attr('selected', true);
                        }
                    })
                    $(".select2").select2({
                        minimumResultsForSearch: "",
                        width: "100%",

                    })
                    $('#contactStatusForm').attr('action', base_url+"exam-orders/status/"+courseId);
                    $('#contactStatusModal').modal('show');
                }
            })
        })
        $(document).on('submit', $('#courseSectionForm'), function () {
            var totalAmount = Number($('input[name="paid_amount"]').attr('data-total-amount'));
            var paidAmount = Number($('input[name="paid_amount"]').val());
            if (paidAmount > totalAmount)
            {
                $('#paid_amount').text('Paid Amount can\'t be bigger then Batch Exam Total amount.')
                return false;
            }
        })
    </script>

@endpush
