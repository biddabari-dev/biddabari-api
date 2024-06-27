@extends('frontend.master')

@section('body')

    <div class="inner-banner inner-banner-bg10 ">
        <div class="container">
            <div class="inner-title text-center">
                <h3>Dashboard</h3>
                <ul>
                    <li>
                        <a href="{{ route('front.home') }}">Home</a>
                    </li>
                    <li>Student Dashboard</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="courses-area-two section-bg pt-100">
        <div class="container">
            <!--                <div class="section-title text-center mb-45">-->
            <!--                    <h2> সকল নোটিশ  সমূহ</h2>-->
            <!--                    <hr class="w-25 mx-auto bg-danger"/>-->
            <!--                </div>-->
            <div class="row d-flex align-items-start">
                <div class="col-lg-2 col-md-6 card">
                    <div class="billing-sildbar  card-body">
                        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <button class="nav-link " id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">My Course</button>
                            <button class="nav-link  " id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">My Profile</button>
                            <button class="nav-link active" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">My Order</button>
                            <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">My Payment</button>
                            <button class="nav-link" id="" data-bs-toggle="pill" type="button" onclick="document.getElementById('logout').submit()" role="tab" aria-controls="v-pills-settings" aria-selected="false">Logout</button>
                            <form action="{{ route('logout') }}" method="post" id="logout">@csrf</form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-10 col-md-12">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade  " id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <div class="row">
                                <div class="section-title text-center">
                                    <h2>  আমার কোর্স সমূহ</h2>
                                    <hr class="w-25 mx-auto bg-danger"/>
                                </div>
                                @if(!empty($courseOrders))
                                    @forelse($courseOrders as $courseOrder)
                                <div class="col-lg-4 col-md-6">
                                    <div class="courses-item">
                                        <a href="{{ route('front.course-details', ['slug' => $courseOrder->course->slug]) }}">
                                            <img src="{{ asset($courseOrder->course->banner) }}" alt="Courses" class="img-fluid" style="height: 230px" />
                                        </a>
                                        <div class="content">
                                            <h3><a href="{{ route('front.course-details', ['slug' => $courseOrder->course->slug]) }}">{{ $courseOrder->course->title }}</a></h3>
                                            <div class="bottom-content">
                                                <a href="{{ route('front.course-details', ['slug' => $courseOrder->course->slug]) }}" class="btn btn-warning">বিস্তারিত দেখুন</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    @empty
                                            <div class="col-lg-4 col-md-6">
                                                <div class="courses-item">
                                                    <p class="text-center">No Courses Enrolled Yet</p>
                                                </div>
                                            </div>
                                    @endforelse
                                @endif
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                            <div class="row">
                                <div class="section-title text-center">
                                    <h2>  আমার প্রোফাইল</h2>
                                    <hr class="w-25 mx-auto bg-danger"/>
                                </div>
                                <div class="col-lg-12 col-md-6">
                                    <div class="courses-item">
                                        <div class="content">
                                            <form class="form" id="contactForm" method="post" action="{{ route('front.student.profile-update') }}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row mb-20">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="name" required data-error="Username" placeholder="Username">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 ">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="mobile" required data-error="Please enter Phone " placeholder="Please Enter Phone">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-20">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <input class="form-control" type="email" name="email" placeholder="Email">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <input class="form-control" type="file" name="image" accept="image/*" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-20">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label>Gender : </label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <input class="" type="radio" name="gender"> &nbsp;&nbsp; Male &nbsp;&nbsp;&nbsp;&nbsp;
                                                            <input class="" type="radio" name="gender"> &nbsp;&nbsp; Female
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <input class="form-control" type="date" name="dob" placeholder="date of birth">
                                                        </div>
                                                    </div>
                                                </div >
                                                <div class="row mb-20">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <input class="form-control" type="text" name="school" placeholder="School ">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <input class="form-control" type="text" name="college" placeholder="Collage">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-20">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <input class="form-control" type="text" name="university" placeholder="Current Institution">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-20">
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <input class="form-control default-btn" type="submit" name="" value="Update">
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <input class="form-control btn btn-info" type="reset" name="" value="Reset">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade " id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                            <div class="row">
                                <div class="section-title text-center">
                                    <h2>  আমার অর্ডার সমূহ</h2>
                                    <hr class="w-25 mx-auto bg-danger"/>
                                </div>
                                <div class="col-lg-12 col-md-6">
                                    <div class="courses-item">
                                        <div class="content">
                                            <table class="table table-striped table-bordered table-hover">
                                                <tr>
                                                    <th>sl</th>
                                                    <th>Order No</th>
                                                    <th>Item Name</th>
                                                    <th>Price</th>
                                                    <th>Status</th>
                                                </tr>
                                                @foreach($courseOrders as $courseOrder)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>#{{ $courseOrder->order_invoice_number }}</td>
                                                        <td>{{ $courseOrder->course->title }}</td>
                                                        <td>{{ $courseOrder->course->price }}</td>
                                                        <td>
                                                            {{ $courseOrder->status == 0 ? 'Pending' : '' }}
                                                            {{ $courseOrder->status == 1 ? 'Confirmed' : '' }}
                                                            {{ $courseOrder->status == 0 ? 'Canceled' : '' }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show active" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                            <div class="row">
                                <div class="section-title text-center">
                                    <h2>  আমার পেমেন্ট সমূহ</h2>
                                    <hr class="w-25 mx-auto bg-danger"/>
                                </div>
                                <div class="col-lg-12 col-md-6">
                                    <div class="courses-item">
                                        <div class="content">
                                            <table class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>sl</th>
                                                        <th>Order No</th>
                                                        <th>Course Title</th>
                                                        <th>Total</th>
                                                        <th>Discount</th>
                                                        <th>Grand total</th>
                                                        <th>Paid</th>
                                                        <th>Due </th>
                                                        <th>Date</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($courseOrders as $courseOrder)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>#{{ $courseOrder->order_invoice_number }}</td>
                                                            <td>{{ $courseOrder->course->title }}</td>
                                                            <td>{{ $courseOrder->course->price }}</td>
                                                            <td>{{ $discount = $courseOrder->course->discount_type == 1 ? $courseOrder->course->discount_amount : ($courseOrder->course->discount_amount * $courseOrder->course->price)/100 }}</td>
                                                            <td>{{ $grandTotal = $courseOrder->course->price - $discount }}</td>
                                                            <td>{{ $courseOrder->paid_amount ?? 0 }}</td>
                                                            <td>{{ $grandTotal - $courseOrder->paid_amount }} </td>
                                                            <td>{{ $courseOrder->created_at->format('d F, Y') }}</td>
                                                            <td>
                                                                {{ $courseOrder->status == 0 ? 'Pending' : '' }}
                                                                {{ $courseOrder->status == 1 ? 'Approved' : '' }}
                                                                {{ $courseOrder->status == 2 ? 'Canceled' : '' }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
