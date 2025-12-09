<?php

namespace App\Helpers;

use App\Models\Appointment;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class SlotFinder
{

    /**
     * @param string $date must follow Y-m-d format
     * @return array
     */
    public static function getAvailableSlot(string $date): array
    {

        $startPeriod = Carbon::parse('08:00');
        $endPeriod = Carbon::parse('17:00');

        $period = CarbonPeriod::create($startPeriod, '30 minutes', $endPeriod);

        $hours = [];
        $slots = [];

        $appointments = Appointment::select(['start', 'end', 'date'])
            ->where('date', $date)
            ->get()
            ->toArray();


        foreach ($period as $date) {

            $conflict = false;

            foreach ($appointments as $index => $excluded) {

                $excludedStart = Carbon::parse($excluded['start']);

                $excludedEnd = Carbon::parse($excluded['end']);

                if (($index < count($appointments)) - 1 || (count($appointments) == 1)) {
                    $excludedEnd->subMinute();
                }

                $conflict = $date->between($excludedStart, $excludedEnd);

                if ($conflict) {
                    break;
                }
            }

            if ($conflict) {
                continue;
            }

            $hours[] = $date;
        }

        for ($i = 0; $i <= count($hours) - 1; $i++) {

            if($i+1 > count($hours) - 1 ){
                $slots[] = $hours[$i]->format('h:i a');
                continue;
            }

            if ($hours[$i]->diffInHours($hours[$i + 1]) > 1) {
                continue;
            }

            $slots[] = $hours[$i]->format('h:i a');
        }

        return count($slots) > 1 ? $slots : [];
    }
}
