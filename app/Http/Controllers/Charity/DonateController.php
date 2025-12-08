<?php

namespace App\Http\Controllers\Charity;

use App\Http\Controllers\Controller;
use App\Models\DonationDrive;
use App\Models\DonationDriveData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DonateController extends Controller
{

    public function donateView()
    {
        $drives = DonationDrive::select(['id','title'])
            ->where('archived',false)
            ->get();

        return view('charity.donation-page', [
            'drives' => $drives
        ]);
    }

    public function check(Request $request)
    {

        $validated = $request->validate([
            'type' => 'required'
        ]);

        if ($validated['type'] === 'gcash') {
            // return redirect('/charity/donate');
            return redirect('/charity/pay');
        }

        return redirect('/charity/appointment');
    }

    public function index(Request $request, DonationDrive $donationDrive)
    {

        try {

            $validated = $request->validate([
                'amount' => 'required|numeric',
                'donation_drive_id' => 'required',
                'from' => 'nullable',
                'email' => 'required',
                'receipt' => 'required',
            ]);

            $receiptPath = $request->file('receipt')->store('public');

            if (!$receiptPath) {
                throw new \Exception('Something went wrong while saving receipt');
            }

            $donation = new DonationDriveData();
            $donation->amount = $validated['amount'];
            $donation->donation_drive_id = $validated['donation_drive_id'];
            $donation->from = $validated['from'];
            $donation->email = $validated['email'];
            $donation->receipt = $receiptPath;
            $donation->confirmed = true;

            $donation->save();

            return redirect()->back()->with(['message' => 'Thank you for your donation!']);

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message' => 'Something went wrong while donating!']);
        }
    }
}
