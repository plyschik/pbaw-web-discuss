@extends('layouts.app')

@section('content')
    <div class="container">
        @if (Auth::check())
            <div class="row justify-content-md-center">
                <div class="col-md-6">
                    <form action="{{ route('reports.store', $topic) }}" method="POST">
                        <input type="hidden" name="topic_id" value="{{ $topic->id }}">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Reason:</label>
                            <select class="form-control" name="reason" id="exampleFormControlSelect1">
                                <option value="This is spam">This is spam</option>
                                <option value="This is abusive or harassing">This is abusive or harassing</option>
                                <option value="It breaks WebDiscuss rules">It breaks WebDiscuss rules</option>
                                <option value="Other issue">Other issue</option>
                            </select>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Report post">
                        {{ csrf_field() }}
                    </form>

                </div>
            </div>
        @endif
    </div>
@endsection
