@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-8">
            @foreach ($categories as $category)
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th colspan="4">
                                <div class="row">
                                    <div class="col">{{ $category->name }}</div>
                                    @hasrole('administrator')
                                        <div class="col-2">
                                            <a class="btn btn-sm btn-block btn-info" href="{{ route('categories.edit', $category) }}">
                                                <i class="fas fa-pen"></i> Edit
                                            </a>
                                        </div>
                                        @if ($category->forums->isEmpty())
                                            <div class="col-2">
                                                <form class="form-inline" action="{{ route('categories.destroy', $category) }}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button class="btn btn-sm btn-block btn-danger confirm-delete" type="submit">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <div class="col-2">
                                                <button class="btn btn-sm btn-block btn-danger" data-toggle="tooltip" data-placement="top" title="You can only delete categories without forums." disabled="disabled">
                                                    <i class="far fa-trash-alt"></i> Delete
                                                </button>
                                            </div>
                                        @endif
                                    @endhasrole
                                </div>
                            </th>
                        </tr>
                        <tr class="small">
                            <th colspan="4">
                                Moderators:
                                @foreach ($category->users as $user)
                                    <a class="badge badge-success" href="{{ route('users.show', $user) }}">
                                        {{ $user->name }}
                                    </a>
                                @endforeach
                                @hasrole('administrator')
                                    <a class="badge badge-primary" href="{{ route('moderators.create', $category) }}">+ new</a>
                                @endhasrole
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="font-weight-bold small">
                            <td class="col-6">Forum</td>
                            <td class="col-1">Topics</td>
                            <td class="col-1">Replies</td>
                            <td class="col-4">Last reply in topic</td>
                        </tr>
                        @if ($category->forums->isEmpty())
                            <tr class="small">
                                <td colspan="4">No forums.</td>
                            </tr>
                        @else
                            @foreach ($category->forums as $forum)
                                <tr class="small">
                                    <td class="align-middle">
                                        <a href="{{ route('forums.show', $forum) }}">{{ $forum->name }}</a>
                                        @if ($forum->description)
                                            <p class="mt-1 mb-0 font-italic">{{ $forum->description }}</p>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">{{ $forum->topics_count }}</td>
                                    <td class="text-center align-middle">{{ $forum->replies_count }}</td>
                                    <td class="align-middle">
                                        @if ($forum->replies->isEmpty())
                                            —
                                        @else
                                            <div class="d-block">
                                                <a href="{{ route('topics.show', $forum->replies->first()->topic) }}">{{ $forum->replies->first()->topic->title }}</a>
                                            </div>
                                            <div clas="d-block">
                                                Author: <a href="{{ route('users.show', $forum->replies->first()->user) }}">{{ $forum->replies->first()->user->name }}</a>
                                            </div>
                                            <div class="d-block">
                                                <div class="text-muted">
                                                    <time title="{{ $forum->replies->first()->created_at }}">{{ $forum->replies->first()->created_at->diffForHumans() }}</time>
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
        <div class="col-4">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fab fa-hotjar"></i> Popular topics
                </div>
                <ul class="list-group list-group-flush small">
                    @foreach (cache('stats.popular_topics') as $topic)
                        <a class="list-group-item list-group-item-action" href="{{ route('topics.show', $topic) }}">
                            {{ $topic->title }} ({{ $topic->replies_count - 1 }} replies)
                        </a>
                    @endforeach
                </ul>
            </div>
            <div class="card mb-3">
                <div class="card-header">
                    <i class="far fa-clock"></i> Latest topics
                </div>
                <ul class="list-group list-group-flush small">
                    @foreach (cache('stats.latest_topics') as $topic)
                        <a class="list-group-item list-group-item-action" href="{{ route('topics.show', $topic) }}">
                            {{ $topic->title }} (created <time title="{{ $topic->created_at }}">{{ $topic->created_at->diffForHumans() }}</time>)
                        </a>
                    @endforeach
                </ul>
            </div>
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info-circle"></i> Statistics
                </div>
                <ul class="list-group list-group-flush small">
                    <li class="list-group-item">
                        Total topics: {{ cache('stats.topics.total') }}
                    </li>
                    <li class="list-group-item">
                        Today topics: {{ cache('stats.topics.today') }}
                    </li>
                    <li class="list-group-item">
                        Total replies: {{ cache('stats.replies.total') }}
                    </li>
                    <li class="list-group-item">
                        Today replies: {{ cache('stats.replies.today') }}
                    </li>
                    <li class="list-group-item">
                        Total topics views: {{ cache('stats.topics.views') }}
                    </li>
                    <li class="list-group-item">
                        Average age of users: {{ cache('stats.users.average_age') }}
                    </li>
                    <li class="list-group-item">
                        Last registered: <a href="{{ route('users.show', cache('stats.users.last_registered')['slug']) }}">{{ cache('stats.users.last_registered')['name'] }}</a>
                    </li>
                    <li class="list-group-item">
                        Last logged in: <a href="{{ route('users.show', cache('stats.users.last_logged_in')['slug']) }}">{{ cache('stats.users.last_logged_in')['name'] }}</a>
                    </li>
                    <li class="list-group-item">
                        The most replies: {{ cache('stats.most_replies')['total'] }} were on: {{ cache('stats.most_replies')['date'] }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection