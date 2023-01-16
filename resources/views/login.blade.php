<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from codervent.com/dashtremev3/authentication-signin.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 29 Jul 2020 09:41:31 GMT -->

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <base href="{{asset('')}}" />
    <title>Login</title>
    <!-- loader-->
    <link href="assets/css/pace.min.css" rel="stylesheet" />
    <!--favicon-->
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    <!-- Bootstrap core CSS-->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <!-- animate CSS-->
    <link href="assets/css/animate.css" rel="stylesheet" type="text/css" />
    <!-- Icons CSS-->
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
    <!-- Custom Style-->
    <link href="assets/css/app-style.css" rel="stylesheet" />

</head>

<body class="bg-theme bg-theme11">


    <!-- Start wrapper-->
    <div id="wrapper">

        <div class="height-100v d-flex align-items-center justify-content-center">

            <div class="card card-authentication1 mb-0">
                <div class="card-body">
                    <div class="card-content p-2">
                        <div class="text-center">
                            <img src="assets/images/logo-icon.png" alt="logo icon">
                        </div>
                        <div class="card-title text-uppercase text-center py-3">Đăng Nhập</div>
                        @include('sweetalert::alert')
                        <form action="{{url('/admin')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputUsername" class="sr-only">Email</label>
                                <div class="position-relative has-icon-right">
                                    <input type="email" id="exampleInputUsername" class="form-control input-shadow" placeholder="Nhập Email" required name="email">
                                    <div class="form-control-position">
                                        <i class="icon-envelope"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword" class="sr-only">Mật khẩu</label>
                                <div class="position-relative has-icon-right">
                                    <input type="password" id="exampleInputPassword" class="form-control input-shadow" placeholder="Nhập Password" required name="password">
                                    <div class="form-control-position">
                                        <i class="icon-lock"></i>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-light btn-block">Đăng nhập</button>


                        </form>
                    </div>
                </div>

            </div>
        </div>

        <!--Start Back To Top Button-->
        <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
        <!--End Back To Top Button-->

        <!--start color switcher-->

        <!--end color switcher-->

    </div>
    <!--wrapper-->

    <!-- Bootstrap core JavaScript-->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Metismenu js -->
    <script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>

    <!-- Custom scripts -->
    <script src="assets/js/app-script.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

<!-- Mirrored from codervent.com/dashtremev3/authentication-signin.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 29 Jul 2020 09:41:31 GMT -->

</html>