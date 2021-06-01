@extends('dashboard.layout')

@section('title', 'Completed Investments | Wmoney.ng ')

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
            <div class="col-xl-12 mb-5 mb-xl-0">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Completed Investments</h3>
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
                                    <th>Withdrawn Amount</th>
                                    <th>ROI</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($investments) > 0)
                                    @foreach ($investments as $count => $investment)
                                        <tr>
                                            <td> {{ $count + 1 }}</td>
                                            <td> {{ $investment->plan->name }}</td>
                                            <td> {{ $investment->unit }}</td>
                                            <td> ₦<?php echo number_format($investment->amount, 2); ?></td>
                                            <td> ₦<?php echo number_format($investment->withdraw_amount, 2);
                                                ?></td>
                                            <td> {{ $investment->roi }}%</td>
                                            <td> <?php echo date('F j, Y',
                                                strtotime($investment->activated_on)); ?> </td>
                                            <td> <?php echo date('F j, Y',
                                                strtotime($investment->completed_on)); ?> </td>
                                            <td> Completed </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8"> No available investment to show </td>
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
@endsection
