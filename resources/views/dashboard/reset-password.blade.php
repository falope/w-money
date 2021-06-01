<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Request Password Password | Wmoney.ng</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />

    <link rel="shortcut icon" href="logo.jpeg">

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/colors/green.css') }}" />

</head>


<body>

    <!-- START HOME  -->
    <section class="bg-login"
    style="background-image:url('https://res.cloudinary.com/olamigoke/image/upload/v1621761829/pexels-photo-3869651_asqbev.jpg'); background-size:cover; min-height: 100vh; background-position: center;">
        <div class="bg-overlay"></div>
        <div class="login-table">
            <div class="login-table-cell">
                <div class="container">
                    <center style="position: relative"><br>
                        <a ><img src="{{ asset('presentational/images/logo.png') }}"
                                style="height:70px; border-radius:15px; background-color: white;"></a>

                    </center>
                    <div class="row justify-content-center mt-4">
                        <div class="col-lg-4">
                            <div class="bg-white p-4 mt-5 rounded">
                                <div class="text-center">
                                    <h4 class="font-weight-bold mb-3">Reset Password</h4>
                                </div>
                                <h6 class="text-center text-muted font-weight-normal forgot-pass-txt">Enter your email
                                    address and we'll send you an email with instructions to reset your password.</h5>
                                    <form class="login-form" method="POST" action="{{ route('reset-password') }}">
                                        <div class="row">
                                            <div class="col-lg-12 mt-3">
                                                <input name="email" type="email" class="form-control"
                                                    placeholder="Email" required="">
                                            </div>
                                            <div class="col-lg-12 mt-4 mb-2">
                                                <button name="password" type="submit" class="btn btn-custom w-100">Reset
                                                    your Password</button>
                                            </div>
                                        </div>
                                    </form>
                            </div>
                            <div class="text-center mt-3">
                                <p><small class="text-white mr-2">Don't have an account?</small> <a
                                        href="{{ route('register') }}" class="text-white font-weight-bold">Sign up</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END HOME -->



    <!-- js placed at the end of the document so the pages load faster -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

</body>

<!-- Mirrored from themesbrand.com/globing/password_forget.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 22 Jan 2020 20:29:21 GMT -->

</html>
