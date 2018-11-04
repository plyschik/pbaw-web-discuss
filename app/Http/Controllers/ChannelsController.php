<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function show($id)
    {
        $topics = Topic::with(['user', 'lastReply'])
            ->withCount('replies')
            ->where('channel_id', $id)
            ->latest('created_at')
            ->paginate(5);

        return view('channels.show', compact('topics'));
    }

    public function create()
    {
        return view('channels.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|alpha|min:2|max:32|unique:channels'
        ]);

        Channel::create([
            'name' => $request->get('name'),
        ]);

        return redirect()->route('home');
    }

    public function edit(Channel $channel)
    {
        return view('channels.edit', compact('channel'));
    }

    public function update(Request $request, Channel $channel)
    {
        $request->validate([
            'name' => 'required|alpha|min:2|max:32|unique:channels'
        ]);
        
        $channel->update([
            'name' => $request->get('name', $channel->name)
        ]);

        return redirect()->route('home');
    }

    public function destroy(Channel $channel)
    {
        $this->authorize('delete', $channel);
        $channel->topics()->delete();
        $channel->delete();

        return redirect()->route('home');
    }
}
