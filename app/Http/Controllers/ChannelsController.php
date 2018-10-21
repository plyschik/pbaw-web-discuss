<?php

namespace App\Http\Controllers;

use App\Channel;
use Illuminate\Http\Request;

class ChannelsController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        return view('channels.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:32'
        ]);

        Channel::create([
            'name' => request('name'),
        ]);

        return redirect('/');
    }

    public function edit(Channel $channel)
    {
        return view('channels.edit', compact('channel'));
    }

    public function update(Request $request, Channel $channel)
    {
        $request->validate([
            'name' => 'required|max:32'
        ]);

        $channel->update(request(['name']));

        return redirect('/');
    }

    public function destroy(Channel $channel)
    {
        $channel->delete();
        return redirect('/');
    }
}
