@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-7 ml-5">
            @foreach($topics as $topic)
                <div class="card mb-3">
                    <h5 class="card-header">
                        <a href="#">{{$topic->title}}</a>
                        -
                        <a href="#">{{$topic->channel->name}}</a> - {{ $topic->created_at->diffForHumans()}}
                        by <a href="#">{{$topic->user->name}}</a>
                    </h5>
                    <div class="card-body">
                        {{ str_limit($topic->content, $limit = 150, $end = '...') }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="mx-auto pagination" style="width: 0px;">
        {{ $topics->links() }}
    </div>

@endsection
