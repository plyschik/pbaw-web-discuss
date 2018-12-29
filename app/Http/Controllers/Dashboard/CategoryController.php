<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(5);

        return view('dashboard.category.index', compact('categories'));
    }

    public function create()
    {
        return view('dashboard.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:30|unique:categories'
        ]);

        Category::create($request->only(['name']));

        flash('Category created.')->success();

        return redirect()->route('dashboard.categories.index');
    }

    public function edit(Category $category)
    {
        return view('dashboard.category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|min:2|max:30|unique:categories,name,' . $category->id
        ]);

        $category->update($request->only(['name']));

        flash('Category updated.')->success();

        return redirect()->route('dashboard.categories.index');
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);

        $category->delete();

        flash('Category deleted.')->success();

        return redirect()->route('dashboard.categories.index');
    }
}