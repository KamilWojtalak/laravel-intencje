<?php

namespace App\Http\Controllers\Dashboard\Priest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function create()
    {
        return view('dashboard.priest.events.create');
    }
}
