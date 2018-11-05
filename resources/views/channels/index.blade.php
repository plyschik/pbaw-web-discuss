@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-7 offset-md-1">
            <table class="table table-bordered">
                <thead class="thead-light">
                <tr>
                    <th class="col-6">Channel</th>
                    <th class="col-1 text-center">Topics</th>
                    <th class="col-1 text-center">Replies</th>
                    <th class="col-4">Last reply</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($channels as $channel)
                    <tr>
                        <td class="align-middle">
                            <a href="{{ route('channels.show', $channel) }}">{{ $channel->name }}</a>
                            <div class="small text-muted">
                                {{ $channel->description }}
                            </div>

                            @hasrole('administrator')
                            <div class="row mt-3">
                                <div class="col-2">
                                    <a class="btn btn-sm btn-block btn-outline-primary" href="{{ route('channels.edit', $channel) }}">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </div>
                                @if ($channel->topics_count == 0)
                                    <div class="col-2">
                                        <form class="form-inline" action="{{ route('channels.destroy', $channel) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-sm btn-block btn-outline-danger" type="submit">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="col-2">
                                        <button class="btn btn-sm btn-block btn-outline-danger" data-toggle="tooltip" data-placement="top" title="You can only delete channel without topics." disabled="disabled">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                            @endhasrole
                        </td>
                        <td class="text-center align-middle">{{ $channel->topics_count }}</td>
                        <td class="text-center align-middle">{{ --$channel->replies_count }}</td>
                        <td class="small align-middle">
                            @if ($channel->lastReplies->isEmpty())
                                ---
                            @else
                                <div class="d-block">
                                    <a href="{{ route('topics.show', ['topic' => $channel->lastReplies->first()['topic']['id']]) }}">{{ $channel->lastReplies->first()['topic']['title'] }}</a>
                                </div>
                                <div clas="d-block">
                                    Author: <a href="{{ route('users.show', ['user' => $channel->lastReplies->first()['user']['id']]) }}">{{ $channel->lastReplies->first()['user']['name'] }}</a>
                                </div>
                                <div class="d-block">
                                    <div class="text-muted">
                                        {{ $channel->lastReplies->first()['created_at'] }}
                                    </div>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-3">
            <div class="card mb-3">
                <h5 class="card-header">
                    <i class="fab fa-hotjar"></i> Popular topics
                </h5>
                <ul class="list-group list-group-flush">
                    @foreach ($popularTopics as $topic)
                        <a class="list-group-item list-group-item-action"
                           href="{{ route('topics.show', $topic) }}">
                            {{ $topic->title }} ({{$topic->replies_count}} replies)
                        </a>
                    @endforeach
                </ul>
            </div>
            <div class="card mb-3">
                <h5 class="card-header">
                    <i class="far fa-clock"></i> Latest topics
                </h5>
                <ul class="list-group list-group-flush">
                    @foreach ($latestTopics as $topic)
                        <a class="list-group-item list-group-item-action"
                           href="{{ route('topics.show', $topic) }}">
                            {{ $topic->title }} (created {{$topic->created_at->diffForHumans()}})
                        </a>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card mb-3">
                <h5 class="card-header">
                    <i class="fas fa-info-circle"></i> WebDiscuss info
                </h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        Total topics: {{ $stats['topics']['total'] }}
                    </li>
                    <li class="list-group-item">
                        Today topics: {{ $stats['topics']['today'] }}
                    </li>
                    <li class="list-group-item">
                        Total replies: {{ $stats['replies']['total'] }}
                    </li>
                    <li class="list-group-item">
                        Today replies: {{ $stats['replies']['today'] }}
                    </li>
                    <li class="list-group-item">
                        Total topics views: {{ $stats['topics']['views'] }}
                    </li>
                    <li class="list-group-item">
                        Average age of users: {{ $stats['users']['average_age'] }}
                    </li>
                    <li class="list-group-item">
                        Last registered: <a href="{{ route('users.show', $stats['users']['last_registered']['id']) }}">{{ $stats['users']['last_registered']['name'] }}</a>
                    </li>
                    <li class="list-group-item">
                        Last logged in: <a href="{{ route('users.show', $stats['users']['last_logged_in']['id']) }}">{{ $stats['users']['last_logged_in']['name'] }}</a>
                    </li>
                    <li class="list-group-item">
                        The most replies ({{ $stats['most_replies']['total'] }}) were on {{ $stats['most_replies']['date'] }}
                    </li>
                </ul>
            </div>
        </div>
    </div>

@endsection
