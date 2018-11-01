@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="mb-3">Reported posts</h3>

        @if (!count($reports))
            <div class="alert alert-primary mb-0" role="alert">
                There are no reported posts at the moment.
            </div>
        @else
            <table class="table table-borderless">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Reason</th>
                        <th>Date</th>
                        <th>Reported by</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reports as $report)
                        <tr>
                            <th>{{ $report->id }}</th>
                            <td>{{ $report->reason }}</td>
                            <td>
                                <time title="{{ $report->created_at }}">{{ $report->created_at->diffForHumans() }}</time>
                            </td>
                            <td>
                                <a target="_blank" href="{{ route('users.show', ['user' => $report->user]) }}">{{ $report->user->name }}</a>
                            </td>
                            <td class="text-center">
                                <a class="btn btn-sm btn-block btn-info" href="{{ route('report.show', $report) }}">Show details</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        {{ $reports->links() }}
    </div>
@endsection
