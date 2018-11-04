<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Reply;
use App\Topic;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\DatabaseManager;

class ChannelsController extends Controller
{
    public function index()
    {
        $channels = Channel::with('lastReplies')
            ->withCount(['topics', 'replies'])
            ->get();

        $numberOfReplies = Reply::all()->count();
        $todayReplies = Reply::whereDate('created_at', Carbon::today())->count();
        $numberOfTopics = Topic::all()->count();
        $todayTopics = Topic::whereDate('created_at', Carbon::today())->count();
        $averageAge = round(User::selectRaw("TIMESTAMPDIFF(YEAR, DATE(date_of_birth), current_date) AS age")->get()->avg('age'));
        $lastRegistered = User::orderBy('id', 'desc')->first();
        $lastLoggedIn = User::orderBy('last_logged_in', 'desc')->first();
        $replies = Reply::select('created_at')
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('d-m-Y');
            })->sort();

        $mostReplies = [
            'date' => $replies->keys()->last(),
            'numberOfReplies' => $replies->last()->count()
        ];

        return view('channels.index',
            compact('channels', 'numberOfReplies', 'numberOfTopics', 'averageAge', 'lastRegistered',
                'lastLoggedIn', 'todayReplies', 'todayTopics', 'mostReplies'));
    }

    public function show($id, DatabaseManager $db)
    {
        $topics = Topic::with('latestReply')
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
            ->get()
            ->sortByDesc('latestReply.created_at')
            ->paginate(4);;

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
