<!doctype html>
<html lang="en" dir="ltr">
<head>

    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />

    <!-- meta info about website -->
    <meta name="description" content="Noa - Laravel Bootstrap 5 Admin & Dashboard Template">
    <meta name="author" content="BiddaBari">
    <meta name="keywords" content="Online Course">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- TITLE -->
    <title>BiddaBari - @yield('title')</title>

    @include('backend.includes.assets.css')

</head>

<body class="ltr app sidebar-mini">

<!-- Switcher-->
@include('backend.includes.right-sidebar')
<!-- Switcher-->

<!-- GLOBAL-LOADER -->
<!--<div id="global-loader">-->
<!--    <img src="{{ asset('/') }}backend/assets/images/loader.svg" class="loader-img" alt="Loader">-->
<!--</div>-->
<!-- /GLOBAL-LOADER -->

<!-- PAGE -->
<div class="page">
    <div class="page-main">

        <!-- app-Header -->
        @include('backend.includes.header')
        <!-- /app-Header -->

        <!--APP-SIDEBAR-->
        @include('backend.includes.menu')
        <!--/APP-SIDEBAR-->

        <!--app-content open-->
        <div class="app-content main-content mt-0">
            <div class="side-app">

                <!-- CONTAINER -->
                <div class="main-container container-fluid">

                    @yield('body')

                </div>
            </div>
        </div>
        <!-- CONTAINER CLOSED -->
    </div>

    <!-- FOOTER -->
    @include('backend.includes.footer')
    <!-- FOOTER CLOSED -->

</div>
<!-- page -->

<!-- BACK-TO-TOP -->
<a href="#top" id="back-to-top"><i class="fa fa-long-arrow-up"></i></a>

@include('backend.includes.assets.js')

</body>
</html>
