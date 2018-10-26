@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2 class="mb-3">Topics from channel: {{ $channel->name }}</h2>

                @if (Auth::check())
                    <a class="btn btn-block btn-lg btn-primary mb-3" href="{{ route('topics.create') }}">New topic</a>
                @endif

                @foreach ($topics as $topic)
                    <div class="card mb-3">
                        <h5 class="card-header">
                            <a href="{{ route('topics.show', ['topic' => $topic->id]) }}">{{ $topic->title }}</a>
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
        </div>
    </div>
@endsection
