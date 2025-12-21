<?php

namespace App\Http\Controllers;

use App\Helpers\SlotFinder;
use Illuminate\Http\Request;

class APIController extends Controller
{

    public function slot($date, Request $request)
    {

        $slots = SlotFinder::getAvailableSlot($date, $request->input('appointment'));

        return response()->json($slots);
    }
}
