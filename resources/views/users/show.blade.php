@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-8">
            <div class="card mb-3">
                <h5 class="card-header">
                    {{ $user->name }}
                </h5>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            Joined:
                            <time title="{{ $user->created_at }}">{{ $user->created_at->diffForHumans() }}</time>
                        </li>
                        <li class="list-group-item">
                            Total posts: {{ $user->replies()->count() }}
                        </li>
                        <li class="list-group-item">
                            Posts per
                            day: {{ ($user->created_at->diffInDays() > 0) ? $user->replies()->count() / $user->created_at->diffInDays() : $user->replies()->count() }}
                        </li>
                        <li class="list-group-item">
                            Last logged in: {{ $user->last_logged_in ?? 'N/A' }}
                        </li>
                        <li class="list-group-item">
                            Age:
                            @if ($user->date_of_birth)
                                {{ $user->date_of_birth->diffInYears() }}
                            @else
                                N/A
                            @endif
                        </li>
                        @hasrole('administrator')
                        <li class="list-group-item">
                            IP address: {{ $user->ip_address ?? 'N/A'}}
                        </li>
                        <li class="list-group-item">
                            User agent: {{ $user->user_agent ?? 'N/A' }}
                        </li>
                        @endhasrole
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    @if (!$topChannels->isEmpty())
                        <div class="card mb-3">
                            <h5 class="card-header">
                                Top channels
                            </h5>
                            <div class="card-body">
                                <canvas id="top-channels"></canvas>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-6">
                    @if (!$usersFrequentlyCommentedPosts->isEmpty())
                        <div class="card mb-3">
                            <h5 class="card-header">
                                Frequently commenting users
                            </h5>
                            <div class="card-body">
                                <canvas id="users-frequently-commented-posts"></canvas>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @if (Auth::user()->hasRole('administrator') && $bans->count() > 0)
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-3">
                            <h5 class="card-header">
                                Ban history
                            </h5>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Duration (days)</th>
                                        <th scope="col">Reason</th>
                                        <th scope="col">Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($bans as $ban)
                                        <tr>
                                            <th scope="row">{{$loop->iteration}}</th>
                                            <td>{{$ban->duration}}</td>
                                            <td>{{$ban->comment}}</td>
                                            <td>{{$ban->created_at}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $bans->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-4">
            @if (Auth::user()->hasRole('administrator') && $bans->count() > 0)
                <div class="card mb-3">
                    <h5 class="card-header">
                        Suspensions
                    </h5>
                    <div class="card-body">
                        <div class="row">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    Last ban: {{$lastBan->format('d-m-Y')}}
                                </li>
                                <li class="list-group-item">
                                    Number of bans: {{$numberOfBans}}
                                </li>
                                <li class="list-group-item">
                                    The longest ban: {{$bans->max('duration')}} day(s)
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            @if (!$latestTopics->isEmpty())
                <div class="card mb-3">
                    <h5 class="card-header">
                        Latest posts
                    </h5>
                    <ul class="list-group list-group-flush">
                        @foreach ($latestTopics as $topic)
                            <a class="list-group-item list-group-item-action" href="{{ route('topics.show', $topic) }}">
                                {{ $topic->title }}
                            </a>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (Auth::user()->email == $user->email || Auth::user()->hasRole('administrator'))
                <div class="card mb-3">
                    <h5 class="card-header">
                        Account management
                    </h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <a class="btn btn-sm btn-block btn-outline-info" href="{{ route('users.edit', $user->id)}}">Edit</a>
                            </div>
                            <div class="col-6">
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-sm btn-block btn-outline-danger confirm-delete"
                                            type="submit">Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    @parent

    <script>
        $(document).ready(function () {
            let topChannels = document.getElementById('top-channels');

            let topChannelsChartColors = Array.from({length: {{ $topChannels->count() }} }, function () {
                return randomColorGenerator();
            });

            let topChannelsChart = new Chart(topChannels.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ["{!! $topChannels->implode('label', '", "') !!}"],
                    datasets: [{
                        data: [{!! $topChannels->implode('value', ', ') !!}],
                        backgroundColor: topChannelsChartColors,
                        borderColor: topChannelsChartColors
                    }]
                },
                options: {
                    legend: {
                        display: false
                    },
                    hover: {
                        onHover: function (e) {
                            var point = this.getElementAtEvent(e);

                            if (point.length) {
                                e.target.style.cursor = 'pointer';
                            } else {
                                e.target.style.cursor = 'default';
                            }
                        }
                    }
                }
            });

            let topChannelsChartUrls = ["{!! $topChannels->implode('url', '", "') !!}"];

            topChannels.onclick = function (event) {
                let firstPoint = topChannelsChart.getElementAtEvent(event)[0];

                if (firstPoint) {
                    window.open(topChannelsChartUrls[firstPoint._index], '_blank');
                }
            };

            let usersFrequentlyCommentedPosts = document.getElementById('users-frequently-commented-posts');

            let usersFrequentlyCommentedPostsChartColors = Array.from({length: {{ $usersFrequentlyCommentedPosts->count() }} }, function () {
                return randomColorGenerator();
            });

            let usersFrequentlyCommentedPostsChart = new Chart(usersFrequentlyCommentedPosts.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ["{!! $usersFrequentlyCommentedPosts->implode('label', '", "') !!}"],
                    datasets: [{
                        data: [{!! $usersFrequentlyCommentedPosts->implode('value', ', ') !!}],
                        backgroundColor: usersFrequentlyCommentedPostsChartColors,
                        borderColor: usersFrequentlyCommentedPostsChartColors
                    }]
                },
                options: {
                    legend: {
                        display: false
                    },
                    hover: {
                        onHover: function (e) {
                            var point = this.getElementAtEvent(e);

                            if (point.length) {
                                e.target.style.cursor = 'pointer';
                            } else {
                                e.target.style.cursor = 'default';
                            }
                        }
                    }
                }
            });

            let usersFrequentlyCommentedPostsChartUrls = ["{!! $usersFrequentlyCommentedPosts->implode('url', '", "') !!}"];

            usersFrequentlyCommentedPosts.onclick = function (event) {
                let firstPoint = usersFrequentlyCommentedPostsChart.getElementAtEvent(event)[0];

                if (firstPoint) {
                    window.open(usersFrequentlyCommentedPostsChartUrls[firstPoint._index], '_blank');
                }
            };
        });
    </script>
@endsection