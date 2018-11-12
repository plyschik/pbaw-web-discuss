@extends('layouts.app')

@section('content')
    <h2 class="mb-3">Category: {{ $category->name }}</h2>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
        </ol>
    </nav>

    @if ($channels->isEmpty())
        <div class="alert alert-primary mb-0" role="alert">
            There are no channels in this category.
        </div>
    @else
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th class="col-6">Channel</th>
                    <th class="col-1 text-center">Topics</th>
                    <th class="col-1 text-center">Replies</th>
                    <th class="col-4">Last reply</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($channels as $channel)
                    <tr>
                        <td class="align-middle">
                            <a href="{{ route('channels.show', $channel) }}">{{ $channel->name }}</a>
                            <div class="small text-muted">
                                {{ $channel->description }}
                            </div>
                        </td>
                        <td class="text-center align-middle">{{ $channel->topics_count }}</td>
                        <td class="text-center align-middle">{{ $channel->replies_count > 0 ? --$channel->replies_count : 0 }}</td>
                        <td class="small align-middle">
                            @if ($channel->lastReplies->isEmpty())
                                ---
                            @else
                                <div class="d-block">
                                    <a href="{{ route('topics.show', ['topic' => $channel->lastReplies->first()['topic']['id']]) }}">{{ $channel->lastReplies->first()['topic']['title'] }}</a>
                                </div>
                                <div class="d-block">
                                    Author: <a href="{{ route('users.show', ['user' => $channel->lastReplies->first()['user']['id']]) }}">{{ $channel->lastReplies->first()['user']['name'] }}</a>
                                </div>
                                <div class="d-block">
                                    <div class="text-muted">
                                        {{ $channel->lastReplies->first()['created_at'] }}
                                    </div>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
