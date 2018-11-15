<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::with(['users', 'channels' => function ($query) {
            $query->withCount(['topics', 'replies' => function ($query) {
                $query->where('is_topic', 0);
            }])->with(['replies' => function ($query) {
                $query->with(['topic', 'user'])->latest();
            }]);
        }])->get();

        return view('categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        $channels = Channel::with('lastReplies', 'category')
            ->withCount(['topics', 'replies'])
            ->where('category_id', $category->id)
            ->orderBy('name')
            ->get();

        return view('channels.index', compact('channels', 'category'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:32|unique:categories'
        ]);

        Category::create($request->only(['name']));

        flash('Category created.')->success();

        return redirect()->route('home');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|min:2|max:32|unique:categories,name,' . $category->id
        ]);

        $category->update($request->only(['name']));

        flash('Category updated.')->success();

        return redirect()->route('home');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        flash('Category deleted.')->success();

        return redirect()->route('home');
    }
}
