@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mb-3">
            <div class="card-body text-justify">
                {{ $report->reply->content }}
            </div>
            <div class="card-footer">
                Posted by <a href="{{ route('users.show', ['user' => $report->reply->user->id]) }}">{{ $report->reply->user->name }}</a>, <time title="{{ $report->reply->created_at }}">{{ $report->reply->created_at->diffForHumans() }}</time>.
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                Report details
            </div>
            <div class="card-body">
                <blockquote class="blockquote mb-0">
                    <p class="mb-0">{{ $report->reason }}</p>
                    <footer class="blockquote-footer">
                        Reported by: <a href="{{ route('users.show', $report->user) }}">{{ $report->user->name }}</a>, {{ $report->created_at }}
                    </footer>
                </blockquote>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-2">
                        <form class="form-inline" action="{{ route('report.ignore', $report) }}" method="POST">
                            @csrf
                            <button class="btn btn-block btn-success" type="submit">Ignore report</button>
                        </form>
                    </div>
                    <div class="col-2">
                        <form class="form-inline" action="{{ route('replies.destroy', $report->reply->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-block btn-primary" type="submit">Delete reply</button>
                        </form>
                    </div>
                    <div class="col-2">
                        <a class="btn btn-block btn-danger" href="#">Ban user</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
