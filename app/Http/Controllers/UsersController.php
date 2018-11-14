<?php

namespace App\Http\Controllers;

use App\User;
use App\Reply;
use App\Channel;
use App\Category;
use Carbon\Carbon;
use App\Charts\AgeChart;
use Illuminate\Http\Request;
use App\Charts\ChannelChart;
use App\Charts\ActivityChart;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function createModerator(Category $category)
    {
        $users = User::whereDoesntHave('categories', function ($query) use ($category) {
            $query->where('id', $category->id);
        })->get(['id', 'name']);

        return view('users.create_moderator', compact('users', 'category'));
    }

    public function storeModerator(Request $request)
    {
        $this->validate($request, [
            'user_id' => [
                'required',
                Rule::unique('category_user')->where(function ($query) use ($request) {
                    return $query->where('category_id', $request->category_id);
                })
            ],
            'category_id' => [
                'required',
                Rule::unique('category_user')->where(function ($query) use ($request) {
                    return $query->where('user_id', $request->user_id);
                })
            ]
        ]);

        $user = User::find($request['user_id']);
        $category = Category::find($request['category_id']);
        $user->categories()->attach($category);

        return redirect()->route('home');
    }

    public function show(User $user)
    {
        $latestTopics = $user
            ->topics()
            ->limit(5)
            ->get();

        $topChannels = Channel::withCount('topics')
            ->whereHas('topics', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->orderBy('topics_count', 'DESC')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'label' => $item['name'],
                    'value' => $item['topics_count'],
                    'url' => route('channels.show', $item['slug'])
                ];
            });

        $usersFrequentlyCommentedPosts = User::withCount('replies')
            ->whereHas('replies', function ($query) use ($user) {
                $query->where('user_id', '!=', $user->id)
                    ->whereHas('topic', function ($query) use ($user) {
                        $query->where('user_id', $user->id);
                    });
            })
            ->orderBy('replies_count', 'DESC')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'label' => $item['name'],
                    'value' => $item['replies_count'],
                    'url' => route('users.show', $item['id'])
                ];
            });

        return view('users.show', compact('user', 'latestTopics', 'topChannels', 'usersFrequentlyCommentedPosts'));
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

    public function destroyModerator(User $user, Category $category)
    {
        $user->categories()->detach($category);

        return redirect()->route('moderators.list');
    }

    public function listModerators()
    {
        $categories = Category::with('users')->get()->paginate(8);

        return view('users.moderators_list', compact('categories'));
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
            })->sortKeys();

        $channelTopics = Channel::withCount('topics')->groupBy('name')->limit(8)
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
        $ageChart->dataset('Number of users', 'line', $users->values());
        $ageChart->displayLegend(false);
        $ageChart->options([
            'yAxis' => [
                'title' => [
                    'text' => 'Number of users'
                ]
            ]
        ]);

        $channelChart->labels($channelTopics->keys());
        $channelChart->dataset('Number of topics', 'pie',
            $channelTopics->values())->color($this->get_random_colors($channelTopics->count()));
        $channelChart->options([
            'plotOptions' => [
                'pie' => [
                    'allowPointSelect' => true,
                    'cursor' => 'pointer',
                    'dataLabels' => [
                        'enabled' => false,
                    ],
                    'showInLegend' => true,
                ]
            ]
        ]);

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
