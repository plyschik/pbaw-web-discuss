@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-3">Reply edit</h2>
        <form action="{{ route('replies.update', $reply) }}" method="POST">
            @method('PATCH')

            <div class="form-group">
                <label for="content">Content:</label>
                <textarea class="form-control {{ $errors->has('content') ? ' is-invalid' : '' }}" id="content" name="content" rows="3">{{ old('content', $reply->content) }}</textarea>
                @if ($errors->has('content'))
                    <div class="invalid-feedback">{{ $errors->first('content') }}</div>
                @endif
            </div>

            @csrf

            <div class="form-group">
                <button class="btn btn-primary mr-2" type="submit">Update reply</button> or <a class="btn btn-secondary ml-2" href="{{ url()->previous() }}">Go back</a>
            </div>
        </form>
    </div>
@endsection
