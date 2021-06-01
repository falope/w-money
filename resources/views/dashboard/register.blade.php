<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from themesbrand.com/globing/signup.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 22 Jan 2020 20:29:21 GMT -->

<head>


    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wmoney.ng | Signup</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <link rel="shortcut icon" href="logo">
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/colors/purple.css') }}" />

    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

</head>


<body class="">
</iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <!-- START HOME  -->

    <section class=" "
        style="background-image:url('https://res.cloudinary.com/olamigoke/image/upload/v1621761712/pexels-photo-3894378_ew7cyp.jpg'); background-size:cover;  min-height: 100vh; background-position: center;">
        <!-- <div class="bg-overlay"></div> -->
        <div class="login-table">
            <div class="login-table-cell">
                <div class="container">
                    <center><br>
                        <a ><img src="{{ asset('presentational/images/logo.png') }}"
                                style="height:70px; border-radius:15px; background-color: white;"></a>
                    </center>
                    <div class="row justify-content-center">
                        <div class="col-lg-4">
                            <div class="bg-white p-4 mt-3 rounded">
                                <div class="text-center">
                                    <h4 class="font-weight-bold mb-3">Register New Account</h4>
                                </div>
                                <form class="registration-form" method="POST" action="{{ route('do-register') }} ">
                                    <label class="text-muted">Full Name</label>
                                    <input name="name" type="text" id="exampleInputName1"
                                        class="form-control mb-2 registration-input-box">
                                    <label class="text-muted">Email</label>
                                    <input name="email" type="email" id="exampleInputEmail1"
                                        class="form-control mb-2 registration-input-box">
                                    <label class="text-muted">Phone</label>
                                    <input name="phone_number" type="number" id="exampleInputEmail1"
                                        class="form-control mb-2 registration-input-box">

                                    <label class="text-muted">Sex</label>
                                    <select name="sex" type="" id="exampleInputEmail1"
                                        class="form-control mb-2 registration-input-box">
                                        <option value="">--- Select ---</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>

                                    <label class="text-muted">Password</label>
                                    <input name="password" type="password" id="password1"
                                        class="form-control mb-2 registration-input-box">
                                    <label class="text-muted">Repeat Password</label>
                                    <input name="password_confirmed" type="password" id="password2"
                                        class="form-control mb-2 registration-input-box">
                                    <label class="text-muted">Referral Code</label>
                                    <input name="referral_code" type="text" id="exampleInputName1"
                                        class="form-control mb-2 registration-input-box">
                                    <button name="signup" type="submit"
                                        class="btn btn-custom w-100 mt-3 text-uppercase">Get Started</button>
                                </form>
                            </div>
                            <div class="text-center mt-3">
                                <p><small class="text-white mr-2">Already have an account ?</small> <a
                                        href="{{ route('login') }}" class="text-white font-weight-bold">Sign in</a>
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
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            toastr.options = {
                "positionClass": "toast-top-center",
            }

            @if (Session::has('error'))
                toastr.error("{{ Session::get('error') }}")
            @endif

            @if (Session::has('success'))
                toastr.success("{{ Session::get('success') }}")
            @endif

            @if (session()->get('errors'))
                toastr.error("{{ session()->get('errors')->first() }}");
            @endif
        })

    </script>
</body>

</html>
