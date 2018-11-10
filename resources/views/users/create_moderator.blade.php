@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="mb-3">New moderator</h3>

        <form action="{{ route('moderators.store') }}" method="POST">
            <div class="form-group">
                <label for="channel">User:</label>
                <select class="js-example-basic-single form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}" id="user" name="user_id">
                    @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ ($user->id == request('user_id')) ? 'selected' : ''  }}>{{ $user->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('user_id'))
                <div class="invalid-feedback">{{ $errors->first('user_id') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="channel">Category:</label>
                <select class="form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}" id="channel" name="category_id">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ ($category->id == request('category_id')) ? 'selected' : ''  }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('category_id'))
                    <div class="invalid-feedback">{{ $errors->first('category_id') }}</div>
                @endif
            </div>

            @csrf

            <div class="form-group">
                <button class="btn btn-primary mr-2" type="submit">Add new moderator</button> or <a class="btn btn-secondary ml-2" href="{{ url()->previous() }}">Go back</a>
            </div>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>

@endsection
