@extends('dashboard.layout')

@section('title', 'New Partnership | Wmoney.ng ')

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
            @if (count($plans) > 0)
                @foreach ($plans->reverse() as $plan)
                    @if ($plan->name != "Green Africa Project")
                    <div class="col-md-4 mb-4">
                        <div class="card shadow" style="padding:20px; min-height: 635px">
                            <div class="card-header border-0" style="padding: 0">
                                <div class="row align-items-center">
                                    <div class="col-12 mb-3" style="height: 300px">
                                        <img src="{{ $plan->image }}"
                                            style="width:100%;object-fit: cover; height:100%; border-radius: 5px; border: 1px solid rgba(0,0,0,0.1)">
                                    </div>
                                    <div class="col-12">
                                        <h3><b>{{ $plan->name }} ( ₦
                                                <?php echo number_format($plan->amount, 2); ?>)</b></h3>
                                        @foreach ((object) json_decode($plan->meta) as $meta)
                                            <?php
                                            [$a, $b] = $meta->range;
                                            if ($b > 0) {
                                            echo '<p class="mb-2 ml-1">' .
                                                $a .
                                                ' - ' .
                                                $b .
                                                ' units - ' .
                                                $meta->roi .
                                                '%
                                            </p>';
                                            } else {
                                            echo '<p class="mb-2 ml-1">' .
                                                $a .
                                                ' units and above - ' .
                                                $meta->roi .
                                                '%</p>
                                            ';
                                            }
                                            ?>

                                        @endforeach
                                        <p class="mb-2 ml-1">{{ $plan->duration }} {{ ucwords($plan->duration_type) }}s
                                        </p>
                                    </div>

                                </div>
                            </div>
                            <form method="POST" action="{{ route('create-investment') }}" style="margin-top: 5px">
                                <input type="hidden" name="plan_slug" value="{{ $plan->slug }}">
                                <input name="unit" type="number" class="form-control" placeholder="Units" value="1">
                                <button name="submit" type="submit" class="btn btn-success btn-block"
                                    style="margin-top:10px">Subscribe</button>
                            </form>
                        </div>
                    </div>
                    @endif
                @endforeach
            @endif
        </div>
        {{ $plans->links() }}
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
