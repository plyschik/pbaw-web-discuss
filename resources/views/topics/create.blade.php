@extends('layouts.app')

@section('content')
    <h3 class="mb-3">New topic</h3>

    <form action="{{ route('topics.store', $channel->id) }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" id="title" name="title">
            @if ($errors->has('title'))
                <div class="invalid-feedback">{{ $errors->first('title') }}</div>
            @endif
        </div>

        <div class="form-group">
            <label for="content">Content:</label>
            <textarea class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" id="content" name="content"></textarea>
            @if ($errors->has('content'))
                <div class="invalid-feedback">{{ $errors->first('content') }}</div>
            @endif
        </div>

        <div class="form-group">
            <button class="btn btn-primary mr-2" type="submit">Add new topic</button> or <a class="btn btn-secondary ml-2" href="{{ url()->previous() }}">Go back</a>
        </div>
    </form>
@endsection