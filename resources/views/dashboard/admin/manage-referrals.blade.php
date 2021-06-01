@extends('dashboard.layout')

@section('title', 'Manage Users | Wmoney.ng ')

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
                                <h3 class="mb-0">Manage Referrals</h3>
                            </div>
                            <div class="col text-right">

                            </div>
                        </div>
                    </div>
                    <hr style="margin: 0">
                    <div class="table-responsive">
                        <table style="width: 100%;" class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Email</th>
                                    <th>Investor</th>
                                    <th>Earnings</th>
                                    <th>Bank Name</th>
                                    <th>Bank Account Number</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($referrals) > 0)
                                    @foreach ($referrals as $count => $referral)
                                        <tr>
                                            <td> {{ $count + 1 }}</td>
                                            <td> {{ $referral->user->email }}</td>
                                            <td> {{ $referral->user->name }}</td>
                                            <td> ₦<?php echo number_format((float) $referral->earnings, 2); ?></td>
                                            <td> {{ $referral->user->bank_name }}</td>
                                            <td> {{ $referral->user->bank_account_number }}</td>
                                            <td><button class='btn btn-success btn-sm pay-now'
                                                    data-transaction-id='{{ $referral->id }}'>
                                                    Pay Now </button></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="13"> No available record to show</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        {{ $referrals->links() }}
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
    <form id="pay-now-form" method="post" action="{{ route('pay-referral') }}">
        <input type="hidden" name="transaction_id">
    </form>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.pay-now').on('click', function() {
                var transactionId = $(this).attr('data-transaction-id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, pay now!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('input[name="transaction_id"]').val(transactionId);
                        $('#pay-now-form').submit();
                    }
                })
            })
        })

    </script>
@endsection
