@extends('dashboard.layout')

@section('title', 'Dashboard | Wmoney.ng')

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

                <!-- Card stats -->
                <div class="row" style="margin-bottom: 20px">
                    <div class="col-xl-3 col-lg-6">
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
                    <div class="col-xl-3 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body" style="min-height: 120px">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Total ROI</h5>
                                        <span class="h2 font-weight-bold mb-0" style="display: block;margin-top: 6px;">
                                            {{ $totalROI ?? 0 }}%</span>
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
                    <div class="col-xl-3 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body" style="min-height: 120px">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Total Referrals</h5>
                                        <span class="h2 font-weight-bold mb-0" style="display: block;margin-top: 6px;">
                                            {{ $totalReferrals }}</span>
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
                    <div class="col-xl-3 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body" style="min-height: 120px">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Total Referral Earnings</h5>
                                        <span class="h2 font-weight-bold mb-0" style="display: block;margin-top: 6px;"> ₦
                                            <?php echo number_format($totalReferralEarnings, 2); ?></span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                            <i class="fas fa-percent"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <button onclick="location.href='{{ route('partnership') }}'" style="margin-bottom: 20px"
                    class="btn-block btn-shadow btn-wide fsize-1 btn btn-primary btn-lg">
                    <span class="mr-1">Start New Partnership</span>
                </button>

            </div>
        </div>
    </div>
    <div class="container-fluid mt--7" style="margin-top: -70px !important">
        <div class="row mt-5">
            <div class="col-xl-12 mb-5 mb-xl-0">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">My Partnerships</h3>
                            </div>
                            <div class="col text-right">

                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table style="width: 100%;" class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Plan</th>
                                    <th>Units</th>
                                    <th>Amount</th>
                                    <th>ROI (%)</th>
                                    <th>ROI (₦)</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($investments) > 0)
                                    @foreach ($investments as $count => $investment)
                                        <tr>
                                            <td> {{ $count + 1 }}</td>
                                            <td> {{ $investment->plan->name }}</td>
                                            <td> {{ $investment->unit }}</td>
                                            <td> ₦<?php echo number_format($investment->amount * $investment->unit, 2); ?></td>
                                            <td> {{ $investment->roi }}%</td>
                                            <!--(amount * unit) + (amount * unit * roi/100) -->
                                            <td> ₦<?php echo number_format(($investment->amount * $investment->unit) + ($investment->amount * $investment->unit * ($investment->roi/100)), 2); ?></td>
                                            <td> <?php echo $investment->status === 'active' ? date('F j, Y',
                                                strtotime($investment->activated_on)) : ($investment->status === 'completed'
                                                ? date('F j, Y', strtotime($investment->completed_on)) : 'N/A'); ?>
                                            </td>
                                            <td> <?php echo $investment->status === 'active' ? date('F j, Y',
                                                strtotime(date('Y-m-d', strtotime('+' . $investment->duration . ' ' .
                                                $investment->duration_type . 's', strtotime($investment->activated_on))))) :
                                                ($investment->status === 'completed' ? date('F j, Y',
                                                strtotime(date('Y-m-d', strtotime('+' . $investment->duration . ' ' .
                                                $investment->duration_type . 's', strtotime($investment->completed_on))))) :
                                                'N/A'); ?>
                                            </td>
                                            <td> <?php echo $investment->status === 'active' ? 'Active' :
                                                ($investment->status === 'completed' ? 'Completed' : 'Pending'); ?>
                                            </td>
                                            <td>
                                                <?php echo $investment->status === 'created'
                                                ? "<a class='btn btn-success' href='" .
                                                            route('investment-pay-information', ['investment_id'=>
                                                    $investment->id]) .
                                                    "'> Pay ₦" .
                                                    number_format($investment->amount, 2) .
                                                    ' Now</a>'
                                                : ''; ?>
                                            </td>
                                            <td>
                                                <?php echo $investment->status === 'created'
                                                ? "<button class='btn btn-danger delete-investment'
                                                    data-investment-id='{$investment->id}'>
                                                    Delete </button>"
                                                : ''; ?> </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="10"> No available investment to show </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        {{ $investments->links() }}
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
    <form id="delete-investment-form" method="post" action="{{ route('archive-investment') }}">
        <input type="hidden" name="investment_id">
    </form>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.delete-investment').on('click', function() {
                var investmentId = $(this).attr('data-investment-id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log({
                            investmentId: investmentId
                        })
                        $('input[name="investment_id"]').val(investmentId);
                        $('#delete-investment-form').submit();
                    }
                })
            })
        })

    </script>
@endsection
