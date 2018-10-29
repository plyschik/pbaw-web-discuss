@extends('layouts.app')

@section('content')
    <div class="container">
        @if (Auth::check())
            <a class="btn btn-block btn-lg btn-primary mb-3" href="{{ route('topics.create') }}">New topic</a>
        @endif

        @if ($topics->isEmpty())
            <div class="alert alert-info">
                This channel is empty.
                <a href="{{ route('home') }}">Go back.</a>
            </div>
        @else
            <table class="table table-bordered">
                <thead class="thead-dark">
                <tr>
                    <th>Topic</th>
                    <th class="col-1 text-center">Replies</th>
                    <th class="col-1 text-center">Views</th>
                    <th class="col-3">Last reply</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($topics as $topic)
                        <tr>
                            <td>
                                <a class="d-block" href="{{ route('topics.show', ['id' => $topic->id]) }}">{{ $topic->title }}</a>
                                <small>Author: <a href="{{ route('users.show', ['user' => $topic->user_id]) }}">{{ $topic->user_name }}</a>, {{ $topic->created_at }}</small>
                            </td>
                            <td class="text-center align-middle">{{ $topic->replies_count }}</td>
                            <td class="text-center align-middle">-</td>
                            <td class="small align-middle">
                                @if ($topic->replies_count == 0)
                                    ---
                                @else
                                    {{ $replies[$topic->id]->created_at }}
                                    <br>
                                    Author: <a href="{{ route('users.show', ['user' => $replies[$topic->id]->user_id]) }}">{{ $replies[$topic->id]->user_name }}</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $topics->links() }}
        @endif
    </div>
@endsection
