<?php

namespace App\Http\Controllers;

use App\User;
use App\Topic;
use App\Reply;
use App\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $users = User::has('reports')->withCount('reports')->paginate(5);

        return view('report.index', compact('users'));
    }

    public function show(User $user)
    {
        $reports = Report::select('reports.*')->with(['user', 'reply.user', 'reply'])
            ->join('replies', 'reports.reply_id', '=', 'replies.id')
            ->join('users', 'reports.user_id', '=', 'users.id')
            ->where('users.id', $user->id)
            ->whereNull('replies.deleted_at')
            ->paginate(4);

        return view('report.show', compact('user', 'reports'));
    }

    public function ignore(Report $report)
    {
        $report->delete();

        return redirect()->route('report.index');
    }

    public function delete(Report $report)
    {
        if ($report->reply->is_topic) {
            $topic = Topic::find($report->reply->topic_id);
            $topic->delete();
        }

        $report->reply->delete();

        Report::where('reply_id',$report->reply->id)->delete();

        return redirect()->route('report.index');
    }

    public function create(Reply $reply)
    {
        return view('report.create', compact('reply'));
    }

    public function store(Reply $reply, Request $request)
    {
        Report::create([
            'user_id' => $reply->user_id,
            'reply_id' => $reply->id,
            'reason' => $request->get('reason')
        ]);

        // TODO flash message

        return redirect()->route('topics.show', ['id' => $reply->topic->id]);
    }

    public function destroy(Report $report)
    {
        $report->delete();
        return redirect()->route('report.index');
    }
}
