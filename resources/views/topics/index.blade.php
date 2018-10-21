@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                @if (Auth::check())
                    <a class="btn btn-primary btn-lg mb-3" href="{{ route('topics.create') }}">New topic</a>
                @endif
                
                @foreach($topics as $topic)
                    <div class="card mb-3">
                        <h5 class="card-header">
                            <a href="#">{{ $topic->title }}</a> (<a href="#">{{ $topic->channel->name }}</a>)
                        </h5>
                        <div class="card-body">
                            {{ str_limit($topic->content, 150, '...') }}
                        </div>
                        <div class="card-footer">
                            Added by <a href="#">{{ $topic->user->name }}</a>, {{ $topic->created_at->diffForHumans() }}.
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="pagination">
            {{ $topics->links() }}
        </div>
    </div>
@endsection
