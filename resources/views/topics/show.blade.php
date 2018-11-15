@extends('layouts.app')

@section('content')
    <div class="row align-items-center mb-3">
        <div class="col">
            <h2>
                {{ $topic->title }} ({{ $topic->channel->name }})
            </h2>
        </div>
        @can('manage', $topic)
            <div class="col-1">
                <a class="btn btn-sm btn-block btn-outline-info" href="{{ route('topics.edit', $topic) }}">
                    <i class="fas fa-pen"></i>
                </a>
            </div>
            <div class="col-1">
                <form class="form-inline" action="{{ route('topics.destroy', $topic) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button class="btn btn-sm btn-block btn-outline-danger confirm-delete" type="submit">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        @endcan
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('channels.show', $topic->channel) }}">{{ $topic->channel->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $topic->title }}</li>
        </ol>
    </nav>
    @foreach ($replies as $reply)
        <div class="card mb-3">
            <div class="card-body text-justify">
                {{ $reply->content }}
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col">
                        Posted by <a href="{{ route('users.show', $reply->user) }}">{{ $reply->user->name }}</a>, <time title="{{ $reply->created_at }}">{{ $reply->created_at->diffForHumans() }}</time>.
                    </div>

                    @if (Auth::check())
                        <div class="col-1">
                            <a class="btn btn-block btn-sm btn-outline-success" href="{{ route('response.create', $reply) }}">
                                <i class="fas fa-reply"></i>
                            </a>
                        </div>
                    @endif

                    @can('manage', $reply)
                        <div class="col-1">
                            <a class="btn btn-sm btn-block btn-outline-info" href="{{ route('replies.edit', $reply) }}">
                                <i class="fas fa-pen"></i>
                            </a>
                        </div>
                        @if ($loop->iteration > 1 || request('page') > 1)
                            <div class="col-1">
                                <form class="form-inline" action="{{ route('replies.destroy', $reply) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-sm btn-block btn-outline-danger confirm-delete" type="submit">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endcan
                    @hasrole('user')
                        <div class="col-1">
                            <a class="btn btn-sm btn-block btn-outline-warning" href="{{ route('report.create', $reply) }}">
                                <i class="fas fa-exclamation-triangle"></i>
                            </a>
                        </div>
                    @endhasrole
                </div>
            </div>
        </div>

        @foreach ($reply->replies as $reply)
            <div class="card mb-3 ml-5">
                <div class="card-body text-justify">
                    {{ $reply->content }}
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col">
                            Posted by <a href="{{ route('users.show', $reply->user) }}">{{ $reply->user->name }}</a>, <time title="{{ $reply->created_at }}">{{ $reply->created_at->diffForHumans() }}</time>.
                        </div>
                        @can('manage', $reply)
                            <div class="col-1">
                                <a class="btn btn-sm btn-block btn-outline-info" href="{{ route('replies.edit', $reply) }}">
                                    <i class="fas fa-pen"></i>
                                </a>
                            </div>
                            <div class="col-1">
                                <form class="form-inline" action="{{ route('replies.destroy', $reply) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-sm btn-block btn-outline-danger confirm-delete" type="submit">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        @endcan
                        @hasrole('user')
                            <div class="col-1">
                                <a class="btn btn-sm btn-block btn-outline-warning" href="{{ route('report.create', $reply) }}">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </a>
                            </div>
                        @endhasrole
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach

    {{ $replies->links() }}

    @if (Auth::check())
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
    @endif
@endsection