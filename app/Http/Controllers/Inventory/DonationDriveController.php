<?php

namespace App\Http\Controllers\Inventory;

use App\Enums\MoneyType;
use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\DonationDrive;
use App\Models\DonationDriveData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\ActivityLog;

class DonationDriveController extends Controller
{

    public function index(Request $request)
    {

        $donations = DonationDrive::with(['donations' => function ($qb) {
            $qb->where('confirmed', true);
        }])
            ->when($request->input('search'), function ($qb) use ($request) {
                $qb->where(function ($qb) use ($request) {
                    $qb->orWhereLike('title', '%' . $request->input('search') . '%');
                    $qb->orWhereLike('goal', '%' . $request->input('search') . '%');
                });
            })
            ->when($request->input('order'), function ($qb) use ($request) {
                $qb->orderBy($request->input('order'), $request->input('sort'));
            })
            ->where('archived', false)
            ->paginate(10)
            ->appends($request->except('page'));

        $funds = DonationDrive::select(['id', 'title'])
            ->where('archived', false)
            ->get();

        $recipients = Account::select(['id', 'name'])
            ->where('type', UserType::RECIPIENT)
            ->get();


        return view('inventory.donations', [
            'donations' => $donations,
            'funds' => $funds,
            'recipients' => $recipients,
        ]);
    }

    public function donate(Request $request)
    {

        try {

            $validated = $request->validate([
                'from' => 'nullable',
                'receipt' => 'nullable|file',
                'email' => 'nullable',
                'amount' => 'required',
                'type' => [Rule::enum(MoneyType::class)],
                'donation_drive_id' => 'required',
            ]);

            if ($request->hasFile('receipt')) {

                $filename = $request->file('receipt')->store('public');

                if (!$filename) {
                    throw new \Exception('Unable to save image');
                }

                $validated['receipt'] = $filename;
            }

            $validated['confirmed'] = false;

            DonationDriveData::create($validated);

            return redirect()->back()->with(['message' => 'Donation Success!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => 'Something went wrong!, please try again']);
        }
    }

    public function donationDriveData(Request $request, $donationDriveID)
    {
        $donations = DonationDriveData::where('donation_drive_id', $donationDriveID)
            ->when($request->input('search'), function ($qb) use ($request) {
                $qb->where(function ($qb) use ($request) {
                    $qb->orWhereLike('from', '%' . $request->input('search') . '%');
                    $qb->orWhereLike('amount', '%' . $request->input('search') . '%');
                });
            })
            ->when($request->input('order'), function ($qb) use ($request) {
                $qb->orderBy($request->input('order'), $request->input('sort'));
            })
            ->paginate(10)
            ->appends($request->except('page'));
        
           
        return view('inventory.donations-details', [
            'donations' => $donations
        ]);
    }

    public function add(Request $request)
    {
        try {

            DB::beginTransaction();

            $validated = $request->validate([
                'title' => 'required|string',
                'goal' => 'required|numeric',
                'image' => 'required|file',
            ]);

            $filename = $request->file('image')->store('public');

            if (!$filename) {
                throw new \Exception('Something went wrong while saving image');
            }

            $validated['image'] = $filename;

            DonationDrive::create($validated);

            DB::commit();

            return redirect()->back()->with(['message' => 'Donation drive created!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => 'Something went wrong while creating donation drive']);
        }
    }

    public function update(Request $request, DonationDrive $donationDrive)
    {
        try {

            DB::beginTransaction();

            $validated = $request->validate([
                'title' => 'required|string',
                'goal' => 'required|numeric',
                'image' => 'nullable|image',
            ]);

            if ($request->hasFile('image')) {

                $filename = $request->file('image')->store('public');

                if (!$filename) {
                    throw new \Exception('Something went wrong while saving image');
                }

                $validated['image'] = $filename;
            }

            $validated = array_filter($validated);

            $donationDrive->fill($validated);
            $donationDrive->save();

            DB::commit();

            return redirect()->back()->with(['message' => 'Donation drive updated!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => 'Something went wrong while updating donation drive']);
        }
    }

    public function delete(DonationDrive $donationDrive)
    {
        try {

            DB::beginTransaction();

            $donationDrive->archived = true;

            $donationDrive->save();

            DB::commit();

            return redirect()->back()->with(['message' => 'Donation drive deleted!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => 'Something went wrong while deleting donation drive']);
        }
    }

    public function confirm(Request $request)
    {
        $donationId = $request->input('donation_id');

        $donation = DonationDriveData::findOrFail($donationId);
        $donation->confirmed = true;
        $donation->save();

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Confirmed the GCash donation of '.$donation->from
        ]);
        return redirect()->back()->with('success', 'Donation confirmed successfully!');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:accomplished,unaccomplished',
        ]);

        $donation = DonationDrive::findOrFail($id);
        $donation->status = $request->status;
        $donation->save();

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Set the donation drive titled' .$donation->title.' to ' . $request->status
        ]);

        return redirect()->back()->with('success', 'Donation drive status updated to ' . $request->status);
    }

   public function report(Request $request, $id)
    {
        $donation = DonationDrive::with(['donations' => function ($qb) {
            $qb->where('confirmed', true);
        }])->findOrFail($id);

        // ✅ Total confirmed donations
        $totalAmount = $donation->donations->sum('amount');
        $donorCount  = $donation->donations->count();

        // ✅ Group by month for chart
        $monthlyData = $donation->donations()
            ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        // ✅ Convert to array for Chart.js
        $labels = [];
        $values = [];
        foreach (range(1, 12) as $m) {
            $labels[] = date("F", mktime(0, 0, 0, $m, 1));
            $values[] = $monthlyData[$m] ?? 0;
        }

        return view('inventory.donationdrive-report', compact(
            'donation',
            'totalAmount',
            'donorCount',
            'labels',
            'values'
        ));
    }


}
