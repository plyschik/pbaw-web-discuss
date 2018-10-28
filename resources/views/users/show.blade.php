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
                                Joined: <time title="{{ $user->created_at }}">{{ $user->created_at->diffForHumans() }}</time>
                            </li>
                            <li class="list-group-item">
                                Total posts: {{ $user->replies()->count() }}
                            </li>
                            <li class="list-group-item">
                                Posts per day: {{ ($user->created_at->diffInDays() > 0) ? $user->topics()->count() / $user->created_at->diffInDays() : $user->topics()->count() }}
                            </li>
                            <li class="list-group-item">
                                Last seen: @TODO
                            </li>
                            <li class="list-group-item">
                                Age: {{ $user->date_of_birth->diffInYears() }}
                            </li>
                            @hasrole('administrator')
                                <li class="list-group-item">
                                    IP address: @TODO
                                </li>
                                <li class="list-group-item">
                                    User agent: @TODO
                                </li>
                            @endhasrole
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                @if (count($popularChannels) > 0)
                    <div class="card mb-3">
                        <h5 class="card-header">
                            Top channels:
                        </h5>
                        <ul class="list-group list-group-flush">
                            @foreach ($popularChannels as $channel)
                                <a class="list-group-item list-group-item-action" href="{{ route('channels.show', $channel) }}">
                                    {{ $channel->name }} ({{$channel->topics_count}} {{ str_plural('topic', $channel->topics_count) }})
                                </a>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (count($usersFrequentlyCommentedPosts) > 0)
                    <div class="card mb-3">
                        <h5 class="card-header">
                            Users who most frequently comment on your posts:
                        </h5>
                        <ul class="list-group list-group-flush">
                            @foreach ($usersFrequentlyCommentedPosts as $user)
                                <a class="list-group-item list-group-item-action" href="{{ route('users.show', ['user' => $user->id]) }}">
                                    {{ $user->name }} ({{ $user->replies_count }})
                                </a>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (count($latestTopics) > 0)
                    <div class="card mb-3">
                        <h5 class="card-header">
                            Latest posts:
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
            </div>
        </div>
    </div>
@endsection
