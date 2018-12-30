<?php

namespace App\Http\Controllers\Dashboard;

use App\Forum;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ForumController extends Controller
{
    public function index()
    {
        $categories = Category::with('forums')
            ->latest()
            ->paginate(5);

        return view('dashboard.forum.index', compact('categories'));
    }

    public function create()
    {
        return view('dashboard.forum.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|min:2|max:32',
            'description' => 'nullable|min:8|max:128'
        ]);

        Forum::create($request->only(['category_id', 'name', 'description']));

        flash('Forum created.')->success();

        return redirect()->route('dashboard.forums.index');
    }

    public function edit(Forum $forum)
    {
        return view('dashboard.forum.edit', compact('category', 'forum'));
    }

    public function update(Request $request, Forum $forum)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|min:2|max:32',
            'description' => 'nullable|min:8|max:128'
        ]);

        $forum->update($request->only(['category_id', 'name', 'description']));

        flash('Forum updated.')->success();

        return redirect()->route('dashboard.forums.index');
    }

    public function destroy(Forum $forum)
    {
        $this->authorize('delete', $forum);

        $forum->delete();

        flash('Forum deleted.')->success();

        return redirect()->route('dashboard.forums.index');
    }
}