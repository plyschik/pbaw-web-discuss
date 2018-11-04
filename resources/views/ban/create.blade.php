@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-3">Ban for user: {{ $user->name }}</h2>
        <form action="{{ route('ban.store', $user) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="comment">Comment:</label>
                <textarea class="form-control{{ $errors->has('comment') ? ' is-invalid' : '' }}" id="comment" name="comment">{{ old('comment') }}</textarea>
                @if ($errors->has('comment'))
                    <div class="invalid-feedback">{{ $errors->first('comment') }}</div>
                @endif
            </div>
            <div class="form-group">
                <label for="period">Period:</label>
                <select class="form-control{{ $errors->has('period') ? ' is-invalid' : '' }}" id="period" name="period">
                    @foreach ([1, 3, 7, 14, 30, 60, 90] as $period)
                        <option value="{{ $period }}"{{ old('period') == $period ? ' selected' : '' }}>{{ $period }} {{ str_plural('day', $period) }}</option>
                    @endforeach
                </select>
                @if ($errors->has('period'))
                    <div class="invalid-feedback">{{ $errors->first('period') }}</div>
                @endif
            </div>
            <button class="btn btn-primary" type="submit">Confirm</button>
        </form>
    </div>
@endsection