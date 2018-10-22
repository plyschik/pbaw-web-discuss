@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="mb-3">New topic</h3>

        <form action="{{ route('topics.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="channel">Channel:</label>
                <select class="form-control{{ $errors->has('channel_id') ? ' is-invalid' : '' }}" id="channel" name="channel_id">
                    @foreach ($channels as $channel)
                        <option value="{{ $channel->id }}">{{ $channel->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('channel_id'))
                    <div class="invalid-feedback">{{ $errors->first('channel_id') }}</div>
                @endif
            </div>

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

            <input class="btn btn-primary" type="submit" value="Add new topic">
        </form>
    </div>
@endsection
