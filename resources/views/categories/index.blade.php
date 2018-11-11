@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8">
                @foreach ($categories as $category)
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th colspan="4">
                                    {{ $category->name }}
                                </th>
                            </tr>
                            <tr>
                                <th class="small" colspan="4">
                                    Category moderators:
                                    @foreach ($category->users as $user)
                                        <a class="badge badge-success" href="{{ route('users.show', $user) }}">
                                            {{ $user->name }}
                                        </a>
                                    @endforeach
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="small font-weight-bold">
                                <td class="col-6">Channel</td>
                                <td class="col-1">Topics</td>
                                <td class="col-1">Replies</td>
                                <td class="col-4">Last reply</td>
                            </tr>
                            @if ($category->channels->isEmpty())
                                <tr>
                                    <td class="small" colspan="4">No channels.</td>
                                </tr>
                            @else
                                @foreach ($category->channels as $channel)
                                    <tr class="small">
                                        <td class="align-middle">
                                            <a href="{{ route('channels.show', $channel) }}">{{ $channel->name }}</a>
                                            @if ($channel->description)
                                                <p class="mt-1 mb-0 font-italic">{{ $channel->description }}</p>
                                            @endif
                                        </td>
                                        <td class="text-center align-middle">
                                            {{ $channel->topics_count }}
                                        </td>
                                        <td class="text-center align-middle">
                                            {{ $channel->replies_count }}
                                        </td>
                                        <td class="align-middle">
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
                            @endif
                        </tbody>
                    </table>
                @endforeach
            </div>
            {{--
            <div class="col-8">
                <table class="table table-bordered">
                    <thead class="thead-light">
                    <tr>
                        <th class="col-3 text-center">Category</th>
                        <th class="col-4 text-center">Channels</th>
                        <th class="col-2 text-center">Moderators</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td class="align-middle">
                                <a href="{{ route('categories.show', $category) }}">{{ $category->name }}</a>
                                <div class="small text-muted">
                                    {{ str_limit($category->description, 50) }}
                                </div>
                                @hasrole('administrator')
                                <div class="row mt-3">
                                    <div class="col-3">
                                        <a class="btn btn-sm btn-block btn-outline-primary"
                                           href="{{ route('categories.edit', $category) }}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    </div>
                                    @if ($category->channels()->count() == 0)
                                        <div class="col-3">
                                            <form class="form-inline"
                                                  action="{{ route('categories.destroy', $category) }}"
                                                  method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-sm btn-block btn-outline-danger confirm-delete"
                                                        type="submit">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <div class="col-3">
                                            <button class="btn btn-sm btn-block btn-outline-danger"
                                                    data-toggle="tooltip" data-placement="top"
                                                    title="You can only delete category without channels."
                                                    disabled="disabled">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                                @endhasrole
                            </td>
                            <td class="small align-middle">
                                <div class="list-group">
                                    @foreach ($category->channels as $channel)
                                        <a class="list-group-item list-group-item-action"
                                           href="{{ route('channels.show', $channel) }}">
                                            {{$channel->name}}
                                        </a>
                                    @endforeach
                                </div>
                            </td>
                            <td class="align-middle">
                                    @foreach ($category->users as $user)
                                        <a class="badge badge-light"
                                           href="{{ route('users.show', $user) }}">
                                            {{$user->name}}
                                        </a>
                                    @endforeach
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            --}}
            <div class="col-4">
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fab fa-hotjar"></i> Popular topics
                    </div>
                    <ul class="list-group list-group-flush small">
                        @foreach ($popularTopics as $topic)
                            <a class="list-group-item list-group-item-action"
                               href="{{ route('topics.show', $topic) }}">
                                {{ $topic->title }} ({{$topic->replies_count - 1}} replies)
                            </a>
                        @endforeach
                    </ul>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="far fa-clock"></i> Latest topics
                    </div>
                    <ul class="list-group list-group-flush small">
                        @foreach ($latestTopics as $topic)
                            <a class="list-group-item list-group-item-action"
                               href="{{ route('topics.show', $topic) }}">
                                {{ $topic->title }} (created {{$topic->created_at->diffForHumans()}})
                            </a>
                        @endforeach
                    </ul>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-info-circle"></i> Statistics
                    </div>
                    <ul class="list-group list-group-flush small">
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
                            Last registered: <a
                                    href="{{ route('users.show', $stats['users']['last_registered']['id']) }}">{{ $stats['users']['last_registered']['name'] }}</a>
                        </li>
                        <li class="list-group-item">
                            Last logged in: <a
                                    href="{{ route('users.show', $stats['users']['last_logged_in']['id']) }}">{{ $stats['users']['last_logged_in']['name'] }}</a>
                        </li>
                        <li class="list-group-item">
                            The most replies ({{ $stats['most_replies']['total'] }}) were
                            on {{ $stats['most_replies']['date'] }}
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
@endsection
