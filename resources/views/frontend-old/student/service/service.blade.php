@extends('frontend.student-master')
@section('student-body')
    <section class="py-5">
        <div class="">
            <div class="row custom_col_12">
                <div class="section-title text-center">
                    <h2> Student Orders</h2>
                    <hr class="w-25 mx-auto bg-danger"/>
                </div>

                <div class="col-lg-12 col-md-6">
                    <div class="courses-item py-5">
                        <div class="row m-2">
                            <div class="col-md-6">
                                <form action="" method="get">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check form-switch">
                                                <input required type="text" class="form-control" id="search" name="search"
                                                       value="{{isset($_GET['search']) && $_GET['search'] != ''?$_GET['search']:''}}"
                                                       placeholder="number">
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <input type="submit" class="btn btn-success ms-1" style="" value="Search" id="search"/>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6 ">
                                <button id="complainbtn" type="button" class="btn btn-primary float-end open-modal d-none " data-bs-toggle="modal" data-bs-target="#complainmodal" >Add complain</button>
{{--                                <button type="button" data-bs-toggle="modal" data-bs-target="#courseCategoryModal" class="rounded-circle btn btn-primary border-5 text-light f-s-22 btn position-absolute end-0 me-4 open-modal">Add</button>--}}
                            </div>
                        </div>
                        @if(count($orders)>0)
                            <div class="content">
                                <div class="row">
                                    <div class="card">
                                        <div class="card-body">
                                            <table>
                                                <tr>
                                                    <h5>Name : {{$user->name}}</h5>
                                                </tr>
                                                <tr>
                                                    <h5>Phone : {{$user->mobile}} </h5>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="custom_tab_pan_li">
                                    <ul class="nav nav-pills mb-3 text-center" id="pills-tab" role="tablist"
                                        style="margin-left: 30%">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active f-s-22" id="pills-home-tab"
                                                    data-bs-toggle="pill" data-bs-target="#pills-all" type="button"
                                                    role="tab" aria-controls="pills-home" aria-selected="true">All
                                                Orders
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link f-s-22" id="pills-home-tab" data-bs-toggle="pill"
                                                    data-bs-target="#pills-course" type="button" role="tab"
                                                    aria-controls="pills-home" aria-selected="true">Course
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link f-s-22" id="pills-profile-tab" data-bs-toggle="pill"
                                                    data-bs-target="#pills-batch-exam" type="button" role="tab"
                                                    aria-controls="pills-profile" aria-selected="false">Batch Exam
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link f-s-22" id="pills-contact-tab" data-bs-toggle="pill"
                                                    data-bs-target="#pills-product" type="button" role="tab"
                                                    aria-controls="pills-contact" aria-selected="false">Product
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content overflow-scroll" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-all" role="tabpanel"
                                         aria-labelledby="pills-home-tab">
                                        <table class="table table-striped table-bordered table-hover">
                                            <tr>
                                                <th>sl</th>
                                                <th>Order No</th>
                                                <th>Item Name</th>
                                                <th>Price</th>
                                                <th>Due</th>
                                                <th>Enroll Date</th>
                                                <th>Status</th>
                                            </tr>
                                            @foreach($orders as $order)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>#{{ $order->order_invoice_number }}</td>
                                                    @if($order->ordered_for == 'course')
                                                        <td class="custome_td">{{ $order->course->title }}</td>
                                                    @elseif($order->ordered_for == 'batch_exam')
                                                        <td class="custome_td">{{ $order->batchExam->title }}</td>
                                                    @else
                                                        <td class="custome_td">{{ $order->product->title }}</td>
                                                    @endif
                                                    <td>{{ $order->total_amount }}</td>
                                                    <td>{{ $order->total_amount - $order->paid_amount }}</td>
                                                    <td>{{ $order->created_at->format('d - m - Y') }}</td>
                                                    <td>
                                                        {{ $order->status }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                    <div class="tab-pane fade " id="pills-course" role="tabpanel"
                                         aria-labelledby="pills-home-tab">
                                        <table class="table table-striped table-bordered table-hover">
                                            <tr>
                                                <th>sl</th>
                                                <th>Order No</th>
                                                <th>Item Name</th>
                                                <th>Price</th>
                                                <th>Partial Payment</th>
                                                <th>Due</th>
                                                <th>Enroll Date</th>
                                                <th>Status</th>
                                            </tr>
                                            @foreach($orders as $order)
                                                @if($order->ordered_for == 'course')
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>#{{ $order->order_invoice_number }}</td>
                                                        <td class="custome_td">{{ $order->course->title }}</td>
                                                        <td>{{ $order->total_amount }}</td>
                                                        <td>{{ $order->total_amount > $order->paid_amount ?  $order->paid_amount : $order->total_amount }}</td>
                                                        <td>{{ $order->total_amount - $order->paid_amount }}</td>
                                                        <td>{{ $order->created_at->format('d - m - Y') }}</td>
                                                        <td>
                                                            {{ $order->status }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="pills-batch-exam" role="tabpanel"
                                         aria-labelledby="pills-profile-tab">
                                        <table class="table table-striped table-bordered table-hover">
                                            <tr>
                                                <th>sl</th>
                                                <th>Order No</th>
                                                <th>Item Name</th>
                                                <th>Price</th>
                                                <th>Due</th>
                                                <th>Enroll Date</th>
                                                <th>Status</th>
                                            </tr>
                                            @foreach($orders as $order)
                                                @if($order->ordered_for == 'batch_exam')
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>#{{ $order->order_invoice_number }}</td>
                                                        <td class="custome_td">{{ $order->batchExam->title }}</td>
                                                        <td>{{ $order->total_amount }}</td>
                                                        <td>{{ $order->total_amount - $order->paid_amount }}</td>
                                                        <td>{{ $order->created_at->format('d - m - Y') }}</td>
                                                        <td>
                                                            {{ $order->status }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="pills-product" role="tabpanel"
                                         aria-labelledby="pills-contact-tab">
                                        <table class="table table-striped table-bordered table-hover">
                                            <tr>
                                                <th>sl</th>
                                                <th>Order No</th>
                                                <th>Item Name</th>
                                                <th>Price</th>
                                                <th>Due</th>
                                                <th>Enroll Date</th>
                                                <th>Status</th>
                                            </tr>
                                            @foreach($orders as $order)
                                                @if($order->ordered_for == 'product')
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>#{{ $order->order_invoice_number }}</td>
                                                        <td class="custome_td">{{ $order->product->title }}</td>
                                                        <td>{{ $order->total_amount }}</td>
                                                        <td>{{ $order->total_amount - $order->paid_amount }}</td>
                                                        <td>{{ $order->created_at->format('d - m - Y') }}</td>
                                                        <td>
                                                            {{ $order->status }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="container">
                                <div class="row">
                                    <h4>Data have no record</h4>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade modal-div" data-bs-backdrop="static" id="complainmodal">
            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable-body">
                <div class="modal-content">
                    <form action="" method="post" enctype="multipart/form-data" id="courseCategoryForm">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create Course Category</h5>
                            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                        </div>

                        <div class="modal-body" id="formModalBody">
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label for="">Name</label>
                                    <input type="text" name="name" required class="form-control" placeholder="Name" />
                                    <span class="text-danger" id="name"></span>
                                </div>
                                <div class="col-md-6 position-relative">
                                    {{--                                <input type="checkbox" id="switch5" name="status" switch="warning" />--}}
                                    {{--                                <label for="switch5" class="f-s-16"></label>--}}

                                    <div class="float-start">
                                        <div class="material-switch">
                                            <input id="someSwitchOptionInfo" name="status" type="checkbox" checked />
                                            <label for="someSwitchOptionInfo" class="label-info"></label>
                                        </div>
                                        <label for="" class="switch-label">Active</label>
                                        <span class="text-danger" id="status"></span>
                                    </div>

                                    {{--                                <input type="checkbox" id="switch4" name="is_featured" switch="warning" />--}}
                                    {{--                                <label for="switch4" class="f-s-16"></label>--}}


                                    <div class="float-start ms-3">
                                        <div class="material-switch">
                                            <input id="someSwitchOptionWarning" name="is_featured" type="checkbox" checked />
                                            <label for="someSwitchOptionWarning" class="label-info"></label>
                                        </div>
                                        <label for="" class="switch-label">Featured</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <label for="">Note</label>
                                    <textarea name="note" class="form-control" id="summernote" placeholder="Note" cols="30" rows="10"></textarea>
                                    <span class="text-danger" id="note"></span>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <label for="">Icon Class <br><span class="text-warning">[Use Font Awesome 6.4.0 classes]</span></label>
                                    <input type="text" name="icon" class="form-control" placeholder="Icon CLass">
                                    <span class="text-danger" id="icon"></span>

                                </div>
                                <div class="col-md-4 mt-2">
                                    <label for="">Image <span class="text-red">(300 X 200 + WEBP)</span> </label>
                                    <input type="file" name="image" id="categoryImage" accept="images/*">
                                    <span class="text-danger" id="image"></span>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <div>
                                        <img src="" id="imagePreview" style=""/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            {{--                        <button type="reset" class="btn btn-warning">Reset</button>--}}
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button disabled type="submit" class="btn btn-primary submit-btn" value="save">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script>
        // console.log('sarowar');
        // $('#complainbtn').addclass('d-none').attr('data-active', '');
        $(document).on('click', '#search', function () {
            // console.log('sarowar');
            var serarch=$('#search').val();
            if(serarch !=0){
                $('#complainbtn').removeClass('d-none').attr('data-active', '');
            }


        })
        $('#complainbtn').removeClass('d-none').attr('data-active', '');
    </script>
@endsection
