@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h3 class="mb-3">Moderators</h3>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Category</th>
                        <th scope="col">Username</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td><a href="{{ route('categories.show', $category) }}">{{ $category->name }}</a>
                            </td>
                            <td>
                                @foreach($category->users as $user)
                                    <div class="row mb-3">
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
                                                <button class="btn btn-sm btn-outline-danger confirm-delete"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="Delete moderator."
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
            </div>
        </div>
        {{ $categories->links() }}
    </div>
@endsection
