<?php

namespace App\Http\Controllers\Inventory;

use App\Enums\AppointmentSlotType;
use App\Enums\AppointmentType;
use App\Exceptions\InvalidInputException;
use App\Helpers\SlotFinder;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentSlot;
use App\Models\BlockAppointmentSlot;
use Carbon\Carbon;
use Faker\Provider\ar_EG\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentConfirmedMail;
use App\Mail\AppointmentRescheduleMail;

class AppointmentController extends Controller
{

    protected const SUNDAY = 0;

    public function index(Request $request)
    {

        $appointments = Appointment::when($request->input('search'), function ($qb) use ($request) {
            $qb->where(function ($qb) use ($request) {
                $qb->orWhereLike('name', '%' . $request->input('search') . '%');
                $qb->orWhereLike('email', '%' . $request->input('search') . '%');
            });
        })
            ->when($request->input('order'), function ($qb) use ($request) {
                $qb->orderBy($request->input('order'), $request->input('sort'));
            })
            ->when($request->input('search'), function ($qb) use ($request) {
                $qb->where(function ($qb) use ($request) {
                    $qb->orWhereLike('name', '%' . $request->input('search') . '%');
                    $qb->orWhereLike('email', '%' . $request->input('search') . '%');
                });
            })
            ->when($request->input('type'), function ($qb) use ($request) {
                $qb->where(function ($qb) use ($request) {

                    $qb->where('type', $request->input('type'));

                    // if( in_array($request->input('hiddenFilter'),['meeting','visit','asking for help','others','donation'])){
                    //    $qb->where('type',$request->input('hiddenFilter'));
                    // }else if(in_array($request->input('hiddenFilter'), ['done','undone'])){
                    //    $qb->where('status',$request->input('hiddenFilter'));
                    // }
                });
            })
             ->when($request->input('status'), function ($qb) use ($request) {
                $qb->where(function ($qb) use ($request) {
                    $qb->where('status',$request->input('status'));
                });
            })
            ->paginate(10)
            ->appends($request->except('page'));

        return view('inventory.appointments', [
            'appointments' => $appointments,
        ]);
    }

    public function appoint(Request $request)
    {
        try {

            DB::beginTransaction();

            $validated = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'message' => 'required|string',
                'contact' => 'required|string',
                'start' => 'required|date_format:h:i a',
                'end' => 'required|date_format:h:i a',
                'date' => 'required|date',
                'type' => ['required', Rule::enum(AppointmentType::class)],
                'note' => 'nullable|string|max:255',
            ], [
                'start.required' => 'Please choose start time',
                'end.required' => 'Please choose start time',
            ]);

            $start = Carbon::createFromFormat('g:i A', $validated['start']);
            $end = Carbon::createFromFormat('g:i A', $validated['end']);

            if ($start->greaterThanOrEqualTo($end)) {
                throw new InvalidInputException('Invalid Start/End time selection');
            }

            $existingAppointment = Appointment::where(function ($qb) use ($validated) {
                $qb->where('date', $validated['date'])
                    ->where(function ($query) use ($validated) {

                        $start = Carbon::createFromFormat('g:i A', $validated['start'])->format('H:i');
                        $end = Carbon::createFromFormat('g:i A', $validated['end'])->format('H:i');

                        $query->whereBetween('start', [$start, $end])
                            ->orWhereBetween('end', [$end, $end]);
                    });
            })->first();

            if ($existingAppointment) {
                throw new InvalidInputException('Appointment Time already Taken, please try again');
            }

            $appointment = new Appointment();

            $appointment->fill($validated);

            $appointment->start = Carbon::createFromFormat('g:i A', $validated['start'])->toTimeString();
            $appointment->end = Carbon::createFromFormat('g:i A', $validated['end'])->toTimeString();

            $appointment->save();

            DB::commit();

            $message = "See you on " . $appointment->date . ' ' . $appointment->start;

