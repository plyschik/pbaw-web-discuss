@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2>Topics from channel: {{ $channel }}</h2>

                @if (Auth::check())
                    <a class="btn btn-block btn-lg btn-primary mb-3" href="{{ route('topics.create') }}">New topic</a>
                @endif

                @foreach ($topics as $topic)
                    <div class="card mb-3">
                        <h5 class="card-header">
                            <a href="{{ route('topics.show', ['topic' => $topic->id]) }}">{{ $topic->title }}</a> ({{ $topic->channel->name }})
                        </h5>
                        <div class="card-body">
                            {{ str_limit($topic->content, 150, '...') }}
                        </div>
                        <div class="card-footer">
                            Added by <a href="#">{{ $topic->user->name }}</a>, <time title="{{ $topic->created_at }}">{{ $topic->created_at->diffForHumans() }}</time>.
                        </div>
                    </div>
                @endforeach

                {{ $topics->links() }}
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Channels
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach ($channels as $channel)
                            <a href="{{ route('topics.channel', ['channel' => $channel->id]) }}" class="list-group-item list-group-item-action">{{ $channel->name }} ({{ $channel->topics_count }})</a>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
