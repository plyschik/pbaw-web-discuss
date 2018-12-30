<?php

namespace App\Http\Controllers;

use App\Forum;
use App\Topic;

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

        return view('forums.show', compact('forum','topics'));
    }
}