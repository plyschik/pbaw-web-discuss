@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
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
                                Age: {{ $user->date_of_birth->diffInYears() }}
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
                    <div class="col-md-6">
                        @if (count($topChannels) > 0)
                            <div class="card mb-3">
                                <h5 class="card-header">
                                    Top channels
                                </h5>
                                {!! $topChannelsChart->container() !!}

                            </div>
                        @endif
                    </div>
                    <div class="col-md-6">@if (count($usersFrequentlyCommentedPosts) > 0)
                            <div class="card mb-3">
                                <h5 class="card-header">
                                    Frequently commenting users
                                </h5>
                                <ul class="list-group list-group-flush">
                                    {!! $userChart->container() !!}
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                @if (count($latestTopics) > 0)
                    <div class="card mb-3">
                        <h5 class="card-header">
                            Latest posts
                        </h5>
                        <ul class="list-group list-group-flush">
                            @foreach ($latestTopics as $topic)
                                <a class="list-group-item list-group-item-action"
                                   href="{{ route('topics.show', $topic) }}">
                                    {{ $topic->title }}
                                </a>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(Auth::user()->email==$user->email || Auth::user()->hasRole('administrator'))
                    <div class="card mb-3">
                        <h5 class="card-header">
                            Account management
                        </h5>
                        <div class="row justify-content-center">
                            <div class="col-md-9">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <a href="{{ route('users.edit', $user)}}"
                                           class="btn btn-sm btn-block btn-outline-info">Edit</a>
                                    </li>
                                    <li class="list-group-item">
                                        <form action="{{ route('users.destroy', $user)}}"
                                              method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-sm btn-block btn-outline-danger" type="submit">
                                                Delete
                                            </button>
                                        </form>
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/6.0.6/highcharts.js" charset="utf-8"></script>
    {!! $topChannelsChart->script() !!}
    {!! $userChart->script() !!}
@endsection
