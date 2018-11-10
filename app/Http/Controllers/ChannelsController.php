<?php

namespace App\Http\Controllers;

use App\Category;
use App\Topic;
use App\Channel;
use Illuminate\Http\Request;

class ChannelsController extends Controller
{
    public function index()
    {
        $channels = Channel::with('lastReplies')
            ->withCount(['topics', 'replies'])
            ->orderBy('name')
            ->get();

        return view('channels.index', compact('channels'));
    }

    public function show(Channel $channel)
    {

        $topics = Topic::with(['user', 'lastReply'])
            ->withCount('replies')
            ->where('channel_id', $channel->id)
            ->latest('created_at')
            ->get()
            ->sortByDesc('lastReply.created_at')
            ->paginate(4);

        return view('channels.show', compact('topics', 'channel'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('channels.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:32|unique:channels',
            'description' => 'nullable|min:8|max:128',
            'category_id' => 'required|exists:categories,id',
        ]);

        $channel = Channel::create($request->only(['name', 'description', 'category_id']));
        $category = $channel->category;
        flash('Channel created.')->success();
        return redirect()->route('categories.show', $category);
    }

    public function edit(Channel $channel)
    {
        $categories = Category::all();
        return view('channels.edit', compact('channel', 'categories'));
    }

    public function update(Request $request, Channel $channel)
    {
        $request->validate([
            'name' => 'required|min:2|max:32|unique:channels,name,' . $channel->id,
            'description' => 'nullable|min:8|max:128',
            'category_id' => 'required|exists:categories,id'
        ]);

        $channel->update($request->only(['name', 'description', 'category_id']));

        flash('Channel updated.')->success();

        return redirect()->route('home');
    }

    public function destroy(Channel $channel)
    {
        $this->authorize('delete', $channel);
        $channel->delete();

        flash('Channel deleted.')->success();

        return redirect()->back();

    }
}
