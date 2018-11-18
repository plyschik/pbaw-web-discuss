<?php

namespace App\Http\Controllers;

use App\User;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ModeratorController extends Controller
{
    public function list()
    {
        $categories = Category::with('users')->paginate(3);

        return view('users.moderators_list', compact('categories'));
    }

    public function create(Category $category)
    {
        $users = User::whereDoesntHave('categories', function ($query) use ($category) {
            $query->where('id', $category);
        })->get(['id', 'name']);

        return view('users.create_moderator', compact('category', 'users'));
    }

    public function store(Request $request, Category $category)
    {
        $this->validate($request, [
            'user_id' => [
                'required',
                Rule::unique('category_user')->where(function ($query) use ($category) {
                    return $query->where('category_id', $category);
                })
            ]
        ]);

        $user = User::find($request->user_id);
        $user->categories()->attach($category);

        return redirect()->route('home');
    }

    public function destroy(Category $category, User $user)
    {
        $user->categories()->detach($category);

        return redirect()->route('moderators.list');
    }
}
