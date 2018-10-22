@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="card mb-3">
                    <h5 class="card-header">
                        {{$topic->title}} ({{$topic->channel->name}})
                    </h5>
                    <div class="card-body">
                        {{ $topic->content }}
                    </div>
                    <div class="card-footer">
                        Added by <a href="#">{{$topic->user->name}}</a>, {{ $topic->created_at->diffForHumans()}}.
                    </div>
                </div>
            </div>

            @foreach ($replies as $reply)
                <div class="col-md-7">
                    <div class="card mb-3">
                        <div class="card-body">
                            {{ $reply->content }}
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    Posted by <a href="#">{{ $reply->user->name }}</a>, <time title="{{ $reply->created_at }}">{{ $reply->created_at->diffForHumans()}}</time>.
                                </div>
                                @hasrole('administrator|moderator')
                                    <div class="col-md-3 offset-md-3">
                                        <div class="row">
                                            <div class="col-xs-5 mr-1 ml-2">
                                                <a href="{{ route('replies.edit', ['reply' => $reply->id]) }}" class="btn btn-outline-info">Edit</a>
                                            </div>
                                            <div class="col-xs-5">
                                                <form action="{{ route('replies.destroy', $reply->id) }}" class="form-inline" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button class="btn btn-outline-danger" type="submit">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endhasrole
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="col-md-7">
                {{ $replies->links() }}
            </div>

            @if (Auth::check())
                <div class="col-md-7">
                    <form action="{{ route('replies.store', ['topic' => $topic->id]) }}" method="POST">
                        <input type="hidden" name="topic_id" value="{{ $topic->id }}">
                        <div class="form-group">
                            <label for="reply">Your reply:</label>
                            <textarea class="form-control" id="reply" name="reply" rows="3" required="required"></textarea>
                            @if ($errors->has('reply'))
                                <span class="help-block">{{ $errors->first('reply') }}</span>
                            @endif
                        </div>
                        <input type="submit" class="btn btn-primary" value="Send reply">
                        {{ csrf_field() }}
                    </form>
                </div>
            @else
                <div class="col-md-7">
                    <div class="alert alert-info">
                        <a href="{{ route('login') }}">Sign in</a> to send reply in this topic.
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
