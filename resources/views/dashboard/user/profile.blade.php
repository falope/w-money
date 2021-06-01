@extends('dashboard.layout')

@section('title', 'My Profile | Wmoney.ng ')

@section('sidemenu')
    @include('dashboard.user._partials.sidemenu')
@endsection

@section('main-header')
    @include('dashboard.user._partials.navigation')
@endsection

<?php $user = Auth::user(); ?>

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
                            <div class="col" style="padding: 0">
                                <h3 class="mb-0">My Profile</h3>
                            </div>

                        </div>
                    </div>
                    <style>
                        form input {
                            margin-bottom: 10px
                        }

                    </style>
                    <form method="post" action="{{ route('update-profile') }}">
                        <input class="form-control" type="text" name="name" placeholder="Enter Name"
                            value="{{ $user->name }}" style="width:100%">
                        <input class="form-control" disabled type="email" name="email" placeholder="Enter Email"
                            value="{{ $user->email }}" />
                        <input class="form-control" type="text" name="phone_number" placeholder="Enter Phone"
                            value="{{ $user->phone_number }}" />
                        <hr>
                        <input class="form-control" type="text" name="address" placeholder="Enter Address"
                            value="{{ $user->address }}" />
                        <input class="form-control" type="text" name="state" placeholder="Enter State"
                            value="{{ $user->state }}">
                        <input class="form-control" type="text" name="country" placeholder="Enter Country"
                            value="{{ $user->country }}">
                        <hr>
                        <input class="form-control" type="text" name="bank_name" placeholder="Enter Bank"
                            value="{{ $user->bank_name }}">
                        <input class="form-control" type="number" name="bank_account_number" placeholder="Enter Acc Number"
                            value="{{ $user->bank_account_number }}">
                        <hr>
                        <button class="btn btn-success btn-block" type="submit" name="update">Update Profile</button>
                    </form>
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
