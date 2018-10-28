<?php

namespace App\Http\Controllers;

use App\Report;
use App\Topic;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index()
    {
        $reports = Report::paginate(2);

        return view('reports.index', compact('reports'));
    }

    public function create(Topic $topic)
    {
        return view('reports.create', compact('topic'));
    }

    public function store(Topic $topic, Request $request)
    {
        Report::create([
            'topic_id' => $topic->id,
            'user_id' => auth()->id(),
            'reason' => $request['reason']
        ]);

        return redirect()->route('topics.show', ['id' => $topic->id]);
    }

    public function destroy(Report $report)
    {
        $report->delete();
        return redirect()->route('reports.index');
    }
}
