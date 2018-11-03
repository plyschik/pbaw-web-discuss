<?php

namespace App\Http\Controllers;

use App\Charts\ActivityChart;
use App\Charts\AgeChart;
use App\Charts\ChannelChart;
use App\Reply;
use App\User;
use App\Channel;
use Carbon\Carbon;
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
                $query->where('user_id', $user->id);
            })
            ->orderBy('topics_count', 'desc')
            ->limit(5)
            ->get();

        $usersFrequentlyCommentedPosts = User::withCount('replies')
            ->whereHas('replies', function ($query) use ($user) {
                $query->where('user_id', '!=', $user->id)
                    ->whereHas('topic', function ($query) use ($user) {
                        $query->where('user_id', $user->id);
                    });
            })
            ->orderBy('replies_count', 'desc')
            ->limit(5)
            ->get();
        return view('users.show', compact('user', 'latestTopics', 'popularChannels', 'usersFrequentlyCommentedPosts'));
    }

    public function destroy(User $user)
    {
        $user->replies()->delete();
        $user->topics()->delete();
        $user->reports()->delete();
        $user->delete();
        return redirect('/');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before: 4 years ago'
        ]);

        $user->update([
            'name' => $request->get('name'),
            'date_of_birth' => $request->get('date_of_birth')
        ]);

        return redirect()->route('users.show', $user);
    }

    public function stats()
    {
        $channelChart = new ChannelChart();
        $ageChart = new AgeChart();
        $activityChart = new ActivityChart();

        $users = User::selectRaw("TIMESTAMPDIFF(YEAR, DATE(date_of_birth), current_date) AS age")
            ->get()
            ->groupBy('age')
            ->map(function ($item) {
                return collect($item)->count();
            });

        $channelPosts = Channel::withCount('topics')->groupBy('name')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item['name'] => $item['topics_count']];
            });

        $activity = Reply::get()
            ->sortBy(function ($date) {
                return Carbon::parse($date->created_at)->format('H');
            })
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('H');
            })
            ->map(function ($item) {
                return collect($item)->count();
            });

        $ageChart->labels($users->keys());
        $ageChart->dataset('Number of users', 'pie',
            $users->values())->color($this->get_random_colors($users->count()));

        $channelChart->labels($channelPosts->keys());
        $channelChart->dataset('Number of posts', 'pie',
            $channelPosts->values())->color($this->get_random_colors($channelPosts->count()));

        $activityChart->labels($activity->keys());
        $activityChart->displayLegend(0);
        $activityChart->options([
            'yAxis' => [
                'title' => [
                    'text' => ''
                ]
            ]
        ]);
        $activityChart->dataset('Number of replies', 'column',
            $activity->values())->color($this->rand_color());

        return view('users.stats', compact('ageChart', 'channelChart', 'activityChart'));
    }

    function rand_color()
    {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }

    function get_random_colors($counter)
    {
        $colors = [];
        for ($i = 0; $i < $counter; $i++) {
            array_push($colors, $this->rand_color());
        }
        return $colors;
    }
}
