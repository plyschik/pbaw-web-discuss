@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-7 mx-auto">
                <div class="card mb-3">
                    <h5 class="card-header">
                        Reported posts
                    </h5>
                    <div class="card-body">
                        @if(count($reports)>0)
                            <table class="table table-responsive table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Reason</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Reported by</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($reports as $report)
                                    <tr>
                                        <th scope="row">{{$report->id}}</th>
                                        <td>{{$report->reason}}</td>
                                        <td>{{$report->created_at}}</td>
                                        <td>{{$report->user->name}}</td>
                                        <td>
                                            <a href="{{ route('topics.show', $report->topic)}}"
                                               class="btn btn-sm btn-block btn-outline-info">Show post</a>
                                        </td>
                                        <td>
                                            <form action="{{ route('reports.destroy', $report)}}" class="form-inline"
                                                  method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-sm btn-block btn-outline-danger" type="submit">
                                                    Delete report
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-primary" role="alert">
                                There are no reported posts at the moment.
                            </div>
                        @endif
                    </div>
                </div>
                {{ $reports->links() }}
            </div>
        </div>
    </div>
@endsection
