<?php

namespace App\Http\Controllers\Charity;

use App\Http\Controllers\Controller;
use App\Models\DonationDrive;
use App\Models\Event;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {

        $donations = DonationDrive::orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $events = Event::orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('charity.about-us', [
            'donations' => $donations,
            'events' => $events,
        ]);
    }
}
