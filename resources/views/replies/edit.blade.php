@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-5 offset-md-3">
                <form action="{{ route('replies.update', ['reply' => $reply->id]) }}" method="POST">
                    <div class="form-group">
                        <label for="reply">Reply editing</label>
                        <textarea class="form-control {{ $errors->has('content') ? ' is-invalid' : '' }}" id="content"
                                  name="content" rows="3">{{$reply->content}}</textarea>
                        @if ($errors->has('content'))
                            <div class="invalid-feedback">{{ $errors->first('content') }}</div>
                        @endif
                    </div>
                    <input type="submit" class="btn btn-primary" value="Edit reply">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}
                </form>
            </div>
        </div>
    </div>
@endsection
