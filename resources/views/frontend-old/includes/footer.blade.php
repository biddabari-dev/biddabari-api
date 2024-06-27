<footer class="footer-area pt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="footer-widget">
                    <div class="footer-logo">
                        <a href="{{ route('front.home') }}">
                            <img src="{{ asset('/') }}frontend/assets/images/logos/logo-2.png" alt="Images">
                        </a>
                    </div>
                    <p>
                        "Biddabari" is such a different and unique online platform where you can rely yourself. You just keep your faith on Biddabari, believe it, it will do the rest.
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-m-6">
                <div class="footer-widget ps-5">
                    <h3>About us</h3>
                    <ul class="footer-list">
                        <li>
                            <a href="{{ route('front.about-us') }}">
                                About Us
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('front.instructors') }}">
                                Instructors
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                Our Event
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('front.contact-us') }}">
                                Contact Us
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-m-6">
                <div class="footer-widget ps-5">
                    <h3>Resources</h3>
                    <ul class="footer-list">
                        <li>
                            <a href="{{ route('front.all-courses') }}">
                                Courses
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('front.all-blogs') }}">
                                Our Blog
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('front.terms-conditions') }}">
                                Terms & conditions
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('front.privacy-policy') }}">
                                Privacy Policy
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="footer-widget ps-5">
                    <h3>Official Info</h3>
                    <ul class="footer-contact">
                        <li>
                            <i class="ri-map-pin-2-fill"></i>
                            <div class="content">
                                <h4>Location:</h4>
                                <span>
         4th-5th Floor, Jashore Malik Shamiti Vobon, Gausul Azam Super Market, Nilkhat, Kataban Rd 1205 Dhaka, Dhaka Division, Bangladesh
        </span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-area">
        <div class="container">
            <div class="copy-right-text text-center">
                <p class="mb-0">
                    Copyright @ <script>document.write(new Date().getFullYear())</script> <b>BiddaBari</b> All Rights Reserved
                    <a href="https://biddabari.com" target="_blank">BiddaBari</a>
                </p>
            </div>
        </div>
    </div>
</footer>


<div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Login</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="authModalForm">
                    @csrf
                    <div class="auth-div">
                        <div class="row mobile-div" data-order="0" data-active="1">
                            <label for="" class="col-md-4">Mobile</label>
                            <div class="col-md-8">
                                <input type="text" name="mobile" class="form-control" placeholder="Mobile Number" />
                                <span class="text-danger" id="name"></span>
                            </div>
                        </div>
                        <div class="row otp-div d-none" data-order="1" >
                            <label for="" class="col-md-4">Enter OTP</label>
                            <div class="col-md-8">
                                <input type="number" id="otpInput" class="form-control" placeholder="Enter OTP" />
                            </div>
                        </div>
                        <div class="row name-div mt-3 d-none" data-order="2">
                            <label for="" class="col-md-4">Name</label>
                            <div class="col-md-8">
                                <input type="text" name="name" class="form-control" placeholder="Name" />
                            </div>
                        </div>
                        <div class="row password-div mt-3 d-none" data-order="3">
                            <label for="" class="col-md-4">Password</label>
                            <div class="col-md-8">
                                <input type="password" name="password" class="form-control" placeholder="Password" />
                                <span class="text-danger" id="password"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary prev d-none">Previous</button>
                <button type="button" class="btn btn-primary next">Next</button>
            </div>
        </div>
    </div>
</div>
