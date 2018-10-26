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
        ;

        return view('channels.index', compact('channels'));
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
