@extends('dashboard.layout')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3>Categories management</h3>
        </div>
        <div>
            <a class="btn btn-success" href="{{ route('dashboard.categories.create') }}">Create new category</a>
        </div>
    </div>

    <table class="table">
        <thead class="thead-light">
            <th class="col-1">ID</th>
            <th class="col-5">Name</th>
            <th class="col-3">Created at</th>
            <th class="col-3"></th>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td class="align-middle">{{ $category->id }}</td>
                    <td class="align-middle">{{ $category->name }}</td>
                    <td class="align-middle">{{ $category->created_at }}</td>
                    <td class="align-middle">
                        <div class="d-flex justify-content-between">
                            <div style="flex: 1;">
                                <a class="btn btn-sm btn-block btn-primary mr-1" href="{{ route('dashboard.categories.edit', $category) }}">Edit</a>
                            </div>
                            <div style="flex: 1;">
                                <form class="form-inline" action="{{ route('dashboard.categories.destroy', $category) }}" method="POST">
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

    {{ $categories->links() }}
@endsection