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
                            <p class="mb-3">
                                <a class="mb-3" href="{{ route('channels.show', ['channel' => $channel->id]) }}">{{ $channel->name }}</a>
                            </p>

                            @hasrole('administrator')
                                <div class="row">
                                    <div class="col-2">
                                        <a class="btn btn-sm btn-block btn-outline-primary" href="{{ route('channels.edit', ['channel' => $channel->id]) }}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    </div>
                                    @if ($channel->topics_count == 0)
                                        <div class="col-2">
                                            <form class="form-inline" action="{{ route('channels.destroy', ['channel' => $channel->id]) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-sm btn-block btn-outline-danger" type="submit">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <div class="col-2">
                                            <button class="btn btn-sm btn-block btn-outline-danger" data-toggle="tooltip" data-placement="top" title="You can only delete channel without topics." disabled="disabled">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            @endhasrole
                        </td>
                        <td class="text-center align-middle">{{ $channel->topics_count }}</td>
                        <td class="text-center align-middle">{{ $channel->replies_count }}</td>
                        <td class="small align-middle">
                            @if ($channel->lastReplies->isEmpty())
                                ---
                            @else
                                <div class="d-block">
                                    <a href="{{ route('topics.show', ['topic' => $channel->lastReplies->first()['topic']['id']]) }}">{{ $channel->lastReplies->first()['topic']['title'] }}</a>
                                </div>
                                <div clas="d-block">
                                    Author: <a href="{{ route('users.show', ['user' => $channel->lastReplies->first()['user']['id']]) }}">{{ $channel->lastReplies->first()['user']['name'] }}</a>, {{ $channel->lastReplies->first()['created_at'] }}
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
