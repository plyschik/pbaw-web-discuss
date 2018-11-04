<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Reply;
use App\Topic;
use App\User;
use Carbon\Carbon;
use CyrildeWit\EloquentViewable\ViewTracker;

class ChannelsController extends Controller
{
    public function index()
    {
        $channels = Channel::with('lastReplies')
            ->withCount(['topics', 'replies'])
            ->orderBy('name')
            ->get();

        $numberOfReplies = Reply::all()->count();
        $todayReplies = Reply::whereDate('created_at', Carbon::today())->count();
        $totalTopicsViews = ViewTracker::getViewsCountByType(Topic::class);
        $numberOfTopics = Topic::all()->count();
        $averageTopicViews = number_format($totalTopicsViews / $numberOfTopics, 2);
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

        return view('channels.index', compact(
            'channels',
            'numberOfReplies',
            'numberOfTopics',
            'averageAge',
            'lastRegistered',
            'lastLoggedIn',
            'todayReplies',
            'totalTopicsViews',
            'averageTopicViews',
            'todayTopics',
            'mostReplies'
        ));
    }

    public function show($id)
    {
        $topics = Topic::with(['user', 'lastReply'])
            ->withCount('replies')
            ->where('channel_id', $id)
            ->latest('created_at')
            ->get()
            ->sortByDesc('lastReply.created_at')
            ->paginate(4);

        $channel = Channel::find(request('channel'));

        return view('channels.show', compact('topics', 'channel'));
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
