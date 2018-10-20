@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-2 offset-md-5">
            <h1>Add channel</h1>

            <hr>

            <form method="post" action="{{ route('channels.update', $channel->id) }}" action="/channels">

                {{ method_field('PATCH') }}
                {{ csrf_field() }}

                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Name" id="name" name="name" value="{{$channel->name}}">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Edit</button>
                </div>

            </form>
        </div>
    </div>


@endsection
