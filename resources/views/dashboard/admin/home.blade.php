@extends('dashboard.layout')

@section('title', 'Dashboard | Wmoney.ng')

@section('sidemenu')
    @include('dashboard.admin._partials.sidemenu')
@endsection

@section('main-header')
    @include('dashboard.admin._partials.navigation')
@endsection

@section('main-content')
    <div class="headerpb-8 pt-5 pt-md-8"
        style="background-image:url({{ asset('images/bga.jpg') }}); background-size:cover; background-repeat:no-repeat">
        <div class="container-fluid">
            <div class="header-body" style="padding-bottom: 20px">

                <!-- Card stats -->
                <div class="row" style="margin-bottom: 20px">
                    <div class="col-xl-4 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body" style="min-height: 120px">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Total Partnerships</h5>
                                        <span class="h2 font-weight-bold mb-0" style="display: block;margin-top: 6px;"> ₦
                                            <?php echo number_format($totalPartnerships, 2); ?></span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                            <i class="fas fa-chart-bar"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body" style="min-height: 120px">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Total Payout</h5>
                                        <span class="h2 font-weight-bold mb-0" style="display: block;margin-top: 6px;"> ₦
                                            <?php echo number_format($totalPayout, 2); ?></span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                            <i class="fas fa-chart-pie"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body" style="min-height: 120px">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Total Users</h5>
                                        <span class="h2 font-weight-bold mb-0" style="display: block;margin-top: 6px;">
                                            {{ $totalUsers ?? 0 }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                            <i class="fas fa-users"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
