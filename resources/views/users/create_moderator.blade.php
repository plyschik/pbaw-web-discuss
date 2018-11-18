@extends('layouts.app')

@section('content')
    <h3 class="mb-3">New moderator to category: {{ $category->name }}</h3>

    <form action="{{ route('moderators.store', $category) }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="user">User:</label>
            <select class="select2-user form-control{{ $errors->has('user_id') ? ' is-invalid' : '' }}" id="user" name="user_id">
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ ($user->id == request('user_id')) ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
            @if ($errors->has('user_id'))
                <div class="invalid-feedback">{{ $errors->first('user_id') }}</div>
            @endif
        </div>

        <div class="form-group">
            <button class="btn btn-primary mr-2" type="submit">Add new moderator</button> or <a class="btn btn-secondary ml-2" href="{{ route('home') }}">Go back</a>
        </div>
    </form>
@endsection

@section('scripts')
    @parent

    <script>
        $(document).ready(function() {
            $('.select2-user').select2({
                theme: 'bootstrap4'
            });
        });
    </script>
@endsection