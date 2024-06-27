@extends('frontend.master')

@section('body')
    {{\Illuminate\Support\Facades\Session::put('course_redirect_url',\Illuminate\Support\Facades\Request::url())}}
    <div class="contact-info-area pt-100 pb-70">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4  col-12 col-sm-8">
                    <div class="contact-info-card">
                        <i class="ri-map-pin-fill"></i>
                        <h3>Our location </h3>
                        <p>4th-5th Floor, Jashore Malik Shamiti Vobon, </p>
                        <p>Gausul Azam Super Market, Nilkhat, Dhaka</p>

                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="contact-info-card">
                        <i class="ri-mail-fill"></i>
                        <h3>Email us</h3>
                        <p><a href="mailto:info@biddabari.com">info@biddabari.com</a></p>
                        <p><a href="mailto:support@biddabari.com">support@biddabari.com</a></p>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="contact-info-card">
                        <i class="ri-phone-fill"></i>
                        <h3>Phone</h3>
                        <p><a href="tel:+44587154756">+8801896060809</a></p>
                        <p><a href="tel:+44587154756">+8801896060809</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="contact-widget-area pb-70">
        <div class="container">
            <div class="section-title text-center mb-45">
                <span>SEND MESSAGE</span>
                <h2>Ready to get started?</h2>
            </div>
            <div class="contact-form">
                <form id="" method="post" action="{{ route('front.contact') }}" novalidate="true">
                    @csrf
                    <input type="hidden" name="type" value="page" />
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="text" name="name" id="name" class="form-control" value="{{ auth()->check() ? auth()->user()->name : '' }}" required="" data-error="Please Enter Your Name" placeholder="Name">
                                <div class="help-block with-errors"></div>
                                <span class="text-danger">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="email" name="email" id="email" class="form-control" value="{{ auth()->check() ? auth()->user()->email : '' }}" required="" data-error="Please Enter Your Email" placeholder="Email">
                                <div class="help-block with-errors"></div>
                                <span class="text-danger">{{ $errors->has('email') ? $errors->first('email') : '' }}</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="text" name="mobile" id="mobile" required="" value="{{ auth()->check() ? auth()->user()->mobile : '' }}" data-error="Please Enter Your number" class="form-control" placeholder="Phone Number">
                                <div class="help-block with-errors"></div>
                                <span class="text-danger">{{ $errors->has('mobile') ? $errors->first('mobile') : '' }}</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="text" name="subject" id="subject" class="form-control" required="" data-error="Please Enter Your Subject" placeholder="Your Subject">
                                <div class="help-block with-errors"></div>
                                <span class="text-danger">{{ $errors->has('subject') ? $errors->first('subject') : '' }}</span>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <textarea name="message" class="form-control" id="message" cols="30" rows="7" required="" data-error="Write your message" placeholder="Your Message"></textarea>
                                <div class="help-block with-errors"></div>
                                <span class="text-danger">{{ $errors->has('message') ? $errors->first('message') : '' }}</span>
                            </div>
                        </div>
                        <div class="col-lg-12 d-none">
                            <div class="agree-label">
                                <input type="checkbox" id="chb1" checked>
                                <label for="chb1">
                                    Accept <a href="terms-condition.html">Terms &amp; Conditions</a> And <a href="privacy-policy.html">Privacy Policy.</a>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <button type="submit" class="default-btn disabled" style="pointer-events: all; cursor: pointer;">
                                Send Message
                            </button>
                            <div id="msgSubmit" class="h3 text-center hidden"></div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="contact-map-area pb-100">
        <div class="container">
            <div class="contact-map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1167.15706166152!2d90.38668415192043!3d23.734273402888864!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b8bc89540001%3A0x11b747dd95876c8e!2sBiddabari!5e0!3m2!1sen!2sbd!4v1691004163179!5m2!1sen!2sbd" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
{{--                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3152.972641599872!2d-122.40869708532713!3d37.790680919018435!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8085808bfb7cb35b%3A0x9b649f6a7d9c50e8!2s560%20Bush%20St%20%235%2C%20San%20Francisco%2C%20CA%2094108%2C%20USA!5e0!3m2!1sen!2sbd!4v1641381557316!5m2!1sen!2sbd"></iframe>--}}
            </div>
        </div>
    </div>

@endsection

@push('style')
    <style>
        .contact-info-card::before{
            background: #F18345 !important;
        }
        .contact-info-card i{
            background: #F18345 !important;
        }
        .contact-info-card:hover i {
            background-color: #fff !important;
            color: #F18345 !important;
        }
        .contact-info-card:hover p {
            color: #fff;
        }
        .contact-info-card p{
            font-size: 18px;
            color: #000;
        }
        .contact-info-card p a{
            font-size: 20px;
            color: #000;
        }
        .form-control::placeholder{
            font-size: 20px;
        }
        .contact-form .form-group .form-control{
            font-size: 20px;
        }
    </style>
@endpush
