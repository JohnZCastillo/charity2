<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\BlockAppointmentSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlockAppointmentController extends Controller
{

    public function addBlock(Request $request)
    {
        $validated = [
            'date' => 'required'
        ];

        try {
            DB::beginTransaction();

            BlockAppointmentSlot::create($validated);

            redirect()->back()->with(['message' => 'Appointment Block Added!']);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }
}
