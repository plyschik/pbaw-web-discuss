<?php

namespace App\Http\Controllers;

use App\Channel;
use Illuminate\Http\Request;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\Gate;

class ChannelsController extends Controller
{
    public function index(DatabaseManager $db)
    {
        $channels = $db->table('channels')
            ->select([
                'id',
                'name',
                $db->raw("(SELECT COUNT(topics.id) FROM topics WHERE topics.deleted_at is null and topics.channel_id = channels.id) AS topics_count"),
                $db->raw("(SELECT COUNT(replies.id) FROM replies INNER JOIN topics ON replies.topic_id = topics.id WHERE replies.deleted_at is null and topics.deleted_at is null and topics.channel_id = channels.id) AS replies_count")
            ])
            ->get()
            ->keyBy('id');

        $channelsLastReplyTopicIds = $db->table('replies')
            ->select($db->raw("MAX(replies.id) AS channel_last_reply_topic_id"))
            ->join('topics', 'replies.topic_id', '=', 'topics.id')
            ->join('channels', 'topics.channel_id', '=', 'channels.id')
            ->join('users', 'topics.user_id', '=', 'users.id')
            ->whereNull('replies.deleted_at')
            ->whereNull('users.deleted_at')
            ->whereNull('topics.deleted_at')
            ->groupBy('channels.id')
            ->get()
            ->pluck('channel_last_reply_topic_id')
            ->toArray();

        $topics = $db->table('topics')
            ->select([
                'topics.channel_id AS channel_id',
                'topics.id AS topic_id',
                'topics.title AS topic_title',
                'topics.created_at AS topic_created_at',
                'users.id AS user_id',
                'users.name AS user_name',
            ])
            ->whereNull('topics.deleted_at')
            ->whereNull('replies.deleted_at')
            ->whereNull('users.deleted_at')
            ->join('replies', 'replies.topic_id', '=', 'topics.id')
            ->join('users', 'topics.user_id', '=', 'users.id')
            ->whereIn('replies.id', $channelsLastReplyTopicIds)
            ->orderBy('topics.channel_id')
            ->get()
            ->keyBy('channel_id');

        foreach ($channels as $index => $channel) {
            if (!isset($topics[$index])) {
                $channels[$index]->topic = [];
            } else {
                $channels[$index]->topic = $topics[$index];
            }
        }

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
