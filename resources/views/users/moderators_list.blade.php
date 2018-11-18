@extends('layouts.app')

@section('content')
    <h3 class="mb-3">Moderators</h3>

    @foreach ($categories as $category)
        <div class="card mb-3">
            <div class="card-header">
                {{ $category->name }}
            </div>
            <ul class="list-group list-group-flush">
                @foreach ($category->users as $user)
                    <li class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col">
                                <a href="{{ route('users.show', $user) }}">
                                    {{ $user->name }}
                                </a>
                            </div>
                            <div class="col-2">
                                <form class="form-inline" action="{{ route('moderators.destroy', [$category, $user->id]) }}" method="POST">
                                    @method('DELETE')
                                    @csrf

                                    <button class="btn btn-sm btn-block btn-outline-danger confirm-delete" type="submit">
                                        <i class="far fa-trash-alt"></i> Dismiss moderator
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach

    {{ $categories->links() }}
@endsection
