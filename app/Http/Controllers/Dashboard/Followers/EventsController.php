<?php

namespace App\Http\Controllers\Dashboard\Followers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function create(Event $event)
    {
        return view('dashboard.follower.events.create', [
            'event' => $event
        ]);
    }

    // TODO validation i authorization w Events Controller
    // TODO clean code
//     public function store(Request $request)
//     {
//         // $request->validate();
//         $name = $request->get('name');

//         $date = $request->get('date');
//         $hour = $request->integer('hour');
//         $minutes = $request->integer('minutes', 0);

//         $dateTime = Carbon::createFromFormat('Y-m-d', $date)->setHour($hour)->setMinutes($minutes);

//         Event::create([
//             'priest_id' => auth()->id(),
//             'name' => $name,
//             'start_at' => $dateTime,
//         ]);

//         return redirect()->route('dashboard.priest.calendar')
//             ->with('success', 'Pomyślnie utworzono mszę');
//     }
}