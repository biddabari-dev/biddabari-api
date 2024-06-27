
<div class="modal fade modal-div" id="blogExaModal" data-modal-parent="blogExaModal" data-bs-backdrop="static" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="">
            <form id="courseSectionExamForm" action="" method="post" enctype="multipart/form-data">
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
<div class="modal fade modal-div" id="blogCategoryCourseModal" data-modal-parent="blogCategoryCourseModal" data-bs-backdrop="static" >
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
                                <input type="text" class="form-control" required name="paid_amount" placeholder="Paid Amount" />
                                <span class="text-danger" id="paid_amount"></span>
                            </div>
                            <div class="col-sm-6 select2-div">
                                <label for="paymentStatus">Payment Status</label>
                                <select name="payment_status" class="form-control select2" id="paymentStatus" data-placeholder="Set Payment Status">
                                    <option value=""></option>
                                    <option value="pending">Pending</option>
                                    <option value="partial">Partial</option>
                                    <option value="complete">Complete</option>
                                </select>
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

<div class="modal fade modal-div" id="blogProductModal" data-modal-parent="blogProductModal" data-bs-backdrop="static" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="">
            <form id="productSectionForm" action="" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Update Product Order Status</h5>
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
@push('script')

    <script>
        $(document).on('click', '.blog-course-edit-btn', function () {
            event.preventDefault();
            var courseId = $(this).attr('data-blog-course-id'); //change value
            $.ajax({
                url: base_url+"course-orders/"+courseId+"/edit",
                method: "GET",
                dataType: "JSON",
                success: function (data) {
                    console.log(data);
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
                    $('#courseSectionForm').attr('action', base_url+"course-orders/"+courseId);
                    $('#blogCategoryCourseModal').modal('show');
                }
            })
        })
        $(document).on('submit', $('#courseSectionForm'), function () {

            var totalAmount = Number($('input[name="paid_amount"]').attr('data-total-amount'));
            var paidAmount = Number($('input[name="paid_amount"]').val());
            if (paidAmount > totalAmount)
            {
                $('#paid_amount').text('Paid Amount can\'t be bigger then course Total amount.')
                return false;
            }
        })
    </script>

    <script>
        $(document).on('click', '.blog-exam-edit-btn', function () {
            event.preventDefault();
            var courseId = $(this).attr('data-blog-exam-id'); //change value
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
                    $('#courseSectionExamForm').attr('action', base_url+"exam-orders/"+courseId);
                    $('#blogExaModal').modal('show');
                }
            })
        })
    </script>

    <script>
        $(document).on('click', '.blog-product-edit-btn', function () {
            event.preventDefault();
            var courseId = $(this).attr('data-blog-product-id'); //change value
            $.ajax({
                url: base_url+"product-orders/"+courseId+"/edit",
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
                    $('#productSectionForm').attr('action', base_url+"product-orders/"+courseId);
                    $('#blogProductModal').modal('show');
                }
            })
        })
    </script>



@endpush


