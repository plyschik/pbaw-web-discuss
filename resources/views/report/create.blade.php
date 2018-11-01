@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('report.store', $reply) }}" method="POST">
            <div class="form-group">
                <label for="reason">Reason:</label>
                <textarea class="form-control" id="reason" name="reason"></textarea>
            </div>
            {{ csrf_field() }}
            <button class="btn btn-primary" type="submit">Send report</button>
        </form>
    </div>
@endsection
