@extends('layouts.forum')

@section('content')
    <h3 class="mb-3">Edit topic</h3>

    <form action="{{ route('topics.update', $topic->id) }}" method="POST">
        @method('PATCH')

        <div class="form-group">
            <label for="forum">Forum:</label>
            <select class="form-control{{ $errors->has('forum_id') ? ' is-invalid' : '' }}" id="forum" name="forum_id">
                @foreach ($forums as $forum)
                    <option value="{{ $forum->id }}" {{ ($topic->forum->id == $forum->id) ? 'selected' : '' }}>{{ $forum->name }}</option>
                @endforeach
            </select>
            @if ($errors->has('forum_id'))
                <div class="invalid-feedback">{{ $errors->first('forum_id') }}</div>
            @endif
        </div>

        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{$topic->title}}" id="title" name="title">
            @if ($errors->has('title'))
                <div class="invalid-feedback">{{ $errors->first('title') }}</div>
            @endif
        </div>

        @csrf

        <div class="form-group">
            <button class="btn btn-primary mr-2" type="submit">Update</button> or <a class="btn btn-secondary ml-2" href="{{ url()->previous() }}">Go back</a>
        </div>
    </form>
@endsection
