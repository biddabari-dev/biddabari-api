<!doctype html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    {!! isset($siteSettings->default_seo_code_on_header) ? $siteSettings->default_seo_code_on_header : '' !!}
        <link rel="stylesheet" href="{{ asset('/') }}frontend/assets/css/plugins.css">
{{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/biddabari-dev/site-assets/frontend/assets/css/plugins.css">--}}

    <link rel="icon" type="image/png" href="{{ asset('/') }}frontend/assets/images/favicon.png">
    <link rel="stylesheet" href="{{ asset('/') }}frontend/assets/news-tinker/style.min.css" />

        <link rel="stylesheet" href="{{ asset('/') }}frontend/assets/css/iconplugins.css">

{{--        <link rel="stylesheet" href="{{ asset('/') }}frontend/assets/css/style.min.css">--}}
        <link rel="stylesheet" href="/frontend/assets/css/style.css">

{{--        <link rel="stylesheet" href="{{ asset('/') }}frontend/assets/css/responsive.min.css">--}}
        <link rel="stylesheet" href="{{ asset('/') }}frontend/assets/css/responsive.css">


        <link rel="stylesheet" href="{{ asset('/') }}frontend/assets/css/theme-dark.min.css">


{{--        <link rel="stylesheet" href="{{ asset('/') }}frontend/assets/css/custom.min.css">--}}
        <link rel="stylesheet" href="{{ asset('/') }}frontend/assets/css/custom.css">

    <title>BiddaBari - The First Job Study Online Platform in Bangladesh</title>

    <!-- HELPER CSS -->
        <link href="{{ asset('/') }}backend/assets/css/helper.css" rel="stylesheet" />
{{--    <link href="https://cdn.jsdelivr.net/gh/biddabari-dev/site-assets/backend/assets/css/helper.min.css" rel="stylesheet" />--}}



        <link rel="stylesheet" href="{{ asset('/') }}frontend/assets/css/custom-my-mod.min.css">


    <!--font awesome link-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <style>

        /* ----------------messenger icon-------------------- */
        .go-messenger {
            position: fixed;
            top: 50%;
            right: 3%;
            opacity: 1;
            cursor: pointer;
            text-decoration: none;
            color: var(--whiteColor);
            font-size: 30px;
            font-weight: 700;
            text-align: center;
            background: #281367;
            border-radius: 50px;
            width: 50px;
            height: 50px;
            line-height: 35px;
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

    <style>
        .box-shadow {
            box-shadow: 1px 1px 10px 0px rgba(0,0,0,0.75);
            -webkit-box-shadow: 1px 1px 10px 0px rgba(0,0,0,0.75);
            -moz-box-shadow: 1px 1px 10px 0px rgba(0,0,0,0.75);
        }
    </style>
    <style>
        .student-panel-menu li a { color: white; font-size: 20px;}
        .student-panel-menu li:hover a { color: #85AF54!important;}
        .st-menu-active { color: #85AF54!important; }
        .content-shadow{box-shadow: 0px 0px 25px #D6D6D6;}
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



    </style>
    @stack('style')
    <!-- Meta Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '1185093055952372');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=1185093055952372&ev=PageView&noscript=1"
    /></noscript>
<!-- End Meta Pixel Code -->
</head>
<body>

@include('frontend.includes.header')


@yield('body')

@include('frontend.includes.footer')

<a href="https://m.me/1652435885033225" class="go-messenger active" target="blank">
    <div class=""><i class="fa-brands fa-facebook-messenger"></i></div>
</a>

<!-- Messenger Chat Plugin Code -->
<!--<div id="fb-root"></div>-->
<!-- Messenger Chat Plugin Code -->


<script src="{{ asset('/') }}frontend/assets/js/jquery.min.js"></script>
{{--<script src="https://cdn.jsdelivr.net/gh/biddabari-dev/site-assets/frontend/assets/js/jquery.min.js"></script>--}}

<script  src="{{ asset('/') }}frontend/assets/js/bootstrap.bundle.min.js" type="text/javascript"></script>
<script  src="{{ asset('/') }}frontend/assets/js/meanmenu.min.js" type="text/javascript"></script>
<script async src="{{ asset('/') }}frontend/assets/js/ajaxchimp.min.js" type="text/javascript"></script>
<script  src="{{ asset('/') }}frontend/assets/js/form-validator.min.js" type="text/javascript"></script>
<script async src="{{ asset('/') }}frontend/assets/js/contact-form-script.min.js" type="text/javascript"></script>
<script  src="{{ asset('/') }}frontend/assets/js/owl.carousel.min.js" type="text/javascript"></script>
<script  src="{{ asset('/') }}frontend/assets/js/magnific-popup.min.js" type="text/javascript"></script>
<script async src="{{ asset('/') }}frontend/assets/js/aos.min.js" type="text/javascript"></script>
<script  src="{{ asset('/') }}frontend/assets/js/odometer.min.js" type="text/javascript"></script>
<script src="{{ asset('/') }}frontend/assets/js/appear.min.js" type="text/javascript"></script>
<script  src="{{ asset('/') }}frontend/assets/js/tweenMax.min.js" type="text/javascript"></script>


<script  src="{{ asset('/') }}frontend/assets/js/custom.js"></script>


<script  src="{{ asset('/') }}frontend/assets/news-tinker/acmeticker.js"></script>
{{--<script async src="{{ asset('/') }}frontend/assets/news-tinker/acmeticker.min.js"></script>--}}
<script  src="{{ asset('/') }}frontend/assets/js/multi-countdown.js"></script>
{{--<script async src="{{ asset('/') }}frontend/assets/js/multi-countdown.min.js"></script>--}}


<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>


@yield('js')

{{--custom js--}}
<script  src="{{ asset('/') }}frontend/assets/js/my-custom-mod.js"></script>
{{--<script defer src="{{ asset('/') }}frontend/assets/js/my-custom-mod.min.js"></script>--}}


<!-- Toastr Css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- Sweet Alert -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet" />
<!-- Toastr JS -->
<script async src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Sweet Alert JS -->
<script async src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
@if(session()->has('success'))
    <script>
        toastr.success("{{ session()->get('success') }}");
    </script>
@endif
@if(session()->has('error'))
    <script>
        toastr.error("{{ session()->get('error') }}");
    </script>
@endif
@if(session()->has('customError'))
    <script>
        Swal.fire({
            title: 'Error!',
            text: "{{ session()->get('customError') }}",
            icon: 'error',
            confirmButtonText: 'Ok'
        })
    </script>
@endif



<script>
    let base_url = {!! json_encode(url('/')) !!}+'/';
</script>

<script>
    function addSimpleProCard(spid) {
        console.log(spid);
        var formcls = '.addSimpleCardFrom'+spid;
        var formurl = $(formcls).attr('action');
        var formurl = $(formcls).attr('action');
        // var cart= $('#cart_amount').text('sar');

        $.ajax({
            url : formurl,
            method : 'Post',
            data : $(formcls).serialize(),
            success : function(response){
                if(response.status == 'success'){
                    // console.log('success');
                    toastr.success(response.msg,'Success');
                    $('.cart_count-'+spid).html(`<a href="{{ route('front.view-cart') }}" class="default-btn ">এখনই কিনুন</a>`);
                }else{
                    toastr.error(response.msg,'Failed');
                }
            }
        });
    }
</script>

@stack('script')

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KPW4PLD');</script>
<!-- End Google Tag Manager -->

{!! isset($siteSettings) ? $siteSettings->default_seo_code_on_footer : '' !!}
</body>
</html>
