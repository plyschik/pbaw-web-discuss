@extends('layouts.app')

@section('content')
    <h3 class="mb-3">Report reply</h3>

    <form action="{{ route('report.store', $reply) }}" method="POST">
        <div class="form-group">
            <label for="reason">Reason:</label>
            <textarea class="form-control" id="reason" name="reason"></textarea>
        </div>

        @csrf

        <button class="btn btn-primary" type="submit">Send report</button>
    </form>
@endsection
