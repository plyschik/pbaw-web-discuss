<?php

namespace App\Http\Controllers;

use App\Topic;
use App\Forum;
use Illuminate\Http\Request;

class ForumsController extends Controller
{
    public function show(Forum $forum)
    {
        $topics = Topic::with(['user', 'lastReply'])
            ->withCount('replies')
            ->where('forum_id', $forum->id)
            ->latest('created_at')
            ->get()
            ->sortByDesc('lastReply.created_at')
            ->paginate(4);

        return view('forums.show', compact('topics', 'forum'));
    }

    public function create()
    {
        return view('forums.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:32|unique:channels',
            'description' => 'nullable|min:8|max:128',
            'category_id' => 'required|exists:categories,id',
        ]);

        $channel = Forum::create($request->only(['name', 'description', 'category_id']));

        flash('Channel created.')->success();

        return redirect()->route('forums.show', $channel);
    }

    public function edit(Forum $forum)
    {
        return view('forums.edit', compact('forum'));
    }

    public function update(Request $request, Forum $forum)
    {
        $request->validate([
            'name' => 'required|min:2|max:32|unique:forums,name,' . $forum->id,
            'description' => 'nullable|min:8|max:128',
            'category_id' => 'required|exists:categories,id'
        ]);

        $forum->update($request->only(['name', 'description', 'category_id']));

        flash('Channel updated.')->success();

        return redirect()->route('forums.show', $forum);
    }

    public function destroy(Forum $forum)
    {
        $this->authorize('delete', $forum);

        $forum->delete();

        flash('Channel deleted.')->success();

        return redirect()->route('home');
    }
}