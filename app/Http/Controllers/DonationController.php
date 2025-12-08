<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Item;
use App\Models\ItemStockOut;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ActivityLog;

class DonationController extends Controller
{

    public function donate(Request $request)
{
    try {
        DB::beginTransaction();

        $validated = $request->validate([
            'recipient_id' => 'required|exists:accounts,id',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|numeric|min:1',
        ]);

        $recipient = \App\Models\Account::findOrFail($validated['recipient_id']);
        foreach ($validated['items'] as $donationItem) {
            $item = Item::with(['stockIns', 'stocks' => function ($qb) {
                $qb->where('expiration', '>', Carbon::now());
            }])->findOrFail($donationItem['item_id']);

            if ($donationItem['quantity'] > $item->stock) {
                throw new \Exception("Invalid Quantity for {$item->name}! Not enough stock.");
            }

            $quantityToRemove = $donationItem['quantity'];

            foreach ($item->stocks as $stockIn) {
                $stock = $stockIn->active_quantity;

                if ($quantityToRemove > $stock) {
                    $quantityToRemove -= $stock;
                    $stockIn->active_quantity = 0;
                } else {
                    $stockIn->active_quantity -= $quantityToRemove;
                    $quantityToRemove = 0;
                }
                $stockIn->save();

                if ($quantityToRemove <= 0) break;
            }

            $donation = Donation::create([
                'recipient_id' => $validated['recipient_id'],
                'item_id' => $item->id,
                'quantity' => $donationItem['quantity'],
            ]);

            ItemStockOut::create([
                'quantity' => $donationItem['quantity'],
                'note' => 'Donation',
                'item_id' => $item->id,
                'donation_id' => $donation->id,
            ]);

            ActivityLog::create([
                'user_id'  => auth()->id(),
                'activity' => "Donated {$donationItem['quantity']} pcs of {$item->name} to {$recipient->name}"
            ]);
        }

        DB::commit();
        return redirect()->back()->with(['message' => 'Donation Success!']);
    } catch (\Exception $exception) {
        DB::rollBack();
        return redirect()->back()->withErrors(['message' => $exception->getMessage()]);
    }
}

}
