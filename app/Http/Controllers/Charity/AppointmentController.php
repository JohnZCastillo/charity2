<?php

namespace App\Http\Controllers\Charity;

use App\Enums\AppointmentSlotType;
use App\Helpers\SlotFinder;
use App\Http\Controllers\Controller;
use App\Models\AppointmentSlot;
use App\Models\BlockAppointmentSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{

    public function index()
    {

        $slots = [];

        $excludedDays = BlockAppointmentSlot::where('date', '>=', Carbon::now()->format('Y-m-d'))
            ->get()
            ->pluck('date')
            ->toArray();

        for ($day = 1; $day <= 30; $day++) {

            $now = Carbon::now()->addDays($day);

            if ($now->dayOfWeek === 0) {
                continue;
            }

            if (in_array($now->format('Y-m-d'), $excludedDays)){
                continue;
            }

            if(!SlotFinder::getAvailableSlot($now->format('Y-m-d'))){
                continue;
            }

            $slot = new AppointmentSlot();
            $slot->id = $day;
            $slot->date = $now->format('Y-m-d');
            $slot->capacity = 1;
            $slot->type = AppointmentSlotType::AM->value;

            $slots[] = $slot;
        }

        return view('charity.appointment', [
            'slots' => $slots
        ]);
    }

}
