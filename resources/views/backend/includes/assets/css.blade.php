
<!-- App favicon -->
<link rel="apple-touch-icon" sizes="57x57" href="{{ asset('/') }}frontend/logo/favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="{{ asset('/') }}frontend/logo/favicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="{{ asset('/') }}frontend/logo/favicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('/') }}frontend/logo/favicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="{{ asset('/') }}frontend/logo/favicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="{{ asset('/') }}frontend/logo/favicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="{{ asset('/') }}frontend/logo/favicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="{{ asset('/') }}frontend/logo/favicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/') }}frontend/logo/favicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('/') }}frontend/logo/favicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/') }}frontend/logo/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('/') }}frontend/logo/favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/') }}frontend/logo/favicon/favicon-16x16.png">

<!-- BOOTSTRAP CSS -->
<link id="style" href="{{ asset('/') }}backend/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
{{--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">--}}
{{--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">--}}
{{--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">--}}

<!-- HELPER CSS -->
<link href="{{ asset('/') }}backend/assets/css/helper.css" rel="stylesheet" />

<!-- STYLE CSS -->
<link href="/backend/assets/css/style.css" rel="stylesheet" /> {{--have to check later to reduce load time--}}
<link href="{{ asset('/') }}backend/assets/css/skin-modes.css" rel="stylesheet" />

<!--- FONT-ICONS CSS -->
<link href="/backend/assets/plugins/icons/icons.css" rel="stylesheet" />

<!-- INTERNAL Switcher css -->
<link href="{{ asset('/') }}backend/assets/switcher/css/switcher.css" rel="stylesheet">
<link href="{{ asset('/') }}backend/assets/switcher/demo.css" rel="stylesheet">

<!-- custom added css files -->
<!-- Toastr Css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- Sweet Alert -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet" />

{{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" integrity="sha512-2L0dEjIN/DAmTV5puHriEIuQU/IL3CoPm/4eyZp3bM8dnaXri6lK8u6DC5L96b+YSs9f3Le81dDRZUSYeX4QcQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />--}}

<style>
    .img-16 {
        height: 16px;
        width: 16px;
    }

    thead tr th {
        text-transform:capitalize!important;
    }
    .card-header {
        padding: 0.8rem 1.6rem!important;
    }
    .select2-div .select2 {
        width: 100%!important;
    }
    td .badge:hover {
        background-color: #8fbd56!important;
        color: white;
    }
    form label {margin-bottom: 0!important;}

    #file-datatable_wrapper .dt-buttons{
        position: absolute !important;
        top: 0px !important;
        left: 136px !important;
    }
    .change-status { background-color: #8fbd56}
</style>
@stack('style')
