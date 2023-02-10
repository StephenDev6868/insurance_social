<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from codervent.com/dashtremev3/dashboard-eCommerce-v2.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 29 Jul 2020 09:40:27 GMT -->

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard</title>
    <base href="{{asset('')}}" />
    <!-- loader-->
    <link href="assets/css/pace.min.css" rel="stylesheet" />
    <!--favicon-->
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    <!-- Vector CSS -->
    <link href="assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
    <!-- simplebar CSS-->
    <link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <!-- Apex chart CSS-->
    <link href="assets/plugins/apexcharts/apexcharts.css" rel="stylesheet" />
    <!-- Bootstrap core CSS-->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <!-- animate CSS-->
    <link href="assets/css/animate.css" rel="stylesheet" type="text/css" />
    <!-- Icons CSS-->
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
    <!-- Metismenu CSS-->
    <link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <!-- Custom Style-->
    <link href="assets/css/app-style.css" rel="stylesheet" />

</head>

<body class="bg-theme bg-theme11">

    <!-- Start wrapper-->
    <div id="wrapper">

        <!--Start sidebar-wrapper-->
        @include('layouts.sidebar')
        <!--End sidebar-wrapper-->
        
        <!--Start topbar header-->
        @include('layouts.header')
        <!--End topbar header-->

        <div class="clearfix"></div>

        @yield('content')
        <!--End content-wrapper-->
        <!--Start Back To Top Button-->
        <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
        <!--End Back To Top Button-->

        <!--Start footer-->
        
        <!--End footer-->

        <!--start color switcher-->
        
        <!--end color switcher-->

    </div>
    <!--End wrapper-->


    <!-- Bootstrap core JavaScript-->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- simplebar js -->
    <script src="assets/plugins/simplebar/js/simplebar.js"></script>
    <!-- Metismenu js -->
    <script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>

    <!-- Custom scripts -->
    <script src="assets/js/app-script.js"></script>

    <!-- Vector map JavaScript -->
    <script src="assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- Apex chart -->
    <script src="assets/plugins/apexcharts/apexcharts.js"></script>
    <!-- Chart js -->
    <script src="assets/plugins/Chart.js/Chart.min.js"></script>
    <script src="assets/plugins/Chart.js/Chart.extension.js"></script>

</body>

<!-- Mirrored from codervent.com/dashtremev3/dashboard-eCommerce-v2.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 29 Jul 2020 09:40:31 GMT -->

</html>