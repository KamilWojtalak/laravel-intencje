<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class FollowersController extends Controller
{
    public function index()
    {
        $priest = auth()->user()->prists->first();

        return view('dashboard.follower.index', [
            'priest' => $priest
        ]);
    }

    public function calendar()
    {
        $priest = auth()->user()->prists->first();

        $events = Event::getByPriest($priest);

        return view('dashboard.follower.calendar', [
            'events' => $events,
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
