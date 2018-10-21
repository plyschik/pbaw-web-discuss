@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="card mb-3">
                    <h5 class="card-header">
                        <a href="{{ route('topics.show', ['topic' => $topic->id]) }}">{{$topic->title}}</a>
                        -
                        <a href="#">{{$topic->channel->name}}</a> - {{ $topic->created_at->diffForHumans()}}
                        by <a href="#">{{$topic->user->name}}</a>
                    </h5>
                    <div class="card-body">
                        {{ str_limit($topic->content, $limit = 150, $end = '...') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
