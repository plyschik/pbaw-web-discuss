<?php

namespace App\Http\Controllers;

use App\Topic;
use App\Reply;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function store(Topic $topic, Request $request)
    {
        $this->validate($request, [
            'reply' => 'required|min:4|max:65535'
        ]);

        Reply::create([
            'user_id' => auth()->id(),
            'topic_id' => $topic->id,
            'content' => $request->get('reply'),
        ]);

        return redirect()->route('topics.show', $topic);
    }

    public function edit(Reply $reply)
    {
        return view('replies.edit', compact('reply'));
    }

    public function update(Request $request, Reply $reply)
    {
        $request->validate([
            'content' => 'required|min:4|max:65535'
        ]);

        $reply->update($request->only(['content']));

        return redirect()->route('topics.show', $reply->topic);
    }

    public function destroy(Reply $reply)
    {
        $reply->reports()->delete();
        $reply->replies()->delete();
        $reply->delete();

        return redirect()->route('topics.show', $reply->topic);
    }

    public function createResponse(Reply $reply)
    {
        return view('replies.create_response', compact('reply'));
    }

    public function storeResponse(Reply $reply, Request $request)
    {
        $this->validate($request, [
            'reply' => 'required|min:4|max:65535'
        ]);

        Reply::create([
            'user_id' => auth()->id(),
            'topic_id' => $reply->topic->id,
            'parent_id' => $reply->id,
            'content' => $request->get('reply')
        ]);

        return redirect()->route('topics.show', $reply->topic);
    }
}
