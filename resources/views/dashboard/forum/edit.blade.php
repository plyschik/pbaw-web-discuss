@extends('layouts.dashboard')

@section('content')
    <h2 class="mb-3">Edit forum</h2>

    <form action="{{ route('dashboard.forums.update', $forum) }}" method="POST">
        @method('PATCH')

        <div class="form-group">
            <label for="category">Category:</label>
            <select class="form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}" id="category" name="category_id">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ ($forum->category->id == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            @if ($errors->has('category_id'))
                <div class="invalid-feedback">{{ $errors->first('category_id') }}</div>
            @endif
        </div>

        <div class="form-group">
            <label for="name">Name:</label>
            <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" type="text" name="name" value="{{ old('name', $forum->name) }}">
            @if ($errors->has('name'))
                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
            @endif
        </div>

        <div class="form-group">
            <label for="description">Description (optional):</label>
            <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" id="description" type="text" name="description">{{ old('description', $forum->description) }}</textarea>
            @if ($errors->has('description'))
                <div class="invalid-feedback">{{ $errors->first('description') }}</div>
            @endif
        </div>

        @csrf

        <div class="form-group">
            <button class="btn btn-primary mr-2" type="submit">Update forum</button> or <a class="btn btn-secondary ml-2" href="{{ route('dashboard.forums.index') }}">Go back</a>
        </div>
    </form>
@endsection