            return redirect()->back()->with(['message' => $message]);

        } catch (InvalidInputException|ValidationException $e) {
            DB::rollBack();
            dd($e->getMessage());
            // return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            // return redirect()->back()->withErrors(['message' => 'Something went wrong while setting an appointment, Please try again']);
        }
    }

    public function appointmentSlot(Request $request)
    {

        $slots = [];

        $excludedDays = BlockAppointmentSlot::where('date', '>=', Carbon::now()->format('Y-m-d'))
            ->get()
            ->pluck('date')
            ->toArray();

        for ($day = 1; $day <= 30; $day++) {

            $now = Carbon::now()->addDays($day);

            if ($now->dayOfWeek === self::SUNDAY) {
                continue;
            }

            if (!SlotFinder::getAvailableSlot($now->format('Y-m-d'))) {
                continue;
            }

            $slot = new AppointmentSlot();
            $slot->id = $day;
            $slot->date = $now->format('Y-m-d');
            $slot->capacity = 1;
            $slot->type = AppointmentSlotType::AM->value;

            if (in_array($now->format('Y-m-d'), $excludedDays)) {
                $slot->capacity = -1;
            }

            $slots[] = $slot;
        }

        return view('inventory.appointment-slot', [
            'slots' => $slots
        ]);
    }

    public function addSlot(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'date' => 'required|date',
                'capacity' => 'required|integer',
                'type' => ['required', Rule::enum(AppointmentSlotType::class)],
            ]);

            AppointmentSlot::create($validated);

            DB::commit();

            return redirect()->back()->with([
                'message' => 'Slot added'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            $message = 'Something went wrong while adding slot';

            if ($e->getCode() == 23000) { // Integrity constraint violation
                $message = 'An appointment slot for that day already exists. Please update the existing slot if you wish to increase its capacity.';
            }

            return redirect()->back()->withErrors([
                'message' => $message
            ]);
        }

    }

    public function addBlockSlot(Request $request)
    {
        try {

            DB::beginTransaction();

            $validated = $request->validate([
                'date' => 'required|date',
            ]);

            BlockAppointmentSlot::create($validated);

            DB::commit();

            return redirect()->back()->with([
                'message' => 'Block SLot added'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            $message = 'Something went wrong while adding slot';

            if ($e->getCode() == 23000) { // Integrity constraint violation
                $message = 'An appointment slot for that day already exists. Please update the existing slot if you wish to increase its capacity.';
            }

            return redirect()->back()->withErrors([
                'message' => $message
            ]);
        }

    }

    public function updateSlot(Request $request)
    {
        try {

            DB::beginTransaction();

            $validated = $request->validate([
                'date' => 'required|date',
            ]);

            BlockAppointmentSlot::where('date', $validated['date'])
                ->delete();

            DB::commit();

            return redirect()->back()->with([
                'message' => 'Slot Available'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            $message = 'Something went wrong while updating slot';

            return redirect()->back()->withErrors([
                'message' => $e->getMessage()
//                'message' => $message
            ]);
        }

    }


    public function confirm($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'confirmed';
        $appointment->save();

        // Send confirmation email
        Mail::to($appointment->email)->send(new AppointmentConfirmedMail($appointment));

        return back()->with('success', 'Appointment confirmed & email sent!');
    }

    
    public function cancel($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'confirmed';
        $appointment->save();

        // Send confirmation email
        Mail::to($appointment->email)->send(new AppointmentConfirmedMail($appointment));

        return back()->with('success', 'Appointment confirmed & email sent!');
    }

        public function reschedule($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'confirmed';
        $appointment->save();

        // Send confirmation email
        Mail::to($appointment->email)->send(new AppointmentConfirmedMail($appointment));

        return back()->with('success', 'Appointment confirmed & email sent!');
    }

    public function done($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'done';
        $appointment->save();

        return back()->with('success', 'Appointment marked as accomplished!');
    }

    public function undone($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'undone';
        $appointment->save();

        return back()->with('success', 'Appointment marked as unaccomplished!');
    }

    public function sendReschedule(Request $request){
    
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        $appointment = Appointment::findOrFail($request->appointment_id);

        Mail::to($request->email)->send(new AppointmentRescheduleMail(
            $request->subject,
            $request->message,
            $appointment->name
        ));

        // optional: update status if needed
        $appointment->update(['status' => 'rescheduled']);

        return back()->with('success', 'Reschedule notice sent successfully!');
    }

    public function sendCancelled(Request $request){
    
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        $appointment = Appointment::findOrFail($request->appointment_id);

        Mail::to($request->email)->send(new AppointmentRescheduleMail(
            $request->subject,
            $request->message,
            $appointment->name
        ));

        // optional: update status if needed
        $appointment->update(['status' => 'cancelled']);

        return back()->with('success', 'Reschedule notice sent successfully!');
    }
}
