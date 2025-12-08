<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\AnnouncementAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ActivityLog;

class AnnouncementController extends Controller
{

    public function index(Request $request)
    {
        $query = Announcement::query();

        $query->when($request->input('search'), function ($qb) use ($request) {

            $qb->where(function ($qb) use ($request) {
                $qb->whereLike('title', '%' . $request->input('search') . '%');

                $qb->orWhere(function ($qb) use ($request) {
                    $qb->whereHas('user', function ($qb) use ($request) {
                        $qb->whereLike('name', '%' . $request->input('search') . '%');
                    });
                });
            });
        });

        $query->when($request->input('order'), function ($qb) use ($request) {
            $qb->orderBy($request->input('order'), $request->input('sort'));
        });

        $announcements = $query->paginate(10);
         ActivityLog::create([
             'user_id' => auth()->user()->id,
            'activity' => 'Visited the Announcement list page.'
        ]);
        return view('announcements', [
            'announcements' => $announcements
        ]);

    }


    public function createAnnouncement()
    {
          ActivityLog::create([
             'user_id' => auth()->user()->id,
            'activity' => 'Visited the Create Announcement  page.'
        ]);
        return view('announcement-maker');
    }

    public function viewAnnouncement($announcementID)
    {

        $announcement = Announcement::findOrFail($announcementID);

         ActivityLog::create([
             'user_id' => auth()->user()->id,
            'activity' => 'Viewed edit Announcement  page.'
        ]);
        return view('announcement-edit', [
            'announcement' => $announcement
        ]);
    }

    public function updateAnnouncement(Request $request, $announcementID)
    {

        try {

            DB::beginTransaction();

            $validated = $request->validate([
                'title' => 'required',
                'content' => 'required'
            ]);

            Announcement::findOrFail($announcementID)
                ->update($validated);

            DB::commit();
             ActivityLog::create([
             'user_id' => auth()->user()->id,
            'activity' => 'Updated an Announcement  page.'
        ]);
            return redirect()->back()->with(['message' => 'Update Success']);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function deleteAnnouncement($announcementID)
    {
        try {
            DB::beginTransaction();
            Announcement::findOrFail($announcementID)->delete();

             ActivityLog::create([
             'user_id' => auth()->user()->id,
            'activity' => 'Deleted an Announcement  page.'
         ]);
            DB::commit();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }


    public function newAnnouncement(Request $request)
    {
        try {

            DB::beginTransaction();

            $validated = $request->validate([
                'title' => 'required|string',
                'content' => 'required|string',
            ]);

            Announcement::create([
                'title' => $validated['title'],
                'content' => $validated['content'],
                'user_id' => 1,
            ]);

             ActivityLog::create([
             'user_id' => auth()->user()->id,
            'activity' => 'Created new Announcement  page.'
            ]);
            DB::commit();

            return redirect()->route('announcements');

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->back()->withErrors([
                'message' => $e->getMessage()
            ]);

        }

    }

    public function view($id) {

        $announcement = Announcement::findorFail($id);
        
        return view('charity.view-announcements', compact('announcement'));
    }
}
