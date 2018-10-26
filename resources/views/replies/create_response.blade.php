@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="mb-3">Reply to: </h3>

        @if (Auth::check())
            <form action="{{ route('response.store', ['reply' => $reply->id]) }}" method="POST">
                <input type="hidden" name="topic_id" value="{{ $reply->topic->id }}">
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
        @endif
    </div>
@endsection
