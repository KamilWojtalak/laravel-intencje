<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PriestController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $user->load('followers');

        $unacceptedFollowers = $user->followers->where('pivot.is_accepted', 0);
        $acceptedFollowers = $user->followers->where('pivot.is_accepted', 1);

        return view('dashboard.priest.index', [
            'unacceptedFollowers' => $unacceptedFollowers,
            'acceptedFollowers' => $acceptedFollowers,
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
