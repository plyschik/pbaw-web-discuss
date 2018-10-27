<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Topic;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function show(User $user)
    {
        $latestTopics = $user
            ->topics()
            ->limit(5)
            ->get();

        $popularChannels = Channel::withCount('topics')
            ->whereHas('topics', function ($query) use ($user) {
                $query
                    ->where('user_id', $user->id);
            })
            ->orderBy('topics_count', 'desc')
            ->limit(5)
            ->get();

        $usersFrequentlyCommentedPosts = User::withCount('replies')
            ->whereHas('replies', function ($query) use ($user) {
                $query
                    ->where('user_id', '!=', $user->id)
                    ->whereHas('topic', function ($query) use ($user) {
                        $query
                            ->where('user_id', $user->id);
                    });
            })
            ->orderBy('replies_count', 'desc')
            ->limit(5)
            ->get();

        return view('users.show', compact('user', 'latestTopics', 'popularChannels', 'usersFrequentlyCommentedPosts'));
    }
}
