<!doctype html>
<html lang="en">

<head>

<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {!! isset($siteSettings) ? $siteSettings->default_seo_code_on_header : '' !!}
    <link rel="stylesheet" href="{{ asset('/') }}frontend/assets/css/plugins.css">

    <link rel="stylesheet" href="/frontend/assets/css/iconplugins.css">

    <link rel="stylesheet" href="/frontend/assets/css/style.css">

    <link rel="stylesheet" href="{{ asset('/') }}frontend/assets/css/responsive.css">

    <link rel="stylesheet" href="{{ asset('/') }}frontend/assets/css/theme-dark.css">

    <link rel="stylesheet" href="{{ asset('/') }}frontend/assets/css/custom.css">
    <title>BiddaBari - The First Job Study Online Platform in Bangladesh</title>

    <!-- HELPER CSS -->
    <link href="{{ asset('/') }}backend/assets/css/helper.css" rel="stylesheet" />

    <link rel="icon" type="image/png" href="{{ asset('/') }}frontend/assets/images/favicon.png">
    <link rel="stylesheet" href="{{ asset('/') }}frontend/assets/news-tinker/style.css">
    <link rel="stylesheet" href="{{ asset('/') }}frontend/assets/css/custom-my-mod.css">
    {{--
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/gh/mirazmac/bengali-webfont-cdn@master/solaimanlipi/style.css">--}}
    {{--
    <link href="https://fonts.cdnfonts.com/css/siyam-rupali" rel="stylesheet">--}}

    <style>
        /*body {*/
        /*    font-family: 'SolaimanLipi', serif;*/
        /*}*/
        /*body {*/
        /*    font-family: 'Siyam Rupali', sans-serif;*/
        /*}*/

        .img-16 {
            height: 16px;
            width: 16px;
        }

        .box-shadow {
            box-shadow: 1px 1px 10px 0px rgba(0, 0, 0, 0.75);
            -webkit-box-shadow: 1px 1px 10px 0px rgba(0, 0, 0, 0.75);
            -moz-box-shadow: 1px 1px 10px 0px rgba(0, 0, 0, 0.75);
        }
    </style>
    <style>
        .student-panel-menu li a {
            color: white;
            font-size: 20px;
        }

        .student-panel-menu li:hover a {
            color: #85AF54 !important;
        }

        .st-menu-active {
            color: #85AF54 !important;
        }

        .content-shadow {
            box-shadow: 0px 0px 25px #D6D6D6;
        }
    </style>
    <style>
        /* width */
        ::-webkit-scrollbar {
            width: 5px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #F18345;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: black;
        }

          /* ------------------------------------ */
        .go-messenger {
            position: fixed;
            top: 50%;
            left: 3%;
            opacity: 1;
            cursor: pointer;
            text-decoration: none;
            color: var(--whiteColor);
            font-size: 40px;
            font-weight: 700;
            text-align: center;
            background: #281367;
            border-radius: 50px;
            width: 60px;
            height: 60px;
            line-height: 43px;
            z-index: 100;
            -webkit-transition: .5s;
            transition: .5s;
            padding-top: 6px;
        }

        .go-messenger i {
            -webkit-transition: .5s;
            transition: .5s;
            vertical-align: middle
        }

        .go-messenger:hover {
            background-color: var(--titleColor)
        }

        /*.go-messenger:hover i {*/
        /*    -webkit-transform: translateY(-5px);*/
        /*    transform: translateY(-5px)*/
        /*}*/

        .go-messenger.active {
            top: 95%;
            -webkit-transform: translateY(-95%);
            transform: translateY(-95%);
            opacity: 1;
            visibility: visible
        }

        /* ------------------------------------------- */
    </style>
    @stack('style')
</head>

<body>

<!--<div id="preloader">-->
<!-- <div id="preloader-area">-->
<!--  <div class="spinner"></div>-->
<!--  <div class="spinner"></div>-->
<!--  <div class="spinner"></div>-->
<!--  <div class="spinner"></div>-->
<!--  <div class="spinner"></div>-->
<!--  <div class="spinner"></div>-->
<!--  <div class="spinner"></div>-->
<!--  <div class="spinner"></div>-->
<!-- </div>-->
<!-- <div class="preloader-section preloader-left"></div>-->
<!-- <div class="preloader-section preloader-right"></div>-->
<!--</div>-->


@include('frontend.includes.header')


<section class="">
    <div class=" ps-0">
        <div class="container-fluid">
            <div class="row custom_col_res">
                <div class="col-md-2 pe-0 stu_btn">
                    <!-- <div class="bg-dark pt-5 mobile_res" style="min-height: 450px; height: 100%"> -->
                    <div class="bg-dark pt-5 mobile_res" style="">
                        <ul class="nav flex-column student-panel-menu">
                            <li class="nav-item border-1">
                                <a class="nav-link {{ request()->is('student/dashboard') ? 'st-menu-active' : '' }}"
                                   href="{{ route('front.student.dashboard') }}">My Dashboard</a>
                            </li>
                            <li class="nav-item border-1">
                                <a class="nav-link {{ request()->is('student/my-courses') ? 'st-menu-active' : '' }}"
                                   href="{{ route('front.student.my-courses') }}">My Courses</a>
                            </li>
                            <li class="nav-item border-1">
                                <a class="nav-link {{ request()->is('student/my-exams') ? 'st-menu-active' : '' }}"
                                   href="{{ route('front.student.my-exams') }}">My Exams Courses</a>
                            </li>
                            <li class="nav-item border-1">
                                <a class="nav-link {{ request()->is('student/my-orders') ? 'st-menu-active' : '' }}"
                                   href="{{ route('front.student.my-orders') }}">My Orders</a>
                            </li>
                            <li class="nav-item border-1">
                                <a class="nav-link {{ request()->is('student/view-profile') ? 'st-menu-active' : '' }}"
                                   href="{{ route('front.student.view-profile') }}">My Profile</a>
                            </li>
                            <li class="nav-item border-1">
                                <a class="nav-link" href="{{ route('front.student.my-affiliation') }}">My
                                    Affiliation</a>
                            </li>
                            <li class="nav-item border-1">
                                <a class="nav-link" href="{{ route('front.student.change-password') }}">Change
                                    Password</a>
                            </li>
                             @can('Service')
                                <li class="nav-item border-1">
                                    <a class="nav-link" href="{{ route('front.student.my_service') }}">Service</a>
                                </li>
                            @endcan
                            <li class="nav-item border-1">
                                <a class="nav-link" href="#"
                                   onclick="event.preventDefault();document.getElementById('logout').submit()">Logout</a>
                                <form action="{{ route('logout') }}" method="post" id="logout">@csrf</form>
                            </li>
                        </ul>
                    </div>


                    <button class="btn btn-warning mobile_res_btn" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                        My Dashboard
                    </button>

                    <div class="offcanvas offcanvas-start offcanvas_top_bottom" tabindex="-1" id="offcanvasExample"
                         aria-labelledby="offcanvasExampleLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasExampleLabel">My Dashboard</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <div class="col-md-2 pe-0">
                                <div class="bg-dark ">
                                    <ul class="nav flex-column student-panel-menu">
                                        <li class="nav-item border-1">
                                            <a class="nav-link {{ request()->is('student/dashboard') ? 'st-menu-active' : '' }}"
                                               href="{{ route('front.student.dashboard') }}">My Dashboard</a>
                                        </li>
                                        <li class="nav-item border-1">
                                            <a class="nav-link {{ request()->is('student/my-courses') ? 'st-menu-active' : '' }}"
                                               href="{{ route('front.student.my-courses') }}">My Courses</a>
                                        </li>
                                        <li class="nav-item border-1">
                                            <a class="nav-link {{ request()->is('student/my-exams') ? 'st-menu-active' : '' }}"
                                               href="{{ route('front.student.my-exams') }}">My Exams Courses</a>
                                        </li>
                                        <li class="nav-item border-1">
                                            <a class="nav-link {{ request()->is('student/my-orders') ? 'st-menu-active' : '' }}"
                                               href="{{ route('front.student.my-orders') }}">My Orders</a>
                                        </li>
                                        <li class="nav-item border-1">
                                            <a class="nav-link {{ request()->is('student/view-profile') ? 'st-menu-active' : '' }}"
                                               href="{{ route('front.student.view-profile') }}">My Profile</a>
                                        </li>
                                        <li class="nav-item border-1">
                                            <a class="nav-link"
                                               href="{{ route('front.student.my-affiliation') }}">My
                                                Affiliation</a>
                                        </li>
                                        <li class="nav-item border-1">
                                            <a class="nav-link"
                                               href="{{ route('front.student.change-password') }}">Change
                                                Password</a>
                                        </li>
                                        @can('Service')
                                            <li class="nav-item border-1">
                                                <a class="nav-link" href="{{ route('front.student.my_service') }}">Service</a>
                                            </li>
                                        @endcan



                                        <li class="nav-item border-1">
                                            <a class="nav-link" href="#"
                                               onclick="event.preventDefault();document.getElementById('logout').submit()">Logout</a>
                                            <form action="{{ route('logout') }}" method="post" id="logout">@csrf
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-10">
                    @yield('student-body')
                </div>
            </div>
        </div>
    </div>
</section>

@include('frontend.includes.footer')

<a href="https://m.me/1652435885033225" target="blank">
<div class="go-messenger active"><i class="fa-brands fa-facebook-messenger"></i></div></a>

<script src="{{ asset('/') }}frontend/assets/js/jquery.min.js"></script>

    <!--<script src="{{ asset('/') }}frontend/assets/js/plugins.js"></script>-->

    <script src="{{ asset('/') }}frontend/assets/js/bootstrap.bundle.min.js" type="text/javascript"></script>
    <script src="{{ asset('/') }}frontend/assets/js/meanmenu.min.js" type="text/javascript"></script>
    <script src="{{ asset('/') }}frontend/assets/js/ajaxchimp.min.js" type="text/javascript"></script>
    <script src="{{ asset('/') }}frontend/assets/js/form-validator.min.js" type="text/javascript"></script>
    <script src="{{ asset('/') }}frontend/assets/js/contact-form-script.js" type="text/javascript"></script>
    <script src="{{ asset('/') }}frontend/assets/js/owl.carousel.min.js" type="text/javascript"></script>
    <script src="{{ asset('/') }}frontend/assets/js/magnific-popup.min.js" type="text/javascript"></script>
    <script src="{{ asset('/') }}frontend/assets/js/aos.js" type="text/javascript"></script>
    <script src="{{ asset('/') }}frontend/assets/js/odometer.min.js" type="text/javascript"></script>
    <script src="{{ asset('/') }}frontend/assets/js/appear.min.js" type="text/javascript"></script>
    <script src="{{ asset('/') }}frontend/assets/js/tweenMax.min.js" type="text/javascript"></script>



    <script src="{{ asset('/') }}frontend/assets/js/custom.js"></script>


    <script src="{{ asset('/') }}frontend/assets/news-tinker/acmeticker.js"></script>
    <script src="{{ asset('/') }}frontend/assets/js/multi-countdown.js"></script>



@yield('js')

{{--custom js--}}
<script src="{{ asset('/') }}frontend/assets/js/my-custom-mod.min.js"></script>
{{--<script src="https://cdn.jsdelivr.net/gh/biddabari-dev/site-assets/frontend/assets/js/my-custom-mod.min.js"></script>--}}


<!-- Toastr Css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
      integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- Sweet Alert -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet" />
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Sweet Alert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
@if(Session::has('success'))
    <script>
        toastr.success("{{ Session::get('success') }}");
    </script>
@endif
@if(Session::has('error'))
    <script>
        toastr.error("{{ Session::get('error') }}");
    </script>
@endif
@if(Session::has('customError'))
    <script>
        Swal.fire({
            title: 'Error!',
            text: "{{ Session::get('customError') }}",
            icon: 'error',
            confirmButtonText: 'Ok'
        })
    </script>
@endif
<script>
    let base_url = {!! json_encode(url('/')) !!}+'/';
</script>

{{--fb messenger integrate starts--}}
<!-- Messenger Chat Plugin Code -->
<!--<div id="fb-root"></div>-->

<!-- Your Chat Plugin code -->
<!--<div id="fb-customer-chat" class="fb-customerchat">-->
<!--</div>-->

<!--<script>-->
<!--    var chatbox = document.getElementById('fb-customer-chat');-->
<!--    chatbox.setAttribute("page_id", "1652435885033225");-->
<!--    chatbox.setAttribute("attribution", "biz_inbox");-->
<!--</script>-->

<!-- Your SDK code -->
<!--<script>-->
<!--    window.fbAsyncInit = function() {-->
<!--        FB.init({-->
<!--            xfbml            : true,-->
<!--            version          : 'v18.0'-->
<!--        });-->
<!--    };-->

<!--    (function(d, s, id) {-->
<!--        var js, fjs = d.getElementsByTagName(s)[0];-->
<!--        if (d.getElementById(id)) return;-->
<!--        js = d.createElement(s); js.id = id;-->
<!--        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';-->
<!--        fjs.parentNode.insertBefore(js, fjs);-->
<!--    }(document, 'script', 'facebook-jssdk'));-->
<!--</script>-->
{{--fb messenger integrate ends--}}






@stack('script')
{!! isset($siteSettings) ? $siteSettings->default_seo_code_on_footer : '' !!}
</body>

</html>
