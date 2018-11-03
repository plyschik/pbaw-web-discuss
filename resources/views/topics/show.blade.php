@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mb-3">
            <h5 class="card-header">
                {{ $topic->title }} ({{ $topic->channel->name }})
            </h5>
            <div class="card-body text-justify">
                {{ $topic->content }}
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col">
                        Added by <a href="{{ route('users.show', ['user' => $topic->user->id]) }}">{{ $topic->user->name }}</a>, <time title="{{ $topic->created_at }}">{{ $topic->created_at->diffForHumans() }}</time>.
                    </div>
                    @can('manage', $topic)
                        <div class="col-1">
                            <a class="btn btn-sm btn-block btn-outline-info" href="{{ route('topics.edit', ['topic' => $topic->id]) }}">
                                <i class="fas fa-pen"></i>
                            </a>
                        </div>
                        <div class="col-1">
                            <form class="form-inline" action="{{ route('topics.destroy', $topic->id) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-sm btn-block btn-outline-danger" type="submit">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    @endcan
                </div>
            </div>
        </div>

        @foreach ($replies as $reply)
            <div class="card mb-3">
                <div class="card-body text-justify">
                    {{ $reply->content }}
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col">
                            Posted by <a href="{{ route('users.show', ['user' => $reply->user->id]) }}">{{ $reply->user->name }}</a>, <time title="{{ $reply->created_at }}">{{ $reply->created_at->diffForHumans() }}</time>.
                        </div>

                        @if (Auth::check())
                            <div class="col-1">
                                <a class="btn btn-block btn-sm btn-outline-success" href="{{ route('response.create', ['reply' => $reply->id]) }}">
                                    <i class="fas fa-reply"></i>
                                </a>
                            </div>
                        @endif

                        @can('manage', $reply)
                            <div class="col-1">
                                <a class="btn btn-sm btn-block btn-outline-info" href="{{ route('replies.edit', ['reply' => $reply->id]) }}">
                                    <i class="fas fa-pen"></i>
                                </a>
                            </div>
                            <div class="col-1">
                                <form class="form-inline" action="{{ route('replies.destroy', $reply->id) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-sm btn-block btn-outline-danger" type="submit">
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

            @foreach ($reply->replies as $reply)
                <div class="card mb-3 ml-5">
                    <div class="card-body text-justify">
                        {{ $reply->content }}
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                Posted by <a href="{{ route('users.show', ['user' => $reply->user->id]) }}">{{ $reply->user->name }}</a>, <time title="{{ $reply->created_at }}">{{ $reply->created_at->diffForHumans() }}</time>.
                            </div>
                            @can('manage', $reply)
                            <div class="col-1">
                                    <a class="btn btn-sm btn-block btn-outline-info" href="{{ route('replies.edit', ['reply' => $reply->id]) }}">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                </div>
                                <div class="col-1">
                                    <form class="form-inline" action="{{ route('replies.destroy', $reply->id) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-sm btn-block btn-outline-danger" type="submit">
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
            <form action="{{ route('replies.store', ['topic' => $topic->id]) }}" method="POST">
                <div class="form-group">
                    <label for="reply">Your reply:</label>
                    <textarea class="form-control" id="reply" name="reply" rows="3" required="required">{{ old('reply') }}</textarea>
                    @if ($errors->has('reply'))
                        <span class="help-block">{{ $errors->first('reply') }}</span>
                    @endif
                </div>
                {{ csrf_field() }}
                <input class="btn btn-primary" type="submit" value="Send reply">
            </form>
        @else
            <div class="alert alert-info">
                <a href="{{ route('login') }}">Sign in</a> to send reply in this topic.
            </div>
        @endif
    </div>
@endsection