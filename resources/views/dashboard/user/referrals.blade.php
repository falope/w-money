@extends('dashboard.layout')

@section('title', 'My Profile | Wmoney.ng ')

@section('sidemenu')
    @include('dashboard.user._partials.sidemenu')
@endsection

@section('main-header')
    @include('dashboard.user._partials.navigation')
@endsection

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
                                <h3 class="mb-0">My Referrals | Referral Code - {{ Auth::user()->referral_code }}</h3>
                            </div>

                        </div>
                    </div>

                    <center style="padding:10px; background:#f2f2f2">
                        <p>Kindly copy and share your referral code among your contacts and friends to signup, and you get
                            <b>2.5%</b> of their first partnership.
                        </p>
                        <h4>Referral Wallet: ₦<?php echo
                            number_format(Auth::user()->referralTransaction->earnings, 2); ?></h4>
                    </center>

                    <div class="table-responsive">
                        <table style="width: 100%;" class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>

                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                @if (count(Auth::user()->referrals) > 0)
                                    @foreach (Auth::user()->referrals as $count => $referral)
                                        <tr>
                                            <td>{{ $count + 1 }}</td>
                                            <td>{{ $referral->investor->name }}</td>
                                            <td><?php echo date('F j, Y', strtotime($referral->created_at));
                                                ?></td>
                                            <td>{{ $referral->status }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4"> No record available to show </td>
                                    </tr>
                                @endif
                            </tbody>

                        </table>
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
