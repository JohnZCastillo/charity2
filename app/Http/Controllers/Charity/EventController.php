<?php

namespace App\Http\Controllers\Charity;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{

    public function view($id) {

        $event = Event::findorFail($id);

        return view('charity.view-event', compact('event'));
    }

    public function index(Request $request)
    {

        $events = Event::when($request->query('upcoming',false), function($qb){
                return $qb->where('start','>', Carbon::now()->format('Y-m-d H:m:i'));
        })->get();

        return view('charity.events', [
            'events' => $events
        ]);
    }

   
}
