<?php

namespace App\Http\Controllers;

use App\Topic;
use App\Reply;
use App\Report;
use App\Forum;
use Illuminate\Http\Request;

class TopicsController extends Controller
{
    public function create(Forum $forum)
    {
        return view('topics.create', compact('forum'));
    }

    public function store(Request $request, Forum $channel)
    {
        $this->validate($request, [
            'title' => 'required|min:4|max:128',
            'content' => 'required|min:8|max:65535'
        ]);

        $topic = $channel->topics()->create([
            'user_id' => auth()->id(),
            'title' => $request->get('title')
        ]);

        $topic->replies()->create([
            'user_id' => auth()->id(),
            'is_topic' => true,
            'content' => $request->get('content')
        ]);

        return redirect()->route('topics.show', ['topic' => $topic]);
    }

    public function show(Topic $topic)
    {
        $topic->addView();

        $replies = Reply::with([
                'user' => function ($query) {
                    $query->withCount('replies');
                },
                'user.roles',
                'replies.user' => function ($query) {
                    $query->withCount('replies');
                },
                'replies.user.roles'
            ])
            ->where([
                ['topic_id', $topic->id],
                ['parent_id', null]
            ])
            ->orderBy('created_at')
            ->paginate(3);

        return view('forum.topics.show', compact('topic', 'replies'));
    }

    public function edit(Topic $topic)
    {
        $forums = Forum::all();

        return view('forum.topics.edit', compact('topic', 'forums'));
    }

    public function update(Request $request, Topic $topic)
    {
        $this->validate($request, [
            'forum_id' => 'required|exists:forums,id',
            'title' => 'required|min:4|max:128'
        ]);

        $topic->update([
            'user_id' => auth()->id(),
            'forum_id' => $request->get('forum_id'),
            'title' => $request->get('title')
        ]);

        return redirect()->route('topics.show', ['topic' => $topic]);
    }

    public function destroy(Topic $topic)
    {
        $repliesId = $topic->replies()->pluck('id');
        Report::with('reply')->whereIn('reply_id', $repliesId)->delete();
        $topic->replies()->delete();
        $topic->delete();

        return redirect()->route('forums.show', $topic->forum)
            ->with('success', 'Topic deleted.');
    }
}
