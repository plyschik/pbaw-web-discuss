@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <a class="btn btn-primary btn-lg mb-3" href="#">New topic</a>

                @foreach($topics as $topic)
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
                @endforeach
            </div>
        </div>

        <div class="mx-auto pagination" style="width: 0px;">
            {{ $topics->links() }}
        </div>
    </div>
@endsection
