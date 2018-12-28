@extends('layouts.app')

@section('content')
    <h2 class="mb-3">
        {{ $topic->title }}
    </h2>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('forums.show', $topic->forum) }}">{{ $topic->forum->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $topic->title }}</li>
        </ol>
    </nav>

    @can('manage', $topic)
        <div class="card mb-3 small">
            <div class="card-body p-1">
                <ul class="nav justify-content-center p-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('topics.edit', $topic) }}">Topic edit</a>
                    </li>

                    <form class="form-inline" action="{{ route('topics.destroy', $topic) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <li class="nav-item">
                            <a class="nav-link active" onclick="if (confirm('Are you sure?')) { event.target.parentNode.parentNode.submit(); } else { return false; }" href="#">Delete topic</a>
                        </li>
                    </form>
                </ul>
            </div>
        </div>
    @endcan

    @foreach ($replies as $reply)
        <table class="table table-bordered small">
            <thead class="thead-light">
                <tr>
                    <th class="col-3">
                        <a href="{{ route('users.show', $reply->user) }}">{{ $reply->user->name }}</a>
                    </th>
                    <th class="col-9 text-right">
                        {{ $reply->created_at }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td @auth rowspan="2" @endauth>
                        <ul class="list-unstyled mb-0">
                            <li>
                                Role: <span class="text-muted">{{ $reply->user->roles->first()->name }}</span>
                            </li>
                            <li>
                                Registered: <time class="text-muted" title="{{ $reply->user->created_at }}">{{ $reply->user->created_at->diffForHumans() }}</time>
                            </li>
                            <li>
                                Posts: {{ $reply->user->replies_count }}
                            </li>
                        </ul>
                    </td>
                    <td class="text-justify">
                        {{ $reply->content }}
                    </td>
                </tr>
                @auth
                    <tr>
                        <td class="p-1" colspan="2">
                            <ul class="nav justify-content-end">
                                @auth
                                    <li class="nav-item">
                                        <a class="nav-link active" href="{{ route('response.create', $reply) }}">Reply</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link active" href="{{ route('report.create', $reply) }}">Report</a>
                                    </li>
                                @endauth

                                @can('manage', $reply)
                                    <li class="nav-item">
                                        <a class="nav-link active" href="{{ route('replies.edit', $reply) }}">Edit</a>
                                    </li>

                                    @if ($loop->iteration > 1 || request('page') > 1)
                                        <form class="form-inline" action="{{ route('replies.destroy', $reply) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <li class="nav-item">
                                                <a class="nav-link active" href="#" onclick="if (confirm('Are you sure?')) { event.target.parentNode.parentNode.submit(); } else { return false; }">Delete</a>
                                            </li>
                                        </form>
                                    @endif
                                @endcan
                            </ul>
                        </td>
                    </tr>
                @endauth
            </tbody>
        </table>

        @foreach ($reply->replies as $reply)
            <div class="offset-1">
                <table class="table table-bordered small">
                    <thead class="thead-light">
                        <tr>
                            <th class="col-3">
                                <a href="{{ route('users.show', $reply->user) }}">{{ $reply->user->name }}</a>
                            </th>
                            <th class="col-9 text-right">
                                {{ $reply->created_at }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="col-3" rowspan="2">
                                <ul class="list-unstyled mb-0">
                                    <li>
                                        Role: <span class="text-muted">{{ $reply->user->roles->first()->name }}</span>
                                    </li>
                                    <li>
                                        Registered: <time class="text-muted" title="{{ $reply->user->created_at }}">{{ $reply->user->created_at->diffForHumans() }}</time>
                                    </li>
                                    <li>
                                        Posts: {{ $reply->user->replies_count }}
                                    </li>
                                </ul>
                            </td>
                            <td class="text-justify">
                                {{ $reply->content }}
                            </td>
                        </tr>
                        <tr>
                            <td class="p-1" colspan="2">
                                <ul class="nav justify-content-end">
                                    @auth
                                        <li class="nav-item">
                                            <a class="nav-link active" href="{{ route('report.create', $reply) }}">Report</a>
                                        </li>
                                    @endauth

                                    @can('manage', $reply)
                                        <li class="nav-item">
                                            <a class="nav-link active" href="{{ route('replies.edit', $reply) }}">Edit</a>
                                        </li>

                                        <form class="form-inline" action="{{ route('replies.destroy', $reply) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <li class="nav-item">
                                                <a class="nav-link active" href="#" onclick="if (confirm('Are you sure?')) { event.target.parentNode.parentNode.submit(); } else { return false; }">Delete</a>
                                            </li>
                                        </form>
                                    @endcan
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endforeach
    @endforeach

    {{ $replies->links() }}

    @auth
        <form action="{{ route('replies.store', $topic) }}" method="POST">
            <div class="form-group">
                <label for="reply">Your reply:</label>
                <textarea class="form-control" id="reply" name="reply" rows="3">{{ old('reply') }}</textarea>
                @if ($errors->has('reply'))
                    <span class="help-block">{{ $errors->first('reply') }}</span>
                @endif
            </div>

            @csrf

            <button class="btn btn-primary" type="submit">Send reply</button>
        </form>
    @else
        <div class="alert alert-info">
            <a href="{{ route('login') }}">Sign in</a> to send reply in this topic.
        </div>
    @endauth
@endsection