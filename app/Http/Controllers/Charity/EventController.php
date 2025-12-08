<?php

namespace App\Http\Controllers\Charity;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{

    public function view($id) {

        $event = Event::findorFail($id);

        return view('charity.view-event', compact('event'));
    }
    public function index()
    {

        $events = Event::get();

        return view('charity.events', [
            'events' => $events
        ]);
    }
}
