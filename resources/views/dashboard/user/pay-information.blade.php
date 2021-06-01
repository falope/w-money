@extends('dashboard.layout')

@section('title', 'Investnent Payment Information | Wmoney.ng ')

@section('sidemenu')
    @include('dashboard.user._partials.sidemenu')
@endsection

@section('main-header')
    @include('dashboard.user._partials.navigation')
@endsection

<?php
$user = Auth::user();
?>

@section('main-content')
    <div class="headerpb-8 pt-5 pt-md-8"
        style="background-image:url({{ asset('images/bga.jpg') }}); background-size:cover; background-repeat:no-repeat">
        <div class="container-fluid">
            <div class="header-body" style="padding-bottom: 20px">
            </div>
        </div>
    </div>
    <div class="container-fluid mt--7">

        <div class="row mt-5">
            <div class="col-md-12 mb-5 mb-xl-0">
                <div class="card shadow" style="padding:20px">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Pay Via Bank Transfer</h3>
                            </div>


                            <center>
                                <h4>Kindly pay ₦
                                    <?php echo number_format($investment->amount, 2); ?> to
                                    the following account details:</h4><br><br>

                                <p>Bank Name: <b>Zenith Bank</b></p>

                                <p>Account Name: <b>Richvest 360 Ltd - Homeflex Africa</b></p>

                                <p>Account Number: <b>1017737448</b></p>
                                <hr />

                                <p>Bank Name: <b>Sterling Bank</b></p>

                                <p>Account Name: <b>Homeflex Global</b></p>

                                <p>Account Number: <b>0081166533</b></p>

                                <br><br>

                                <p>After you pay, kindly send us an email support@homeflexglobal.com with your payment
                                    information</p>
                            </center>

                        </div>
                    </div>



                </div>
            </div>

        </div>
        <!-- Footer -->
        <footer class="footer">
            <div class="row align-items-center justify-content-xl-between">
                <div class="col-xl-6">
                    <div class="copyright text-center text-xl-left text-muted">
                        &copy; {{ date('Y') }} <a href="https://Wmoney.ng" class="font-weight-bold ml-1"
                            target="_blank">Wmoney.ng</a>
                    </div>
                </div>

            </div>
        </footer>
    </div>
@endsection
