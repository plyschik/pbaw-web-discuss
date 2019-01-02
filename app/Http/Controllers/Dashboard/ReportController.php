<?php

namespace App\Http\Controllers\Dashboard;

use App\Topic;
use App\Report;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with(['user', 'reply', 'reply.user'])->latest()->paginate(3);

        return view('dashboard.report.index', compact('reports'));
    }

    public function ignore(Report $report)
    {
        $report->delete();

        return redirect()->route('dashboard.reports.index');
    }

    public function delete(Report $report)
    {
        if ($report->reply->is_topic) {
            $topic = Topic::find($report->reply->topic_id);
            $topic->delete();
        }

        $report->reply->delete();

        Report::where('reply_id',$report->reply->id)->delete();

        return redirect()->route('dashboard.reports.index');
    }

    public function destroy(Report $report)
    {
        $report->delete();

        return redirect()->route('dashboard.reports.index');
    }
}
