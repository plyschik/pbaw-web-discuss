@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            @foreach ($categories as $category)
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th colspan="4">{{ $category->name }}</th>
                        </tr>
                        <tr class="small">
                            <th colspan="4">
                                Moderators:
                                @foreach ($category->users as $user)
                                    <a class="badge badge-success" href="{{ route('users.show', $user) }}">{{ $user->name }}</a>
                                @endforeach
                                @hasrole('administrator')
                                    <a class="badge badge-primary" href="{{ route('moderators.create', $category) }}">+ new</a>
                                @endhasrole
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="small">
                            <th class="col-7">Forum</th>
                            <th class="col-1 text-center">Topics</th>
                            <th class="col-1 text-center">Posts</th>
                            <th class="col-3">Last post</th>
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
                                            <div class="mt-1 font-italic">{{ $forum->description }}</div>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">{{ $forum->topics_count }}</td>
                                    <td class="text-center align-middle">{{ $forum->replies_count }}</td>
                                    <td class="align-middle">
                                        @if ($forum->replies->isEmpty())
                                            —
                                        @else
                                            <div class="d-block">
                                                <a href="{{ route('topics.show', $forum->replies->first()->topic) }}">
                                                    {{ str_limit($forum->replies->first()->topic->title, 30) }}
                                                </a>
                                            </div>
                                            <div clas="d-block">
                                                Author:
                                                <a href="{{ route('users.show', $forum->replies->first()->user) }}">
                                                    {{ $forum->replies->first()->user->name }}
                                                </a>
                                            </div>
                                            <div class="d-block">
                                                <div class="text-muted">
                                                    <time title="{{ $forum->replies->first()->created_at }}">
                                                        {{ $forum->replies->first()->created_at->diffForHumans() }}
                                                    </time>
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

            <div class="card mb-3">
                <div class="card-header">Statistics</div>
                <div class="card-body small">
                    <div class="d-block">
                        Our members have made a total of <b>{{ number_format(cache('posts_count')) }}</b> posts in <b>{{ number_format(cache('topics_count')) }}</b> threads.
                    </div>
                    <div class="d-block">
                        We currently have <b>{{ number_format(cache('users_count')) }}</b> members registered.
                    </div>
                    <div class="d-block">
                        Please welcome our newest member, <a href="{{ route('users.show', cache('latest_user')) }}">{{ cache('latest_user')->name }}</a>.
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between small">
                <div>
                    Powered by WebDiscuss, 2018
                </div>
                <div>
                    Current time: {{ date('d/m/Y H:i:s') }}
                </div>
            </div>
        </div>
    </div>
@endsection