@extends('layouts.dashboard')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3>Forums management</h3>
        </div>
        <div>
            <a class="btn btn-success" href="{{ route('dashboard.forums.create') }}">Create new forum</a>
        </div>
    </div>

    @foreach ($categories as $category)
        <div class="card mb-3">
            <div class="card-header">
                {{ $category->name }}
            </div>
            <div class="card-body">
                @if ($category->forums->isEmpty())
                    No forums.
                @else
                    <table class="table mb-0">
                        <thead class="thead-light">
                            <th class="table-col-1">ID</th>
                            <th class="table-col-5">Name</th>
                            <th class="table-col-3">Created at</th>
                            <th class="table-col-3"></th>
                        </thead>
                        <tbody>
                            @foreach ($category->forums as $forum)
                                <tr>
                                    <td class="align-middle">{{ $forum->id }}</td>
                                    <td class="align-middle">{{ $forum->name }}</td>
                                    <td class="align-middle">{{ $forum->created_at }}</td>
                                    <td class="align-middle">
                                        <div class="d-flex justify-content-between">
                                            <div style="flex: 1;">
                                                <a class="btn btn-sm btn-block btn-primary mr-1" href="{{ route('dashboard.forums.edit', $forum->id) }}">Edit</a>
                                            </div>
                                            <div style="flex: 1;">
                                                <form class="form-inline" action="{{ route('dashboard.forums.destroy', $forum->id) }}" method="POST">
                                                    @method('DELETE')
                                                    @csrf

                                                    <button class="btn btn-sm btn-block btn-danger ml-1 confirm-delete" type="submit">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    @endforeach

    {{ $categories->links() }}
@endsection