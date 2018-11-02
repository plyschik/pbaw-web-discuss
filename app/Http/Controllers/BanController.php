<?php

namespace App\Http\Controllers;

use App\User;
use App\Report;
use Illuminate\Http\Request;

class BanController extends Controller
{
    public function create(User $user)
    {
        return view('ban.create', compact('user'));
    }

    public function store(User $user, Request $request)
    {
        $this->validate($request, [
            'comment' => 'required|min:8|max:65535',
            'period' => 'required|in:1,3,7,14,30,60,90'
        ]);

        $user->ban([
            'comment' => $request->input('comment'),
            'expired_at' => "+ {$request->input('period')} days"
        ]);

        Report::where('user_id', $user->id)->delete();

        return redirect()->route('report.index');
    }
}
