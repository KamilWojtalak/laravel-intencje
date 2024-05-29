<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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

    public function accept(User $follower)
    {
        $user = auth()->user();
        $user->load('followers');

        // if ($user->hasNotThisFollower($follower)) {
        if (!$user->followers->contains('id', $follower->id)) {
            ValidationException::withMessages([
                'follower' => __("Ten ksiądz nie ma takiego użytkownika")
            ]);
        }

        // $follower = $user->getFollowerById($follower->id);
        $follower = $user->followers->where('id', $follower->id)->first();

        // $user->acceptFollower($follower);
        $user->followers()->updateExistingPivot($follower->id, ['is_accepted' => 1]);

        return redirect()->route('dashboard.priest.index')->with('success', 'Pomyślnie zaakcpetowano użytkownika');
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
