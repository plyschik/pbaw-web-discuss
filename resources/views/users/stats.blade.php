@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Statistics</div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Age of users</div>
                        <div class="card-body">
                            {!! $ageChart->container() !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Forums</div>
                        <div class="card-body">
                            {!! $forumsChart->container() !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Users activity due to time [24h]</div>
                        <div class="card-body">
                            {!! $activityChart->container() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent

    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/6.0.6/highcharts.js" charset="utf-8"></script>
    {!! $ageChart->script() !!}
    {!! $forumsChart->script() !!}
    {!! $activityChart->script() !!}
@endsection