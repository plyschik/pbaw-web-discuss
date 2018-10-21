<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopicsController extends Controller
{
    public function index()
    {
        $topics = Topic::latest()->paginate(10);

        return view('topics.index', compact('topics'));
    }

    public function create()
    {
        //
    }

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

    public function show($id)
    {
        $topic = Topic::with('replies')->findOrFail($id);

        return view('topics.show', compact('topic'));
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
