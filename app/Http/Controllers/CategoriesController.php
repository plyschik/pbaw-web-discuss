<?php

namespace App\Http\Controllers;

use App\Category;
use App\Channel;
use App\Topic;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('categories.index', compact('categories', 'popularTopics', 'latestTopics'));
    }

    public function show(Category $category)
    {
        $channels = Channel::with('lastReplies', 'category')
            ->withCount(['topics', 'replies'])
            ->where('category_id', $category->id)
            ->orderBy('name')
            ->get();

        return view('channels.index', compact('channels'));
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
