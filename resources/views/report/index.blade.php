@extends('layouts.app')

@section('content')
    <h3 class="mb-3">Reports</h3>

    @if ($users->isEmpty())
        <div class="alert alert-primary mb-0" role="alert">
            There are no reported users at the moment.
        </div>
    @else
        <table class="table table-borderless">
            <thead class="thead-dark">
                <tr>
                    <th class="col-1">#</th>
                    <th class="col-3">Username</th>
                    <th class="col-2">Reports count</th>
                    <th class="col-2"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <th>{{ $loop->iteration }}</th>
                        <td>
                            <a href="{{ route('users.show', $user) }}">{{ $user->name }}</a>
                        </td>
                        <td>
                            {{ $user->reports_count }}
                        </td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-block btn-info" href="{{ route('report.show', $user) }}">Show details</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{ $users->links() }}
@endsection
