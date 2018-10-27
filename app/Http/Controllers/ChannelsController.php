<?php

namespace App\Http\Controllers;

use App\Channel;
use Illuminate\Http\Request;
use Illuminate\Database\DatabaseManager;

class ChannelsController extends Controller
{
    public function index(DatabaseManager $db)
    {
        $channels = $db->table('channels')
            ->select([
                'id',
                'name',
                $db->raw("(SELECT COUNT(topics.id) FROM topics WHERE topics.channel_id = channels.id) AS topics_count"),
                $db->raw("(SELECT COUNT(replies.id) FROM replies INNER JOIN topics ON replies.topic_id = topics.id WHERE topics.channel_id = channels.id) AS replies_count")
            ])
            ->get()
            ->keyBy('id');

        $channelsLastReplyTopicIds = $db->table('replies')
            ->select($db->raw("MAX(replies.id) AS channel_last_reply_topic_id"))
            ->join('topics', 'replies.topic_id', '=', 'topics.id')
            ->join('channels', 'topics.channel_id', '=', 'channels.id')
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

    public function show(Channel $channel)
    {
        $topics = $channel->topics()->paginate(3);

        return view('channels.show', compact('channel', 'topics'));
    }

    public function create()
    {
        return view('channels.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:32'
        ]);

        Channel::create([
            'name' => request('name'),
        ]);

        return redirect('/');
    }

    public function edit(Channel $channel)
    {
        return view('channels.edit', compact('channel'));
    }

    public function update(Request $request, Channel $channel)
    {
        $request->validate([
            'name' => 'required|max:32'
        ]);

        $channel->update(request(['name']));

        return redirect('/');
    }

    public function destroy(Channel $channel)
    {
        $channel->delete();
        return redirect('/');
    }
}
