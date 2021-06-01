@extends('dashboard.layout')

@section('title', 'Active Investments | Wmoney.ng ')

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
                            @if(isset($_GET['search_investment']))
                                    <?php $planQ = $_GET['search_investment'] ?>
                                    @if($planQ != 'all')
                                        <a href="{{ route('download-completed-investment-csv', ['type' => $planQ ]) }}"
                                    class="float-right btn btn-sm btn-success text-white"> Download {{ $planQ }} Records CSV </a>
                                    @else
                                        <a href="{{ route('download-completed-investment-csv', ['type' => 'all' ]) }}"
                                    class="float-right btn btn-sm btn-success text-white"> Download All Records CSV </a>
                                    @endif
                            @else
                                <a href="{{ route('download-completed-investment-csv', ['type' => 'all' ]) }}"
                                class="float-right btn btn-sm btn-success text-white"> Download All Records CSV </a>
                            @endif
                            
                            </div>
                        </div>
                    </div>
                    <hr style="margin: 0">
                    <div class="row" style="margin: 0; margin-bottom: 20px; margin-top: 20px">
                        <div class="col-6">
                            <form method="GET">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Search by Investor's Information</label>
                                    <input name="search_user" type="text" class="form-control"
                                        value="<?php echo $_GET['search_user'] ?? ''; ?>"
                                        placeholder="Search for name, phone number, email, bank name, bank account number">
                                </div>
                                <button type="submit" class="btn btn-primary"
                                    style="padding:10px; width:100%">Search</button>
                            </form>
                        </div>
                        <div class="col-6" style="padding:0 10px">
                            <form method="GET" action="">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Select Investment Type</label>
                                    <select name="search_investment" class="form-control"
                                        value="<?php echo $_GET['search_investment'] ?? ''; ?>">
                                        <option <?php echo isset($_GET['search_investment']) &&
                                            $_GET['search_investment']==='all' ? 'selected' : '' ; ?>
                                            value="all">Select Investment Type</option>
                                        <option value="all">All</option>
                                        @foreach ($plans as $plan)
                                            <option <?php echo isset($_GET['search_investment']) &&
                                                $_GET['search_investment']===$plan->slug ? 'selected' : ''; ?> value="<?php echo $plan->slug; ?>">
                                                {{ $plan->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary"
                                    style="padding:10px; width:100%">Search</button>
                            </form>
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
                                    <th>Investor</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Bank Name</th>
                                    <th>Bank Account Number</th>
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
                                            <td> {{ $investment->user->name }}</td>
                                            <td> {{ $investment->user->email }}</td>
                                            <td> {{ $investment->user->phone_number }}</td>
                                            <td> {{ $investment->user->bank_name }}</td>
                                            <td> {{ $investment->user->bank_account_number }}</td>
                                            <td> <?php echo date('F j, Y',
                                                strtotime($investment->activated_on)); ?> </td>
                                            <td> <?php echo date('F j, Y',
                                                strtotime($investment->completed_on)); ?> </td>
                                            <td> Completed </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="14"> No available investment to show </td>
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
    <form id="withdraw-investment-form" method="post" action="{{ route('withdraw-investment') }}">
        <input type="hidden" name="amount">
        <input type="hidden" name="investment_id">
    </form>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.withdraw_amount').on('keyup', function() {
                $('input[name="amount"]').val($(this).val());
            })
            $('.delete-investment').on('click', function() {
                var investmentId = $(this).attr('data-investment-id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, withdraw it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('input[name="investment_id"]').val(investmentId);
                        $('#withdraw-investment-form').submit();
                    }
                })
            })
        })

    </script>
@endsection
