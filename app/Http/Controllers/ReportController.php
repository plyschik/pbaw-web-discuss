<?php

namespace App\Http\Controllers;

use App\User;
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
        $reports = $user->reports()->with(['user', 'reply.user', 'reply'])
            ->join('replies', 'reports.reply_id', '=', 'replies.id')
            ->whereNull('replies.deleted_at')
            ->paginate(2);

        return view('report.show', compact('user', 'reports'));
    }

    public function ignore(Report $report)
    {
        $report->delete();

        return redirect()->route('report.index');
    }

    public function delete(Report $report)
    {
        $report->reply->delete();

        $report->delete();

        return redirect()->route('report.index');
    }

    public function create(Reply $reply)
    {
        return view('report.create', compact('reply'));
    }

    public function store(Reply $reply, Request $request)
    {
        Report::create([
            'user_id' => $request->user()->id,
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
