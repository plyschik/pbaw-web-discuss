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
                        Added by <a href="#">{{ $topic->user->name }}</a>,
                        <time title="{{ $topic->created_at }}">{{ $topic->created_at->diffForHumans() }}</time>.
                    </div>
                </div>

                @foreach ($replies as $reply)
                    <div class="card mb-3">
                        <div class="card-body">
                            {{ $reply->content }}
                        </div>
                        <div class="card-footer">
                            <div class="row d-flex align-items-center h-100">
                                <div class="col-md align-bottom">
                                    Posted by <a href="#">{{ $reply->user->name }}</a>,
                                    <time title="{{ $reply->created_at }}">{{ $reply->created_at->diffForHumans()}}</time>.
                                </div>
                                @hasrole('moderator|administrator')
                                <div class="col-md-2">
                                    <a href="{{ route('replies.edit', ['reply' => $reply->id]) }}"
                                       class="btn btn-sm btn-block btn-outline-info">Edit</a>
                                </div>
                                <div class="col-md-2">
                                    <form action="{{ route('replies.destroy', $reply->id) }}" class="form-inline"
                                          method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-sm btn-block btn-outline-danger" type="submit">Delete
                                        </button>
                                    </form>
                                </div>
                                @endhasrole
                            </div>
                        </div>
                    </div>
                @endforeach

                {{ $replies->links() }}

                @if (Auth::check())
                    <form action="{{ route('replies.store', ['topic' => $topic->id]) }}" method="POST">
                        <input type="hidden" name="topic_id" value="{{ $topic->id }}">
                        <div class="form-group">
                            <label for="reply">Your reply:</label>
                            <textarea class="form-control" id="reply" name="reply" rows="3"
                                      required="required"></textarea>
                            @if ($errors->has('reply'))
                                <span class="help-block">{{ $errors->first('reply') }}</span>
                            @endif
                        </div>
                        <input type="submit" class="btn btn-primary" value="Send reply">
                        {{ csrf_field() }}
                    </form>
                @else
                    <div class="alert alert-info">
                        <a href="{{ route('login') }}">Sign in</a> to send reply in this topic.
                    </div>
                @endif
            </div>

            <div class="col-md-4">
                @hasrole('administrator')
                <div class="card mb-3">
                    <div class="card-header">
                        Moderate topic
                    </div>
                    <div class="row justify-content-around mb-3 mt-3">
                        <div class="col-md-5">

                        </div>
                        <div class="col-md-5">
                            <form action="{{ route('topics.destroy', $topic->id) }}" class="form-inline" method="POST">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-sm btn-block btn-outline-danger" type="submit">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endhasrole
                <div class="card">
                    <div class="card-header">
                        Channels
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach ($channels as $channel)
                            <a href="{{ route('topics.channel', ['channel' => $channel->id]) }}"
                               class="list-group-item list-group-item-action">{{ $channel->name }}
                                ({{ $channel->topics_count }})</a>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
