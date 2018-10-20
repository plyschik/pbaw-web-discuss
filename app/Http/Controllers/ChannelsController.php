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
            'name' => 'required'
        ]);

        Channel::create([
            'name' => request('name'),
        ]);

        return redirect('/');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
