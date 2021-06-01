<!--

=========================================================
* Argon Dashboard - v1.1.1
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard
* Copyright 2019 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://github.com/creativetimofficial/argon-dashboard/blob/master/LICENSE.md)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <meta name="title" content="Homeflex Global | a proptech rostrum for real estate investors">
    <meta name="description" content="HomeFlex Global is a property technology investment company launched March 2020; with the sole aim of redefining the future of real estate, by providing lasting solution to global housing deficiency.">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://homeflexglobal.com/">
    <meta property="og:title" content="Homeflex Global | a proptech rostrum for real estate investors">
    <meta property="og:description" content="HomeFlex Global is a property technology investment company launched March 2020; with the sole aim of redefining the future of real estate, by providing lasting solution to global housing deficiency.">
    <meta property="og:image" content="{{ asset('presentational/images/logo.png') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://homeflexglobal.com/">
    <meta property="twitter:title" content="Homeflex Global | a proptech rostrum for real estate investors">
    <meta property="twitter:description" content="HomeFlex Global is a property technology investment company launched March 2020; with the sole aim of redefining the future of real estate, by providing lasting solution to global housing deficiency.">
    <meta property="twitter:image" content="{{ asset('presentational/images/logo.png') }}">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('presentational/images/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('presentational/images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('presentational/images/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('presentational/images/favicon/site.webmanifest') }}">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Icons -->
    <link href="{{ asset('js/plugins/nucleo/css/nucleo.css') }}" rel="stylesheet" />
    <link href="{{ asset('js/plugins/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
    <!-- CSS Files -->
    <link href="{{ asset('css/argon-dashboard.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    <style type="text/css">
        .pagination {
            margin-bottom: 0;
            padding: 10px;
        }

        .card .table td,
        .card .table th {
            line-height: 44px;
        }

    </style>
</head>

<body class="">
    <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
        <div class="container-fluid">
            <!-- Brand -->
            <a class="  pt-0" >
                <center>
                    <img src="{{ asset('presentational/images/logo.png') }}" class=" " alt="..." style="height:50px; width: 200px">
                </center>
            </a>
            <!-- User -->

            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main"
                aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Collapse header -->
                <div class="navbar-collapse-header d-md-none">
                    <div class="row">
                        <div class="col-6 collapse-brand">
                            <a class="   " >
                                <center>
                                    <img src="{{ asset('presentational/images/logo.png') }}" class=" " alt="..." style="height:50px; width: 200px">
                                </center>
                            </a>
                        </div>

                        <div class="col-6 collapse-close">
                            <button type="button" class="navbar-toggler" data-toggle="collapse"
                                data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false"
                                aria-label="Toggle sidenav">
                                <span></span>
                                <span></span>
                            </button>
                        </div>

                    </div>
                </div>
                <!-- Form -->

                <!-- Navigation -->
                <ul class="navbar-nav">
                    @yield('sidemenu')
                </ul>
            </div>
        </div>
    </nav>
    <div class="main-content">
        <!-- Navbar -->
        @yield('main-header')

        @yield('main-content')
    </div>
    <!--   Core   -->
    <script src="{{ asset('js/plugins/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!--   Optional JS   -->
    <script src="{{ asset('js/plugins/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('js/plugins/chart.js/dist/Chart.extension.js') }}"></script>
    <!--   Argon JS   -->
    <script src="{{ asset('js/argon-dashboard.min.js') }}"></script>
    <script src="https://cdn.trackjs.com/agent/v3/latest/t.js">
    </script>
    <script>
        window.TrackJS &&
            TrackJS.install({
                token: "ee6fab19c5a04ac1a32a645abde4613a",
                application: "argon-dashboard-free"
            });

    </script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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
    @yield('script')
</body>

</html>
