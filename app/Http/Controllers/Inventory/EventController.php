<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{

    public function index(Request $request)
    {

        $query = Event::query();

        $query->when($request->input('search'), function ($qb) use ($request) {
            $qb->where(function ($qb) use ($request) {
                $qb->whereLike('title', '%' . $request->input('search') . '%');
                $qb->orWhereLike('description', '%' . $request->input('search') . '%');
                $qb->orWhereLike('location', '%' . $request->input('search') . '%');
                $qb->orWhereDate('start', $request->input('search'));
                $qb->orWhereDate('end', $request->input('search'));
            });
        });

        $query->when($request->input('order'), function ($qb) use ($request) {
            $qb->orderBy($request->input('order'), $request->input('sort'));
        });

        $events = $query->paginate(10);

        return view('inventory.events', [
            'events' => $events
        ]);
    }

    public function viewEvent($eventID)
    {

        $event = Event::with(['images'])
            ->findOrFail($eventID);

        return view('inventory.event', [
            'event' => $event
        ]);
    }

    public function deleteEvent($eventID)
    {
        try {
            DB::beginTransaction();

            $event = Event::findOrFail($eventID);

            $event->images()->delete();

            $event->delete();

            DB::commit();

            return redirect()->back()->with(['message' => 'Event Deleted!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
//            return redirect()->back()->withErrors(['message' => 'Something went wrong while deleting event']);
        }
    }

    public function updateEvent(Request $request, $eventID)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'title' => 'required|string',
                'description' => 'required|string',
                'location' => 'required|string',
                'start' => 'required|date',
                'end' => 'required|date',
                'images' => 'nullable'
            ]);

            $event = Event::findOrFail($eventID);

            $event->fill($validated);

            $event->save();

            if ($request->hasFile('images')) {

                foreach ($request->file('images') as $image) {

                    $filename = $image->store('public');

                    if (!$filename) {
                        throw new \Exception('Image Upload Failed');
                    }

                    EventImage::create([
                        'event_id' => $event->id,
                        'path' => $filename
                    ]);
                }
            }

            DB::commit();

            return redirect()->back()->with(['message' => 'Event updated!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function newEvent(Request $request)
    {
        try {

            DB::beginTransaction();

            $validated = $request->validate([
                'title' => 'required|string',
                'images' => 'required',
                'description' => 'required|string',
                'location' => 'required|string',
                'start' => 'required|date',
                'end' => 'required|date',
            ]);

            $event = Event::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'location' => $validated['location'],
                'start' => $validated['start'],
                'end' => $validated['end'],
            ]);

            foreach ($request->file('images') as $image) {

                $filename = $image->store('public');

                if (!$filename) {
                    throw new \Exception('Image Upload Failed');
                }

                EventImage::create([
                    'event_id' => $event->id,
                    'path' => $filename
                ]);
            }

            DB::commit();

            return redirect()->back()->with(['message' => 'Event Added!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }
}
