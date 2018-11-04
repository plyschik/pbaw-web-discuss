@extends('layouts.app')

@section('content')
    <div class="container">
        @if (Auth::check())
            <a class="btn btn-block btn-lg btn-primary mb-3" href="{{ route('topics.create', $channel) }}">New topic</a>
        @endif

        @if ($topics->isEmpty())
            <div class="alert alert-info">
                This channel is empty.
                <a href="{{ route('home') }}">Go back.</a>
            </div>
        @else
            <table class="table table-bordered">
                <thead class="thead-light">
                <tr>
                    <th class="col-7">Topic</th>
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
                                <small>Author: <a href="{{ route('users.show', ['user' => $topic->user->id]) }}">{{ $topic->user->name }}</a>, {{ $topic->created_at }}</small>
                            </td>
                            <td class="text-center align-middle">{{ $topic->replies_count }}</td>
                            <td class="text-center align-middle">{{ $topic->getUniqueViews() }}</td>
                            <td class="small align-middle">
                                @if ($topic->replies_count == 0)
                                    ---
                                @else
                                    {{ $topic->lastReply->created_at }}
                                    <br>
                                    Author: <a href="{{ route('users.show', ['user' => $topic->lastReply->user->id]) }}">{{ $topic->lastReply->user->name }}</a>
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
