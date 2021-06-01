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
                                <h3 class="mb-0">Users</h3>
                            </div>
                            <div class="col text-right">

                                <a href="{{ route('download-user-csv') }}"
                                    class="float-right btn btn-sm btn-success text-white"> Download All Records CSV </a>
                            </div>
                        </div>
                    </div>
                    <hr style="margin: 0">
                    <div class="row" style="margin: 0; margin-bottom: 20px; margin-top: 20px">
                        <div class="col-6">
                            <form method="GET">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Search by User's Information</label>
                                    <input name="search_user" type="text" class="form-control"
                                        value="<?php echo $_GET['search_user'] ?? ''; ?>"
                                        placeholder="Search for name, phone number, email, bank name, bank account number">
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
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Date Joined</th>
                                    <th>Bank Name</th>
                                    <th>Bank Account Number</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($users) > 0)
                                    @foreach ($users as $count => $user)
                                        <tr>
                                            <td> {{ $count + 1 }}</td>
                                            <td> {{ $user->name }}</td>
                                            <td> {{ $user->email }}</td>
                                            <td> {{ $user->phone_number }}</td>
                                            <td> <?php echo date('F j, Y', strtotime($user->created_at)); ?> </td>
                                            <td> {{ $user->bank_name }}</td>
                                            <td> {{ $user->bank_account_number }}</td>
                                            <td><button class='btn btn-warning btn-sm login-user'
                                                    data-user-id='{{ $user->id }}'>
                                                    Login as user </button></td>
                                            <td><button class='btn btn-danger btn-sm delete-user'
                                                    data-user-id='{{ $user->id }}'>
                                                    Delete </button></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="13"> No available user to show </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        {{ $users->links() }}
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
    <form id="delete-user-form" method="post" action="{{ route('delete-user') }}">
        <input type="hidden" name="user_id">
    </form>
    <form id="login-user-form" method="post" action="{{ route('login-as-user') }}">
        <input type="hidden" name="user_id">
    </form>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.delete-user').on('click', function() {
                var userId = $(this).attr('data-user-id');
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
                        $('input[name="user_id"]').val(userId);
                        $('#delete-user-form').submit();
                    }
                })
            })
            $('.login-user').on('click', function() {
                var userId = $(this).attr('data-user-id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You will have to log in again as administrator",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, continue'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('input[name="user_id"]').val(userId);
                        $('#login-user-form').submit();
                    }
                })
            })
        })

    </script>
@endsection
