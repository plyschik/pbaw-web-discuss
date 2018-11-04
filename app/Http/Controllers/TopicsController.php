<?php

namespace App\Http\Controllers;

use App\Topic;
use App\Reply;
use App\Channel;
use Illuminate\Http\Request;

class TopicsController extends Controller
{
    public function index()
    {
        $topics = (new Topic)
            ->select(['id', 'user_id', 'channel_id', 'title', 'content', 'created_at'])
            ->with(['user:id,name', 'channel:id,name'])
            ->paginate(10);
        return view('topics.index', compact('topics'));
    }

    public function create()
    {
        $channels = Channel::all();
        $currentChannel = Channel::where('name', request('channel'))->first();

        return view('topics.create', compact('channels', 'currentChannel'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'channel_id' => 'required|exists:channels,id',
            'title' => 'required|min:4|max:128',
            'content' => 'required|min:8|max:65535'
        ]);

        $topic = Topic::create([
            'user_id' => auth()->id(),
            'channel_id' => $request->get('channel_id'),
            'title' => $request->get('title'),
            'content' => $request->get('content')
        ]);

        return redirect()->route('topics.show', ['topic' => $topic->id]);
    }

    public function show($id)
    {
        $topic = Topic::findOrFail($id);

        $topic->addView();

        $replies = Reply::with(['user', 'replies.user'])
            ->where('topic_id', $id)
            ->whereNull('parent_id')
            ->paginate(5);

        return view('topics.show', compact('topic', 'replies'));
    }

    public function edit(Topic $topic)
    {
        $channels = Channel::all();

        return view('topics.edit', compact('topic', 'channels'));
    }

    public function update(Request $request, Topic $topic)
    {
        $this->validate($request, [
            'channel_id' => 'required|exists:channels,id',
            'title' => 'required|min:4|max:128',
            'content' => 'required|min:8|max:65535'
        ]);

        $topic->update([
            'user_id' => auth()->id(),
            'channel_id' => $request->get('channel_id'),
            'title' => $request->get('title'),
            'content' => $request->get('content')
        ]);

        return redirect()->route('topics.show', ['topic' => $topic->id]);
    }

    public function destroy(Topic $topic)
    {
        $topic->replies()->delete();
        $topic->delete();
        return redirect('/');
    }

    public function channel(Channel $channel)
    {
        $topics = $channel->topics()
            ->select(['id', 'user_id', 'channel_id', 'title', 'content', 'created_at'])
            ->with(['user:id,name', 'channel:id,name'])
            ->paginate(10);

        return view('topics.channel', [
            'channel' => $channel->name,
            'topics' => $topics
        ]);
    }
}
