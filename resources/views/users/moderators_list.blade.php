@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="mb-3">Moderators</h3>

        <table class="table table-borderless">
            <thead class="thead-dark">
            <tr>
                <th class="col-1">#</th>
                <th class="col-2">Category</th>
                <th class="col-3">Username</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($categories as $category)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>
                        <a href="{{ route('categories.show', $category) }}">{{ $category->name }}</a>
                    </td>
                    <td>
                        @foreach($category->users as $user)
                            <div class="row mb-2">
                                <div class="col-md-8">
                                    <a href="{{ route('users.show', $user) }}">
                                        {{$user->name}}
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <form class="form-inline"
                                          action="{{ route('moderators.destroy', [$user, $category]) }}"
                                          method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-sm btn-block btn-outline-danger confirm-delete"
                                                type="submit">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $categories->links() }}
    </div>
@endsection
