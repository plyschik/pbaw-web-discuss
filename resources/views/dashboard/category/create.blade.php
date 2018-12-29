@extends('dashboard.layout')

@section('content')
    <h3 class="mb-3">Create category</h3>

    <form action="{{ route('dashboard.categories.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Name:</label>
            <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" type="text" name="name" value="{{ old('name') }}">
            @if ($errors->has('name'))
                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
            @endif
        </div>

        <div class="form-group">
            <button class="btn btn-primary mr-2" type="submit">Create category</button> or <a class="btn btn-secondary ml-2" href="{{ route('dashboard.categories.index') }}">Go back</a>
        </div>
    </form>
@endsection