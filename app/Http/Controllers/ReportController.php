<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with('user')->latest()->paginate(5);

        return view('report.index', compact('reports'));
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
