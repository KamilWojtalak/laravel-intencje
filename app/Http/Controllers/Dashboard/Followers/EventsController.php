<?php

namespace App\Http\Controllers\Dashboard\Followers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Payment;
use App\Services\Payments\MakePaymentStrategy;
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

        //  TODO nie jest tutaj potrzbeny payed_id i event_id, to chyba nadmiarowe dane, chociaż nie wiem, na razie zostawiam bo nic to nie zmieni
        // TODO Ważne żęby działało
        $payment = Payment::create([
            'status' => 'init',
            'session_id' => null,
            'payer_id' => auth()->id(),
            'event_id' => $event->id,
            'price' => $price,
            'provider' => Payment::PROVIDER_STRIPE
        ]);

        $event->participants()->attach(auth()->id(), [
            'message' => $message,
            // TODO to przenieść do payment
            'price' => $price,
            'payment_id' => $payment->id,
        ]);

        // stripe integration
        $response = (new MakePaymentStrategy)->handle('stripe', $payment);

        return $response;
    }
}
