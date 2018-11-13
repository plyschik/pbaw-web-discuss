@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="mb-3">New moderator</h3>

        <form action="{{ route('moderators.store') }}" method="POST">
            <div class="form-group">
                <label for="channel">User:</label>
                <select class="select2-user form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}" id="user" name="user_id">
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
                <select disabled class="categories form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}" id="channel" name="category_id">
                    <option>Select user first...</option>
                </select>
                @if ($errors->has('category_id'))
                    <div class="invalid-feedback">{{ $errors->first('category_id') }}</div>
                @endif
            </div>

            @csrf

            <div class="form-group">
                <button class="btn btn-primary mr-2" type="submit">Add new moderator</button> or <a class="btn btn-secondary ml-2" href="{{ route('home') }}">Go back</a>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    @parent

    <script>
        $(document).ready(function() {
            $('.select2-user').select2({
                theme: 'bootstrap4'
            });

            $('.select2-user').on('select2:select', function (event) {
                $('.categories').prop('disabled', true);
                $('.categories').find('option').remove();

                $.ajax({
                    method: 'GET',
                    url: `/api/users/${event.params.data.id}/categories`
                }).done(function (response) {
                    $.each(response, function (index, item) {
                        $('.categories').append(new Option(item.name, item.id));
                    });

                    $('.categories').prop('disabled', false);
                });
            });
        });
    </script>
@endsection