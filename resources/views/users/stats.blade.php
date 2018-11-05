@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Statistics</div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-header">
                                Age of users
                            </div>
                            <div class="card-body">
                                {!! $ageChart->container() !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-header">
                                Channels
                            </div>
                            <div class="card-body">
                                {!! $channelChart->container() !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                Users activity due to time
                            </div>
                            <div class="card-body">
                                {!! $activityChart->container() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/6.0.6/highcharts.js" charset="utf-8"></script>
    {!! $ageChart->script() !!}
    {!! $channelChart->script() !!}
    {!! $activityChart->script() !!}
@endsection
