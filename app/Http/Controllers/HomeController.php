<?php

namespace App\Http\Controllers;

use App\Models\DonationDrive;
use App\Models\Event;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Account;
use App\Models\ItemCategory;
use App\Models\ItemGender;
use App\Models\ItemSize;
use App\Enums\ItemStatus;
use App\Enums\UserType;
use Carbon\Carbon;
class HomeController extends Controller
{
    public function index(Request $request)
    {
        // --- Announcements Query ---
        $query = Announcement::query();

        $query->when($request->input('search'), function ($qb) use ($request) {
            $qb->where(function ($qb) use ($request) {
                $qb->where('title', 'like', '%' . $request->input('search') . '%')
                   ->orWhereHas('user', function ($qb) use ($request) {
                       $qb->where('name', 'like', '%' . $request->input('search') . '%');
                   });
            });
        });

        $query->when($request->input('order'), function ($qb) use ($request) {
            $qb->orderBy($request->input('order'), $request->input('sort', 'asc'));
        });

        $announcements = $query->paginate(10);

        // --- Donations ---
        $donations = DonationDrive::orderBy('created_at', 'desc')
            ->where('archived', false)
            ->get();

        // --- Drives ---
        $drives = DonationDrive::select(['id','title'])
            ->where('archived', false)
            ->get();

        // --- Events ---
        $events = Event::orderBy('created_at', 'asc')
            ->with(['image'])
            ->get();

        // Return merged view
        return view('charity.homepage', [
            'announcements' => $announcements,
            'donations' => $donations,
            'events' => $events,
            'drives' => $drives,
        ]);
    }


   public function fetchDonorLogs(Request $request)
    {
        $query = Item::with(['stockIns', 'donor'])
            ->where('deleted', 0)
            ->withSum([
                'stockIns as quantity' => function ($qb) {
                    $qb->where('expiration', '>', Carbon::now());
                }
            ], 'active_quantity');

        // Search filter
        $query->when($request->input('search'), function ($qb) use ($request) {
            $qb->where(function ($qb) use ($request) {
                $qb->where('items.name', 'like', '%' . $request->input('search') . '%')
                    ->orWhereHas('donor', function ($subQb) use ($request) {
                        $subQb->where('name', 'like', '%' . $request->input('search') . '%');
                    });
            });
        });

        // Order
        $query->when($request->input('order'), function ($qb) use ($request) {
            $qb->orderBy('quantity', $request->input('sort', 'asc'));
        });

        $items = $query->paginate(5)->appends($request->except('page'));

        // Transform to donor logs style
        $data = $items->map(function ($item) {
            return [
                'date' => optional($item->stockIns->first())->created_at?->format('Y-m-d') ?? now()->format('Y-m-d'),
                'contributor_name' => $item->donor->name ?? 'Unknown Donor',
                'item' => $item->name,
                'quantity' => $item->quantity ?? 0,
                'donation_type' => $item->category->name ?? 'General',
            ];
        });

        return response()->json([
            'data' => $data,
            'pagination' => $items->links()->toHtml(),
        ]);
    }
}
