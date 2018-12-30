@extends('layouts.app')

@section('content')
    <div class="mb-3">
        <h2>
            Forum: {{ $forum->name }}
        </h2>
        @if ($forum->description)
            <div class="font-italic">
                {{ $forum->description }}
            </div>
        @endif
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $forum->name }}</li>
        </ol>
    </nav>

    @auth
        <a class="btn btn-block btn-lg btn-primary mb-3" href="{{ route('topics.create', $forum->id) }}">New topic</a>
    @endauth

    @if ($topics->isEmpty())
        <div class="alert alert-info">
            This forum is empty.
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
                            <a class="d-block" href="{{ route('topics.show', $topic) }}">{{ $topic->title }}</a>
                            <small>Author: <a href="{{ route('users.show', $topic->user) }}">{{ $topic->user->name }}</a>, {{ $topic->created_at }}</small>
                        </td>
                        <td class="text-center align-middle">{{ --$topic->replies_count }}</td>
                        <td class="text-center align-middle">{{ $topic->getUniqueViews() }}</td>
                        <td class="small align-middle">
                            @if ($topic->replies_count == 0)
                                —
                            @else
                                <time title="{{ $topic->lastReply->created_at }}">{{ $topic->lastReply->created_at->diffForHumans() }}</time>
                                <br>
                                Author: <a href="{{ route('users.show', $topic->lastReply->user) }}">{{ $topic->lastReply->user->name }}</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $topics->links() }}
    @endif
@endsection
