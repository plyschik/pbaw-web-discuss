@extends('dashboard.layout')

@section('content')
    <div class="row mb-3">
        <div class="col-9">
            <h3>Categories management</h3>
        </div>
        <div class="col-3">
            <a class="btn btn-success btn-block" href="{{ route('dashboard.categories.create') }}">Create category</a>
        </div>
    </div>

    <table class="table">
        <thead class="thead-light">
            <th>ID</th>
            <th>Name</th>
            <th>Created at</th>
            <th></th>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->created_at }}</td>
                    <td>
                        <div class="row">
                            <div class="col">
                                <a class="btn btn-block btn-primary" href="{{ route('dashboard.categories.edit', $category) }}">Edit</a>
                            </div>
                            <div class="col">
                                <form class="form-inline" action="{{ route('dashboard.categories.destroy', $category) }}" method="POST">
                                    @method('DELETE')
                                    @csrf

                                    <button class="btn btn-block btn-danger confirm-delete" type="submit">Delete</button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $categories->links() }}
@endsection