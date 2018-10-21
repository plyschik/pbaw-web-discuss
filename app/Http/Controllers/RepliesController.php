<?php

namespace App\Http\Controllers;

use App\Topic;
use App\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RepliesController extends Controller
{
    public function store(Topic $topic, Request $request)
    {
        $this->validate($request, [
            'reply' => 'required'
        ]);

        $reply = Reply::create([
            'user_id' => auth()->id(),
            'topic_id' => $topic->id,
            'content' => $request->get('reply')
        ]);

        Auth::user()->replies()->save($reply);

        return redirect()->route('topics.show', ['id' => $topic->id]);
    }

    public function edit(Reply $reply)
    {
        return view('replies.edit', compact('reply'));
    }

    public function update(Request $request, Reply $reply)
    {
        $request->validate([
            'content' => 'required'
        ]);

        $reply->update(request(['content']));
        return redirect()->route('topics.show', ['id' => $reply->topic->id]);
    }
}
