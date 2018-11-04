@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-3">Edit channel</h2>

        <form action="{{ route('channels.update', ['channel' => $channel]) }}" method="POST">
            @method('PATCH')

            <div class="form-group">
                <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" type="text" name="name" value="{{ old('name', $channel->name) }}" placeholder="Channel name...">
                @if ($errors->has('name'))
                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                @endif
            </div>

            <div class="form-group">
                <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" id="description" type="text" name="description" placeholder="Channel description...">{{ old('description', $channel->description) }}</textarea>
                @if ($errors->has('description'))
                    <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                @endif
            </div>

            <div class="form-group">
                <button class="btn btn-primary mr-2" type="submit">Update channel</button> or <a class="btn btn-secondary ml-2" href="{{ route('home') }}">Go back</a>
            </div>

            {{ csrf_field() }}
        </form>
    </div>
@endsection
