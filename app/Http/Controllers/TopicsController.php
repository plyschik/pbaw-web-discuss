<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Topic;
use App\Channel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        return view('topics.create', compact('channels'));
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
        $topic = (new Topic)
            ->select(['user_id', 'channel_id', 'title', 'content', 'created_at'])
            ->with(['user:id,name', 'channel:id,name'])
            ->findOrFail($id);

        $replies = (new Reply)
            ->select(['id', 'user_id', 'content', 'created_at'])
            ->with('user:id,name')
            ->where('topic_id', $id)
            ->paginate(3);

        return view('topics.show', compact('topic', 'replies'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
