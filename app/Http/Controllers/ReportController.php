<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function create(Reply $reply)
    {
        return view('forum.report.create', compact('reply'));
    }

    public function store(Reply $reply, Request $request)
    {
        Report::create([
            'user_id' => $reply->user_id,
            'reply_id' => $reply->id,
            'reason' => $request->get('reason')
        ]);

        return redirect()->route('topics.show', ['id' => $reply->topic->id])
            ->with('success', 'Report created.');
    }
}
