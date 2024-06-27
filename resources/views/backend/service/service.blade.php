@extends('backend.master')

@section('title', 'Services')
@section('body')
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
                                                       placeholder="Student mobile">
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <input type="submit" class="btn btn-success ms-1" style="" value="Search" id="search"/>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                        @if(isset($user))
                            <div class="content">
                                <div class="row">
                                    <div class="col-md-8">
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
                                    <div class="col-md-4">
                                       <div class="card">
                                           <div class="card-body">
                                               <div class="col-md-6 ">
                                                   @can('service-complain')
                                                   <button id="complainbtn" type="button" class="btn btn-success float-end open-modal d-none " data-bs-toggle="modal" data-bs-target="#complainmodal" >Add complain</button>
                                                   @endcan
                                                   {{--                                <button type="button" data-bs-toggle="modal" data-bs-target="#courseCategoryModal" class="rounded-circle btn btn-primary border-5 text-light f-s-22 btn position-absolute end-0 me-4 open-modal">Add</button>--}}
                                               </div>
                                           </div>
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

                            <div class="content">

                                <div class="custom_tab_pan_li">
                                    <div class="row ">
                                        <div class="card">
                                            <div class="card-title">
                                                <h1 class="text-center text-secondary">Service Section</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-content overflow-scroll" id="">
                                    <div class="tab-pane fade show active" id="" role="tabpanel"
                                         aria-labelledby="pills-home-tab">
                                        <table class="table table-striped table-bordered table-hover">
                                            <tr>
                                                <th>#</th>
                                                <th>Service</th>
                                                <th>User</th>
                                                <th>order_invoice_number</th>
                                                <th>Complain</th>
                                                <th>Service Status</th>
                                                {{--                            <th>Stock</th>--}}
                                                {{--                            <th>Image</th>--}}
                                                <th>Admin Status</th>
                                                <th>Actions</th>
                                            </tr>
                                            @foreach($services as $order)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $order->complainIssuedBy->name }}</td>
                                                    <td>{{ $order->studentUser->name }}</td>
                                                    @if($order->parentOrder->ordered_for == 'course')
                                                        <td class="custome_td">{{ $order->parentOrder->course->title }}</td>
                                                    @elseif($order->parentOrder->ordered_for == 'batch_exam')
                                                        <td class="custome_td">{{ $order->parentOrder->batchExam->title }}</td>
                                                    @else
                                                        <td class="custome_td">{{ $order->parentOrder->product->title }}</td>
                                                    @endif
                                                    <td>{{ $order->complain_text }}</td>
                                                    <td>{{ $order->status }}</td>
                                                    <td>{{ $order->admin_status }}</td>
                                                    <td>
                                                        @can('service-status-edit')
                                                        <button href="" data-service-status="{{$order->id}}" class="btn btn-sm btn-warning service-status-edit-btn" title="Edit Blog Category">
                                                            <i class="fa-solid fa-edit"></i>
                                                        </button>
                                                        @endcan
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>

                                </div>
                            </div>
                            <div class="modal fade modal-div" id="blogCategoryCourseModal" data-modal-parent="blogCategoryCourseModal" data-bs-backdrop="static" >
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content" id="">
                                        <form id="courseServiceForm" action="" method="post" enctype="multipart/form-data">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="">Update Service Status</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                                            </div>
                                            <div class="modal-body">

                                                <div class="card card-body">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-sm-6 select2-div">
                                                            <label for="paymentStatus">Service Status</label>
                                                            <select name="status" class="form-control select2" id="" data-placeholder="Set service Status">
                                                                <option value=""></option>
                                                                <option value="pending">pending</option>
                                                                <option value="complete">complete</option>
                                                                <option value="processing">processing</option>
                                                                <option value="canceled">canceled</option>
                                                            </select>
                                                        </div>
{{--                                                        <div class="col-sm-6 select2-div">--}}
{{--                                                            <label for="paymentStatus">Admin Status</label>--}}
{{--                                                            <select name="admin_status" class="form-control select2" id="" data-placeholder="Set Admin Status">--}}
{{--                                                                <option value=""></option>--}}
{{--                                                                <option value="pending">pending</option>--}}
{{--                                                                <option value="satisfy">satisfy</option>--}}
{{--                                                                <option value="not_satisfy">not_satisfy</option>--}}
{{--                                                            </select>--}}
{{--                                                        </div>--}}
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
                            <div class="modal fade modal-div" data-bs-backdrop="static" id="complainmodal">
                                <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable-body">
                                    <div class="modal-content">
                                        <form action="{{route('my_services.store')}}" method="post" enctype="multipart/form-data" id="courseCategoryForm">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Create Complain</h5>
                                                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                                            </div>

                                            <div class="modal-body" id="formModalBody">
                                                @php
                                                    $service= \Illuminate\Support\Facades\Auth::user()->id;
                                                @endphp
                                                {{--                            <label for="">Service_User_id</label>--}}
                                                <input hidden type="text" name="complain_issued_by" value="{{$service}}">
                                                {{--                            <label for="">Student user id</label>--}}
                                                @if($user != null)
                                                    <input hidden type="text" name="student_user_id" value="{{$user->id}}">
                                                @endif

                                                {{--                            <div class="row mt-2">--}}
                                                {{--                                <div class="col-md-6">--}}
                                                {{--                                    <label for="">Name</label>--}}
                                                {{--                                    <input type="text" name="name" required class="form-control" placeholder="Name" />--}}
                                                {{--                                    <span class="text-danger" id="name"></span>--}}
                                                {{--                                </div>--}}
                                                {{--                                <div class="col-md-6 position-relative">--}}
                                                {{--                                <input type="checkbox" id="switch5" name="status" switch="warning" />--}}
                                                {{--                                <label for="switch5" class="f-s-16"></label>--}}

                                                {{--                                    <div class="float-start">--}}
                                                {{--                                        <div class="material-switch">--}}
                                                {{--                                            <input id="someSwitchOptionInfo" name="status" type="checkbox" checked />--}}
                                                {{--                                            <label for="someSwitchOptionInfo" class="label-info"></label>--}}
                                                {{--                                        </div>--}}
                                                {{--                                        <label for="" class="switch-label">Active</label>--}}
                                                {{--                                        <span class="text-danger" id="status"></span>--}}
                                                {{--                                    </div>--}}

                                                {{--                                <input type="checkbox" id="switch4" name="is_featured" switch="warning" />--}}
                                                {{--                                <label for="switch4" class="f-s-16"></label>--}}


                                                {{--                                    <div class="float-start ms-3">--}}
                                                {{--                                        <div class="material-switch">--}}
                                                {{--                                            <input id="someSwitchOptionWarning" name="is_featured" type="checkbox" checked />--}}
                                                {{--                                            <label for="someSwitchOptionWarning" class="label-info"></label>--}}
                                                {{--                                        </div>--}}
                                                {{--                                        <label for="" class="switch-label">Featured</label>--}}
                                                {{--                                    </div>--}}
                                                {{--                                </div>--}}
                                                {{--                            </div>--}}
                                                <div class="row mt-2">
                                                    <div class="col-md-12">
                                                        <label for="">Complain</label>
                                                        <textarea name="complain_text" class="form-control" id="summernote" placeholder="Note" cols="30" rows="10"></textarea>
                                                        <span class="text-danger" id="note"></span>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="">Service status</label>
                                                        <select class="form-select" name="status" aria-label="Default select example">
                                                            <option selected>Open this select menu</option>
                                                            <option value="complete">Complete</option>
                                                            <option value="processing">Processing</option>
                                                            <option value="admission">Admission</option>
                                                            {{--                                        <option value="not complite">Not Complite</option>--}}
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="">Service status</label>
                                                        <select class="form-select" name="parent_order_id" aria-label="Default select example">
                                                            <option selected>Open this select menu</option>
                                                            @foreach($orders as $order)
                                                                @if($order->ordered_for == 'course')
                                                                    <option value="{{$order->id}}">{{$order->course->title }}</option>
                                                                    <td class="custome_td">{{ $order->course->title }}</td>
                                                                @elseif($order->ordered_for == 'batch_exam')
                                                                    <option value="{{$order->id}}">{{$order->batchExam->title}}</option>
                                                                    <td class="custome_td">{{ $order->batchExam->title }}</td>
                                                                @else
                                                                    <option value="{{$order->id}}">{{$order->product->title}}</option>
                                                                    <td class="custome_td">{{ $order->product->title }}</td>
                                                                @endif

                                                            @endforeach

                                                        </select>
                                                    </div>
                                                    {{--                                <div class="col-md-4 mt-2">--}}
                                                    {{--                                    <label for="">Image <span class="text-red">(300 X 200 + WEBP)</span> </label>--}}
                                                    {{--                                    <input type="file" name="image" id="categoryImage" accept="images/*">--}}
                                                    {{--                                    <span class="text-danger" id="image"></span>--}}
                                                    {{--                                </div>--}}
                                                    {{--                                <div class="col-md-4 mt-2">--}}
                                                    {{--                                    <div>--}}
                                                    {{--                                        <img src="" id="imagePreview" style=""/>--}}
                                                    {{--                                    </div>--}}
                                                    {{--                                </div>--}}
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                {{--                        <button type="reset" class="btn btn-warning">Reset</button>--}}
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit"  class="btn btn-primary submit-btn" value="save">Save</button>
                                            </div>
                                        </form>
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


    </section>
@endsection

@push('script')
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

    <script>
        $(document).on('click','.service-status-edit-btn',function (){
            var serviceId=$(this).attr('data-service-status');

            $.ajax({
                url: base_url+"servicestatus/"+serviceId+"/edit",
                method: "GET",
                datatype: "json",
                success : function (data){
                    console.log(data)

                    $.each($('select[name = "status"] option'),function (contactIndex, contact){
                        if ($(this).val()== data.status){
                            $(this).attr('selected',true)
                        }
                    })
                    $(".select2").select2({
                        minimumResultsForSearch: "",
                        width: "100%",

                    })
                    $('#courseServiceForm').attr('action', base_url+"status_update/"+serviceId);
                    $('#blogCategoryCourseModal').modal('show');
                }
            })
        })
    </script>
@endpush
