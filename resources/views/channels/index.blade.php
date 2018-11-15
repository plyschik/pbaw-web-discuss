@extends('layouts.app')

@section('content')
    <h3 class="mb-3">Category: {{ $category->name }}</h3>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Homepage</a></li>
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
                    <th class="col-4">Last reply in topic</th>
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
                        <td class="text-center align-middle">{{ $channel->replies_count }}</td>
                        <td class="small align-middle">
                            @if ($channel->replies->isEmpty())
                                —
                            @else
                                <div class="d-block">
                                    <a href="{{ route('topics.show', $channel->replies->first()->topic) }}">{{ $channel->replies->first()->topic->title }}</a>
                                </div>
                                <div class="d-block">
                                    Author: <a href="{{ route('users.show', $channel->replies->first()->user) }}">{{ $channel->replies->first()->user->name }}</a>
                                </div>
                                <div class="d-block">
                                    <div class="text-muted">
                                        {{ $channel->replies->first()->created_at }}
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
