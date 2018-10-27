@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-md-center">
            <div class="col-md-7">
                <div class="card mb-3">
                    <h5 class="card-header">
                        {{$user->name}}
                    </h5>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"> Joined: {{$user->created_at->diffForHumans()}}
                            </li>
                            <li class="list-group-item"> Total posts: {{count($user->topics)}}
                            </li>
                            <li class="list-group-item"> Posts per
                                day: {{($user->created_at->diffInDays() >0 ) ? count($user->topics)/$user->created_at->diffInDays() : count($user->topics)}}
                            </li>
                            <li class="list-group-item"> Last seen: Today 11:36 AM
                            </li>
                            <li class="list-group-item"> Ip address: {{Request::ip()}}
                            </li>
                            <li class="list-group-item"> User agent: {{Request::server('HTTP_USER_AGENT')}}
                            </li>
                            <li class="list-group-item"> Country:
                            </li>
                            <li class="list-group-item"> Age:
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                @if(count($popularChannels)>0)
                    <div class="card mb-3">
                        <h5 class="card-header">
                            Top channels:
                        </h5>
                        <ul class="list-group list-group-flush">
                            @foreach($popularChannels as $channel)
                                <a href="{{route('topics.channel', $channel)}}"
                                   class="list-group-item list-group-item-action">
                                    {{$channel->name}} ({{$channel->topics_count}})
                                </a>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(count($usersFrequentlyCommentedPosts)>0)
                    <div class="card mb-3">
                        <h5 class="card-header">
                            Users who most frequently comment on your posts:
                        </h5>
                        <ul class="list-group list-group-flush">
                            @foreach($usersFrequentlyCommentedPosts as $user)
                                <a href="#"
                                   class="list-group-item list-group-item-action">
                                    {{$user->name}} ({{$user->replies_count}})
                                </a>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(count($latestTopics)>0)
                    <div class="card mb-3">
                        <h5 class="card-header">
                            Latest posts:
                        </h5>
                        <ul class="list-group list-group-flush">
                            @foreach($latestTopics as $topic)
                                <a href="{{route('topics.show', $topic)}}"
                                   class="list-group-item list-group-item-action">
                                    {{$topic->title}}
                                </a>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>

    </div>
@endsection
