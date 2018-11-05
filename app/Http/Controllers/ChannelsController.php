<?php

namespace App\Http\Controllers;

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

        $channel = Channel::find(request('channel'))->first();

        return view('channels.show', compact('topics', 'channel'));
    }

    public function create()
    {
        return view('channels.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:32|unique:channels',
            'description' => 'nullable|min:8|max:128'
        ]);

        Channel::create($request->only(['name', 'description']));

        return redirect()->route('home');
    }

    public function edit(Channel $channel)
    {
        return view('channels.edit', compact('channel'));
    }

    public function update(Request $request, Channel $channel)
    {
        $request->validate([
            'name' => 'required|min:2|max:32|unique:channels,name,' . $channel->id,
            'description' => 'nullable|min:8|max:128'
        ]);

        $channel->update($request->only(['name', 'description']));

        return redirect()->route('home');
    }

    public function destroy(Channel $channel)
    {
        $this->authorize('delete', $channel);

        $channel->delete();

        return redirect()->route('home');
    }
}
