<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PriestController extends Controller
{
    public function index()
    {
        /**
         * @var User $user
         */
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
        /**
         * @var User $user
         */
        $user = auth()->user();
        $user->load('followers');

        if ($user->hasNotThisFollower($follower)) {
            ValidationException::withMessages([
                'follower' => __("Ten ksiądz nie ma takiego użytkownika")
            ]);
        }

        $follower = $user->getPriestFollowerById($follower->id);

        $user->priestAcceptFollower($follower);

        return redirect()->route('dashboard.priest.index')->with('success', 'Pomyślnie zaakcpetowano użytkownika');
    }

    public function calendar()
    {
        $events = Event::getByPriest(auth()->user());

        return view('dashboard.priest.calendar', []);
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
