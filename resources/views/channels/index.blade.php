@extends('layouts.app')

@section('content')
    <div class="container">
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
                        <a class="d-block mb-2"
                           href="{{ route('channels.show', ['channel' => $channel->id]) }}">{{ $channel->name }}</a>
                        @hasrole('administrator')
                        <div class="row">
                            <div class="col-2">
                                <a class="btn btn-sm btn-outline-primary"
                                   href="{{ route('channels.edit', ['channel' => $channel->id]) }}">Edit channel</a>
                            </div>
                            @if ($channel->topics_count == 0)
                                <div class="col-2">
                                    <form class="form-inline"
                                          action="{{ route('channels.destroy', ['channel' => $channel->id]) }}"
                                          method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-sm btn-outline-danger" type="submit">Delete channel
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="col">
                                    <a class="btn btn-sm btn-outline-danger disabled" href="#">Delete channel</a>
                                </div>
                            @endif
                        </div>
                        @endhasrole
                    </td>
                    <td class="text-center align-middle">{{ $channel->topics_count }}</td>
                    <td class="text-center align-middle">{{ $channel->replies_count }}</td>
                    <td class="small align-middle">
                        @if ($channel->replies_count == 0)
                            ---
                        @else
                            <a href="{{ route('topics.show', ['topic' => $channel->topic->topic_id]) }}">{{ $channel->topic->topic_title }}</a>
                            <br/>
                            Author: <a
                                    href="{{ route('users.show', ['user' => $channel->topic->user_id]) }}">{{ $channel->topic->user_name }}</a>
                            <br/>
                            <small class="text-muted">{{ $channel->topic->topic_created_at }}</small>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
