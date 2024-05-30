<?php

namespace App\Http\Controllers\Dashboard\Followers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function index()
    {
        $events = Event::getForCurrentUser();

        return view('dashboard.follower.events.index', [
            'events' => $events
        ]);
    }

    public function create(Event $event)
    {
        return view('dashboard.follower.events.create', [
            'event' => $event
        ]);
    }

    // TODO validation i authorization w Events Controller
    // TODO event authorization, if this user can assign to this event
    // TODO clean code
    public function store(Request $request)
    {
        // $request->validate();
        $eventId = $request->get('event_id');
        $message = $request->get('message');
        $price = $request->get('price', 2);

        $event = Event::find($eventId);

        /**
         * TODO, trzeba zrobić możliwość zapisywania się na event, event po zapisaniu się jednej osoby (w przyszłości wielu osób),
         * nie moze być już dostępny do zapisu
         *
         */

        $event->participants()->attach(auth()->id(), [
            'message' => $message,
            // TODO to przenieść do payment
            'price' => $price,
        ]);

        // TODO tutaj będzie p24 integration
        // TODO

        // p24 integration

        return redirect()
            ->route('dashboard.follower.events.index')
            ->with('succes', 'Pomyślnie zapisano na mszę.');
    }
}
