@extends('layouts.app')

@section('content')
    <div class="container">
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
                        <p class="mb-3">
                            <a class="mb-3"
                               href="{{ route('channels.show', $channel) }}">{{ $channel->name }}</a>
                        </p>

                        @hasrole('administrator')
                        <div class="row">
                            <div class="col-2">
                                <a class="btn btn-sm btn-block btn-outline-primary"
                                   href="{{ route('channels.edit', $channel) }}">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            </div>
                            @if ($channel->topics_count == 0)
                                <div class="col-2">
                                    <form class="form-inline"
                                          action="{{ route('channels.destroy', $channel) }}"
                                          method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-sm btn-block btn-outline-danger" type="submit">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="col-2">
                                    <button class="btn btn-sm btn-block btn-outline-danger"
                                            data-toggle="tooltip" data-placement="top"
                                            title="You can only delete channel without topics."
                                            disabled="disabled">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                        @endhasrole
                    </td>
                    <td class="text-center align-middle">{{ $channel->topics_count }}</td>
                    <td class="text-center align-middle">{{ $channel->replies_count }}</td>
                    <td class="small align-middle">
                        @if ($channel->lastReplies->isEmpty())
                            ---
                        @else
                            <div class="d-block">
                                <a href="{{ route('topics.show', ['topic' => $channel->lastReplies->first()['topic']['id']]) }}">{{ $channel->lastReplies->first()['topic']['title'] }}</a>
                            </div>
                            <div clas="d-block">
                                Author: <a
                                        href="{{ route('users.show', ['user' => $channel->lastReplies->first()['user']['id']]) }}">{{ $channel->lastReplies->first()['user']['name'] }}</a>
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
        <div class="card mb-3">
            <h5 class="card-header">
                <i class="fas fa-info-circle"></i> WebDiscuss info
            </h5>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    Total topics: {{$numberOfTopics}}
                </li>
                <li class="list-group-item">
                    Today topics: {{$todayTopics}}
                </li>
                <li class="list-group-item">
                    Total replies: {{$numberOfReplies}}
                </li>
                <li class="list-group-item">
                    Today replies: {{$todayReplies}}
                </li>
                <li class="list-group-item">
                    Average age of users: {{$averageAge}}
                </li>
                <li class="list-group-item">
                    Last registered: <a href=" {{route('users.show', $lastRegistered)}}">{{$lastRegistered->name}}</a>
                </li>
                <li class="list-group-item">
                    Last logged in: <a href=" {{route('users.show', $lastLoggedIn)}}">{{$lastLoggedIn->name}}</a>
                </li>
                <li class="list-group-item">
                    The most replies ({{$mostReplies['numberOfReplies']}}) were on {{$mostReplies['date']}}
                </li>
            </ul>
        </div>
    </div>
@endsection
