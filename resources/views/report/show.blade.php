@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row align-items-center mb-3">
            <div class="col">
                <h2>Reports for user: {{ $user->name }}</h2>
            </div>
            <div class="col-2">
                <a class="btn btn-block btn-danger" href="{{ route('ban.create', $user) }}">Ban user</a>
            </div>
        </div>

        @foreach ($reports as $report)
            <div class="card mb-3">
                <div class="card-header">
                    <b>Report reason:</b> {{ $report->reason }}
                    <div class="w-100 mb-1"></div>
                    <b>Reported by:</b> <a href="{{ route('users.show', $report->user) }}">{{ $report->user->name }}</a>, <time title="{{ $report->created_at }}">{{ $report->created_at->diffForHumans() }}</time>.
                </div>
                <div class="card-body text-justify">
                    {{ $report->reply->content }}
                </div>
                <div class="card-footer">
                    <div class="row align-items-center">
                        <div class="col">
                            Posted by <a href="{{ route('users.show', ['user' => $report->reply->user->id]) }}">{{ $report->reply->user->name }}</a>, <time title="{{ $report->reply->created_at }}">{{ $report->reply->created_at->diffForHumans() }}</time>.
                        </div>
                        <div class="col-2">
                            <form class="form-inline" action="{{ route('report.ignore', $report) }}" method="POST">
                                @csrf
                                <button class="btn btn-sm btn-block btn-success confirm-delete" type="submit">Ignore report</button>
                            </form>
                        </div>
                        <div class="col-2">
                            <form class="form-inline" action="{{ route('report.delete', $report) }}" method="POST">
                                @csrf
                                <button class="btn btn-sm btn-block btn-primary confirm-delete" type="submit">Delete reply</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        {{ $reports->links() }}
    </div>
@endsection
