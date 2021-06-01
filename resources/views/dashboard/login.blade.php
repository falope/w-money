<!DOCTYPE html>
<html lang="en">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Wmoney.ng</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />

    <link rel="shortcut icon" href="{{ asset('images/logo.jpeg') }}">

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/colors/default.css') }}" />
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
</head>

<body class="">
    <!-- START HOME  -->
    <section class="bg-login"
        style="background-image:url('https://res.cloudinary.com/olamigoke/image/upload/v1621761712/pexels-photo-3894378_ew7cyp.jpg'); background-size:cover; min-height: 100vh; background-position: center;">
        <!-- <div class="bg-overlay"></div> -->
        <div class="login-table">
            <div class="login-table-cell">
                <div class="container">
                    <center><br>
                        <a ><img src="{{ asset('presentational/images/logo.png') }}"
                                style="height:70px; border-radius:15px; background-color: white;"></a>
                    </center>
                    <div class="row justify-content-center mt-3">
                        <div class="col-lg-4">
                            <div class="bg-white p-4 mt-3 rounded">
                                <div class="text-center">
                                    <h4 class="font-weight-bold mb-3">Login</h4>
                                </div>
                                <form class="login-form" method="POST" action="{{ route('do-login') }}">
                                    <div class="row">
                                        <div class="col-lg-12 mt-2">
                                            <input type="email" class="form-control" placeholder="Email" name="email"
                                                required>
                                        </div>
                                        <div class="col-lg-12 mt-2">
                                            <input name="password" type="password" class="form-control"
                                                placeholder="Password" required>
                                        </div>
                                        <div class="col-lg-12 mt-2">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                <label class="custom-control-label" for="customCheck1">Remember
                                                    me</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mt-3 mb-4">
                                            <button name="login" type="submit" class="btn btn-custom w-100">Sign
                                                in</button>
                                        </div>
                                        <div class="mx-auto">
                                            <p class="mb-0 mt-2"><a href="{{route('show-reset-password')}}"
                                                    class="text-dark font-weight-bold"
                                                    style="display: block; text-align: center">Forgot your password?</a>
                                            </p>
                                            <p class="mb-0 mt-2"><a href="{{ route('register') }}"
                                                    class="text-dark font-weight-bold"
                                                    style="    text-decoration: underline !important;display: block;text-align: center;">Create
                                                    New Account</a></p>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
