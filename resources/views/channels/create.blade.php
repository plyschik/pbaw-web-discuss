@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-3">New channel</h2>

        <form action="{{ route('channels.store') }}" method="POST">
            <div class="form-group">
                <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Channel name...">
                @if ($errors->has('name'))
                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                @endif
            </div>

            <div class="form-group">
                <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" id="description" type="text" name="description" placeholder="Channel description...">{{ old('description') }}</textarea>
                @if ($errors->has('description'))
                    <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                @endif
            </div>

            <div class="form-group">
                <button class="btn btn-primary mr-2" type="submit">Add new channel</button> or <a class="btn btn-secondary ml-2" href="{{ route('home') }}">Go back</a>
            </div>

            {{ csrf_field() }}
        </form>
    </div>
@endsection
