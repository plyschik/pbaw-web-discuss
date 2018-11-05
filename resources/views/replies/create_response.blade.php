@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mb-3">
            <div class="card-body text-justify">
                {{ $reply->content }}
            </div>
            <div class="card-footer">
                Added by <a href="{{ route('users.show', $reply->user) }}">{{ $reply->user->name }}</a>, <time title="{{ $reply->created_at }}">{{ $reply->created_at->diffForHumans() }}</time>.
            </div>
        </div>
        <div class="card ml-5">
            <div class="card-header">
                Your reply
            </div>
            <div class="card-body">
                <form action="{{ route('response.store', $reply) }}" method="POST">
                    <div class="form-group">
                        <textarea class="form-control{{ $errors->has('reply') ? ' is-invalid' : '' }}" id="reply" name="reply" rows="3" required="required">{{ old('reply') }}</textarea>
                        @if ($errors->has('reply'))
                            <span class="invalid-feedback">{{ $errors->first('reply') }}</span>
                        @endif
                    </div>

                    @csrf

                    <button class="btn btn-primary mr-2" type="submit">Send reply</button> or <a class="btn btn-secondary ml-2" href="{{ route('topics.show', $reply->topic) }}">Go back</a>
                </form>
            </div>
        </div>
    </div>
@endsection
