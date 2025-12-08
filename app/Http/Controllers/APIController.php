<?php

namespace App\Http\Controllers;

use App\Helpers\SlotFinder;
use Illuminate\Http\Request;

class APIController extends Controller
{

    public function slot($date)
    {

        $slots = SlotFinder::getAvailableSlot($date);

        return response()->json($slots);
    }
}
