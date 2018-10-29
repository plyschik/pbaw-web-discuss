@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <h5 class="card-header">
                        {{ $topic->title }} ({{ $topic->channel->name }})
                    </h5>
                    <div class="card-body">
                        {{ $topic->content }}
                    </div>
                    <div class="card-footer">
                        <div class="row justify-content-between">
                            <div class="col-9">
                                Added by <a href="{{ route('users.show', ['user' => $topic->user->id]) }}">{{ $topic->user->name }}</a>, <time title="{{ $topic->created_at }}">{{ $topic->created_at->diffForHumans() }}</time>.
                            </div>
                            <div class="col-2">
                                <a class="btn btn-sm btn-block btn-outline-dark" href="{{ route('reports.create', $topic) }}">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                @foreach ($replies as $reply)
                    <div class="card mb-3">
                        <div class="card-body text-justify">
                            {{ $reply->content }}
                        </div>
                        <div class="card-footer">
                            <div class="row d-flex align-items-center h-100">
                                <div class="col-md align-bottom">
                                    Posted by <a href="{{ route('users.show', ['user' => $reply->user->id]) }}">{{ $reply->user->name }}</a>, <time title="{{ $reply->created_at }}">{{ $reply->created_at->diffForHumans() }}</time>.
                                </div>

                                @if (Auth::check())
                                    <div class="col-md-2">
                                        <a class="btn btn-block btn-sm btn-outline-success" href="{{ route('response.create', ['reply' => $reply->id]) }}">Reply</a>
                                    </div>
                                @endif

                                @hasrole('moderator|administrator')
                                    <div class="col-md-2">
                                        <a class="btn btn-sm btn-block btn-outline-info" href="{{ route('replies.edit', ['reply' => $reply->id]) }}">Edit</a>
                                    </div>
                                    <div class="col-md-2">
                                        <form class="form-inline" action="{{ route('replies.destroy', $reply->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-sm btn-block btn-outline-danger" type="submit">Delete</button>
                                        </form>
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
                                <div class="row d-flex align-items-center h-100">
                                    <div class="col-md align-bottom">
                                        Posted by <a href="{{ route('users.show', ['user' => $reply->user->id]) }}">{{ $reply->user->name }}</a>, <time title="{{ $reply->created_at }}">{{ $reply->created_at->diffForHumans() }}</time>.
                                    </div>
                                    @hasrole('moderator|administrator')
                                    <div class="col-md-2">
                                        <a class="btn btn-sm btn-block btn-outline-info" href="{{ route('replies.edit', ['reply' => $reply->id]) }}">Edit</a>
                                    </div>
                                    <div class="col-md-2">
                                        <form class="form-inline" action="{{ route('replies.destroy', $reply->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-sm btn-block btn-outline-danger" type="submit">Delete</button>
                                        </form>
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
                        <input type="hidden" name="topic_id" value="{{ $topic->id }}">

                        <div class="form-group">
                            <label for="reply">Your reply:</label>
                            <textarea class="form-control" id="reply" name="reply" rows="3" required="required">{{ old('reply') }}</textarea>
                            @if ($errors->has('reply'))
                                <span class="help-block">{{ $errors->first('reply') }}</span>
                            @endif
                        </div>

                        {{ csrf_field() }}

                        <input type="submit" class="btn btn-primary" value="Send reply">
                    </form>
                @else
                    <div class="alert alert-info">
                        <a href="{{ route('login') }}">Sign in</a> to send reply in this topic.
                    </div>
                @endif
            </div>

            @hasrole('administrator')
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-header">
                            Moderate topic
                        </div>
                        <div class="row justify-content-around mb-3 mt-3">
                            <div class="col-md-5">
                                <a class="btn btn-sm btn-block btn-outline-info" href="{{ route('topics.edit', ['topic' => $topic->id]) }}">Edit</a>
                            </div>
                            <div class="col-md-5">
                                <form class="form-inline" action="{{ route('topics.destroy', $topic->id) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-sm btn-block btn-outline-danger" type="submit">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endhasrole
        </div>
    </div>
@endsection