@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="card mb-3">
                    <h5 class="card-header">
                        {{$topic->title}} ({{$topic->channel->name}})
                    </h5>
                    <div class="card-body">
                        {{ str_limit($topic->content, $limit = 150, $end = '...') }}
                    </div>
                    <div class="card-footer">
                        Added by <a href="#">{{$topic->user->name}}</a>, {{ $topic->created_at->diffForHumans()}}.
                    </div>
                </div>
            </div>

            @foreach($topic->replies as $reply)
                <div class="col-md-7">
                    <div class="card mb-3">
                        <div class="card-body">
                            {{ $reply->content }}
                        </div>
                        <div class="card-footer">
                            Posted by <a href="#">{{ $reply->user->name }}</a>, {{ $reply->created_at->diffForHumans()}}.
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
