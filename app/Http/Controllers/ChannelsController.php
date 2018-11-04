<?php

namespace App\Http\Controllers;

use App\Channel;
use Illuminate\Http\Request;
use Illuminate\Database\DatabaseManager;

class ChannelsController extends Controller
{
    public function index()
    {
        $channels = Channel::with('lastReplies')
            ->withCount(['topics', 'replies'])
            ->get();

        return view('channels.index', compact('channels'));
    }

    public function show($id, DatabaseManager $db)
    {
        $topics = $db->table('topics')
            ->select([
                'topics.id AS id',
                'topics.title AS title',
                'topics.created_at AS created_at',
                'users.id AS user_id',
                'users.name AS user_name',
                $db->raw("(SELECT COUNT(replies.id) FROM replies WHERE replies.deleted_at is null and replies.topic_id = topics.id) AS replies_count")
            ])
            ->join('users', 'topics.user_id', '=', 'users.id')
            ->whereNull('users.deleted_at')
            ->whereNull('topics.deleted_at')
            ->where('channel_id', $id)
            ->paginate(4);

        $topicsLastReplyIds = $db->table('replies')
            ->select($db->raw("MAX(replies.id) AS topic_last_reply_id"))
            ->whereIn('replies.topic_id', array_column($topics->items(), 'id'))
            ->whereNull('replies.deleted_at')
            ->groupBy('replies.topic_id')
            ->get()
            ->pluck('topic_last_reply_id')
            ->toArray();

        $replies = $db->table('replies')
            ->select([
                'replies.topic_id',
                'replies.created_at',
                'users.id AS user_id',
                'users.name AS user_name'
            ])
            ->join('users', 'replies.user_id', '=', 'users.id')
            ->whereIn('replies.id', $topicsLastReplyIds)
            ->whereNull('replies.deleted_at')
            ->whereNull('users.deleted_at')
            ->whereNull('replies.deleted_at')
            ->get()
            ->keyBy('topic_id');

        return view('channels.show', compact('topics', 'replies'));
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
