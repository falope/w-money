@extends('dashboard.layout')

@section('title', 'Add New Plan | Wmoney.ng ')

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
            <div class="col-md-12 mb-5 mb-xl-0">
                <div class="card shadow" style="padding:20px">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col" style="padding: 0">
                                <h3 class="mb-0">Add A New Plan</h3>
                            </div>

                        </div>
                    </div>
                    <hr style="margin: 0">
                    <div style="margin: 0; margin-bottom: 20px; margin-top: 20px">
                        <style>
                            form input {
                                margin-bottom: 10px
                            }

                        </style>
                        <form id="add-plan-form" method="post" action="{{ route('create-plan') }}"
                            enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Plan Name</label>
                                <input name="name" required type="text" class="form-control" placeholder="Plan Name">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Plan Amount</label>
                                <input name="amount" required type="number" class="form-control" placeholder="Plan Amount">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Plan Duration</label>
                                <input name="duration" required type="number" class="form-control"
                                    placeholder="Plan Duration">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Plan Duration Type</label>
                                <select name="duration_type" class="form-control">
                                    <option>Select duration type</option>
                                    <option value="year">Year</option>
                                    <option selected value="month">Month</option>
                                    <option value="week">Week</option>
                                    <option value="day">Day</option>
                                </select>
                            </div>
                            <input type="hidden" name="meta">
                            <div class="form-group">
                                <label>Image URL</label>
                                <input type="text" name="imageUrl" class="form-control" placeholder="Paste Cloudinary image link">
                            </div>
                            <style>
                                .plan-range {
                                    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
                                    padding-bottom: 10px;
                                }

                            </style>

                            <div id="plan-meta" style="margin-bottom: 20px">
                                <button type="button" class="btn btn-sm btn-info add-range">Add range</button>
                                <div class="plan-range"
                                    style="margin-top: 20px; border: 2px solid rgba(0,0,0,0.1); padding: 10px; border-radius:5px">
                                    <div class="form-group">
                                        <label> Range :</label>
                                        <input class="form-control" type="number" name="range[0][0]"> <input
                                            class="form-control" type="number" name="range[0][1]"> <small> If it is
                                            an above range, e.g 70 units and above, input 70 and 0</small>
                                    </div>
                                    <div class="form-group">
                                        <label> ROI :</label>
                                        <input type="number" class="form-control" name="range[0][2]">
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-success btn-block add-plan" type="button">Add plan</button>
                        </form>
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



@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var ranges = [];
            $('.add-range').on('click', function() {
                var i, lastRange;
                $($('#plan-meta input:last-child')[0]).each(function(i, item) {
                    lastRange = $(item).attr('name').substring(5).split('][').map(function(item) {
                        return Number(item.replace(']', '').replace('[', ''));
                    });
                });
                i = lastRange[0] + 1;
                var html = ` <div class="plan-range" style="margin-top: 20px; border: 2px solid rgba(0,0,0,0.1); padding: 10px; border-radius:5px">
                                                                                <div class="form-group">
                                                                                    <label> Range :</label>
                                                                                    <input class="form-control" type="number" name="range[${i}][0]"> <input
                                                                                        class="form-control" type="number" name="range[${i}][1]"> <small> If it is
                                                                                        an above range, e.g 70 units and above, input 70 and 0</small>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label> ROI :</label>
                                                                                    <input type="number" class="form-control" name="range[${i}][2]">
                                                                                </div>
                                                                            </div>`;
                $('#plan-meta').append(html)
            })
            $('.add-plan').on('click', function() {
                $('#plan-meta input').each(function(i, item) {
                    var lastRange = $(item).attr('name').substring(5).split('][').map(function(
                        item) {
                        return Number(item.replace(']', '').replace('[', ''));
                    });
                    if (!ranges[lastRange[0]]) ranges[lastRange[0]] = [];
                    var value = Number($(this).val());
                    ranges[lastRange[0]][lastRange[1]] = value

                })
                const json = [];
                for (var i = 0; i < ranges.length; i++) {
                    json.push({
                        range: [ranges[i][0], ranges[i][1]],
                        roi: ranges[i][2]
                    })
                }
                $('input[name="meta"]').val(JSON.stringify(json));
                $('#add-plan-form').submit();
            })
        })

    </script>
@endsection
