@extends('layouts.app')

@section('content')
    <div class="container">
            <div class="row">
                <div class="col-10 offset-md-1">
                    @if(!count($channels))
                        <div class="alert alert-primary mb-0" role="alert">
                            There are no channels in this category.
                        </div>
                    @else
                    <table class="table table-bordered">
                        <thead class="thead-light">
                        <tr>
                            <th class="col-7">Channel</th>
                            <th class="col-1 text-center">Topics</th>
                            <th class="col-1 text-center">Replies</th>
                            <th class="col-3">Last reply</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($channels as $channel)
                            <tr>
                                <td class="align-middle">
                                    <a href="{{ route('channels.show', $channel) }}">{{ $channel->name }}</a>
                                    <div class="small text-muted">
                                        {{ str_limit($channel->description, 50) }}
                                    </div>

                                    @hasrole('administrator')
                                    <div class="row mt-3">
                                        <div class="col-2">
                                            <a class="btn btn-sm btn-block btn-outline-primary"
                                               href="{{ route('channels.edit', $channel) }}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        </div>
                                        @if ($channel->topics_count == 0)
                                            <div class="col-2">
                                                <form class="form-inline"
                                                      action="{{ route('channels.destroy', $channel) }}"
                                                      method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button class="btn btn-sm btn-block btn-outline-danger confirm-delete"
                                                            type="submit">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <div class="col-2">
                                                <button class="btn btn-sm btn-block btn-outline-danger"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="You can only delete channel without topics."
                                                        disabled="disabled">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                    @endhasrole
                                </td>
                                <td class="text-center align-middle">{{ $channel->topics_count }}</td>
                                <td class="text-center align-middle">{{ $channel->replies_count>0 ? --$channel->replies_count : 0}}</td>
                                <td class="small align-middle">
                                    @if ($channel->lastReplies->isEmpty())
                                        ---
                                    @else
                                        <div class="d-block">
                                            <a href="{{ route('topics.show', ['topic' => $channel->lastReplies->first()['topic']['id']]) }}">{{ str_limit($channel->lastReplies->first()['topic']['title'], 20) }}</a>
                                        </div>
                                        <div class="d-block">
                                            Author: <a
                                                    href="{{ route('users.show', ['user' => $channel->lastReplies->first()['user']['id']]) }}">{{ $channel->lastReplies->first()['user']['name'] }}</a>
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
                </div>
            </div>
    </div>
@endsection
