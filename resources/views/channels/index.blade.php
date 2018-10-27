@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Channel</th>
                    <th class="col-1 text-center">Topics</th>
                    <th class="col-1 text-center">Replies</th>
                    <th class="col-5">Last reply</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($channels as $channel)
                    <tr>
                        <td class="align-middle">
                            <a href="{{ route('channels.show', ['channel' => $channel->id]) }}">{{ $channel->name }}</a>
                        </td>
                        <td class="text-center align-middle">{{ $channel->topics_count }}</td>
                        <td class="text-center align-middle">{{ $channel->replies_count }}</td>
                        <td class="small">
                            @if ($channel->topics_count == 0)
                                ---
                            @else
                                <a href="{{ route('topics.show', ['topic' => $channel->topic->topic_id]) }}">{{ $channel->topic->topic_title }}</a>
                                <br />
                                Author: <a href="#">{{ $channel->topic->user_name }}</a>
                                <br />
                                <small class="text-muted">{{ $channel->topic->topic_created_at }}</small>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
