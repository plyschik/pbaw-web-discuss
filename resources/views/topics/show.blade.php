@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row align-items-center mb-3">
            <div class="col">
                <h2>
                    {{ $topic->title }} ({{ $topic->channel->name }})
                </h2>
            </div>
            @can('manage', $topic)
                <div class="col-1">
                    <a class="btn btn-sm btn-block btn-outline-info"
                       href="{{ route('topics.edit', ['topic' => $topic]) }}">
                        <i class="fas fa-pen"></i>
                    </a>
                </div>
                <div class="col-1">
                    <form class="form-inline" action="{{ route('topics.destroy', $topic) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button class="btn btn-sm btn-block btn-outline-danger" type="submit">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            @endcan
        </div>

        @foreach ($replies as $reply)
            <div class="card mb-3">
                <div class="card-body text-justify">
                    {{ $reply->content }}
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col">
                            Posted by <a
                                    href="{{ route('users.show', ['user' => $reply->user]) }}">{{ $reply->user->name }}</a>,
                            <time title="{{ $reply->created_at }}">{{ $reply->created_at->diffForHumans() }}</time>
                            .
                        </div>

                        @if (Auth::check())
                            <div class="col-1">
                                <a class="btn btn-block btn-sm btn-outline-success"
                                   href="{{ route('response.create', $reply) }}">
                                    <i class="fas fa-reply"></i>
                                </a>
                            </div>
                        @endif

                        @can('manage', $reply)
                            <div class="col-1">
                                <a class="btn btn-sm btn-block btn-outline-info"
                                   href="{{ route('replies.edit', $reply) }}">
                                    <i class="fas fa-pen"></i>
                                </a>
                            </div>
                            @if ($loop->iteration > 1)
                                <div class="col-1">
                                    <form class="form-inline" action="{{ route('replies.destroy', $reply) }}"
                                          method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-sm btn-block btn-outline-danger" type="submit">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endcan
                        @hasrole('user')
                        <div class="col-1">
                            <a class="btn btn-sm btn-block btn-outline-warning"
                               href="{{ route('report.create', $reply) }}">
                                <i class="fas fa-exclamation-triangle"></i>
                            </a>
                        </div>
                        @endhasrole
                    </div>
                </div>
            </div>
            @if ($loop->first && $numberOfReplies>0)
                <div class="card border-light">
                    <div class="card-header">
                        <i class="far fa-comments"></i> Comments ({{$numberOfReplies}})
                    </div>
                    @endif
                    @foreach ($reply->replies as $reply)
                        <div class="card mb-3 ml-5">
                            <div class="card-body text-justify">
                                {{ $reply->content }}
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col">
                                        Posted by <a
                                                href="{{ route('users.show', ['user' => $reply->user]) }}">{{ $reply->user->name }}</a>,
                                        <time title="{{ $reply->created_at }}">{{ $reply->created_at->diffForHumans() }}</time>
                                        .
                                    </div>
                                    @can('manage', $reply)
                                        <div class="col-1">
                                            <a class="btn btn-sm btn-block btn-outline-info"
                                               href="{{ route('replies.edit', $reply) }}">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                        </div>
                                        <div class="col-1">
                                            <form class="form-inline" action="{{ route('replies.destroy', $reply) }}"
                                                  method="POST">
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
                                        <a class="btn btn-sm btn-block btn-outline-warning"
                                           href="{{ route('report.create', $reply) }}">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </a>
                                    </div>
                                    @endhasrole
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if ($loop->first && $numberOfReplies>0)
                </div>
            @endif
        @endforeach

        {{ $replies->links() }}

        @if (Auth::check())
            <form action="{{ route('replies.store', $topic) }}" method="POST">
                <div class="form-group">
                    <label for="reply">Your reply:</label>
                    <textarea class="form-control" id="reply" name="reply" rows="3"
                              required="required">{{ old('reply') }}</textarea>
                    @if ($errors->has('reply'))
                        <span class="help-block">{{ $errors->first('reply') }}</span>
                    @endif
                </div>
                @csrf
                <input class="btn btn-primary" type="submit" value="Send reply">
            </form>
        @else
            <div class="alert alert-info">
                <a href="{{ route('login') }}">Sign in</a> to send reply in this topic.
            </div>
        @endif
    </div>
@endsection