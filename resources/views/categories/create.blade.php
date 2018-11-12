@extends('layouts.app')

@section('content')
    <h2 class="mb-3">New category</h2>

    <form action="{{ route('categories.store') }}" method="POST">
        <div class="form-group">
            <label for="name">Name:</label>
            <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" type="text" name="name" value="{{ old('name') }}">
            @if ($errors->has('name'))
                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
            @endif
        </div>

        @csrf

        <div class="form-group">
            <button class="btn btn-primary mr-2" type="submit">Add new category</button> or <a class="btn btn-secondary ml-2" href="{{ route('home') }}">Go back</a>
        </div>
    </form>
@endsection
