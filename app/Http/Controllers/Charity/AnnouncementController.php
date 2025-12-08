<?php

namespace App\Http\Controllers\Charity;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{

    public function index()
    {

        $announcements = Announcement::where('archived', false)->get();

        return view('charity.announcements', [
            'announcements' => $announcements,
        ]);
    }
}
