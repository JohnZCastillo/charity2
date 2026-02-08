<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\DonationDrive;
use App\Models\DonationDriveData;
use App\Models\Account;
use App\Models\Address;
use App\Models\PaymentMethod;

class PaymentController extends Controller
{
    /**
     * Show the donation form with available drives
     */
    public function index()
    {
        $drives = DonationDrive::select(['id','title'])
            ->where('archived', false)
            ->get();

        $paymentMethods = PaymentMethod::all();

        return view('paymongo.paymongo', [
            'drives' => $drives,
            'paymentMethods' => $paymentMethods
        ]);
    }

    /**
     * Create a PayMongo Checkout Session
     */
    public function checkout(Request $request)
    {
        try {
            $amount = (int) $request->input('amount', 1000);
            $amountInCents = $amount * 100; // Convert to centavos
            $donationDriveId = $request->input('donation_drive_id');
            $name   = $request->input('name');
            $email  = $request->input('email');
            $mobile = $request->input('mobile');
            $reference = $request->input('reference');

    
            // Find donation drive
            $drive = DonationDrive::findOrFail($donationDriveId);
    
                // Save or update donor account
            $account = Account::updateOrCreate(
                [ 
                    'email' => $email // search by unique email
                ],
                [
                    'code'   => null,
                    'name'   => $name,
                    'mobile' => $mobile,
                    'status' => 'enabled',
                    'type'   => 'donor',
                ]
            );
        
            // Ensure address exists for this account
            Address::updateOrCreate(
                [
                    'account_id' => $account->id,
                ],
                [
                    'address' => 'N/A',
                ]
            );
        
            $receipt = $request->file('receipt')->store('images', 'public');

            // Save donation record (unconfirmed)
            DonationDriveData::create([
                'donation_drive_id' => $drive->id,
                'amount'            => $amount,
                'from'              => $name,
                'email'             => $email,
                'mobile'            => $mobile,
                'receipt'           => $receipt,
                'reference'         => $reference,
                'confirmed'         => false,
                'type'              => 'gcash'
            ]);
        
            return redirect()->back();
            
        } catch (\Exception $e) {
            Log::error('Checkout Error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Something went wrong during checkout',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
    
    
    /**
     * Handle success redirect after payment
     * (Not secure for saving data, only for showing user feedback)
     */
    public function success(Request $request)
    {
        $amount     = $request->query('amount');
        $driveId    = $request->query('donation_drive_id');
        $checkoutId = $request->query('checkout_session_id');
    
        $drive      = DonationDrive::find($driveId);
        $receiptUrl = null;
    
        try {
            if ($checkoutId) {
                // Fetch checkout session
                $response = Http::withBasicAuth(config('services.paymongo.secret_key'), '')
                    ->get("https://api.paymongo.com/v1/checkout_sessions/{$checkoutId}");
    
                if ($response->successful()) {
                    $checkoutData = $response->json();
                    $payments     = $checkoutData['data']['attributes']['payments'] ?? [];
    
                    if (!empty($payments)) {
                        $paymentId = $payments[0]['id'];
    
                        // Fetch payment details to get receipt
                        $paymentResponse = Http::withBasicAuth(config('services.paymongo.secret_key'), '')
                            ->get("https://api.paymongo.com/v1/payments/{$paymentId}");
    
                        if ($paymentResponse->successful()) {
                            $paymentData = $paymentResponse->json();
                            $receiptUrl  = $paymentData['data']['attributes']['receipt']['url'] ?? null;
    
                            // Update donation record as confirmed
                            DonationDriveData::where('donation_drive_id', $driveId)
                                ->where('amount', $amount)
                                ->latest()
                                ->first()
                                ?->update([
                                    'receipt'   => $receiptUrl,
                                    'confirmed' => true
                                ]);
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Success Page Error: ' . $e->getMessage());
        }
    
        return view('paymongo.success', [
            'drive'   => $drive,
            'amount'  => $amount,
            'receipt' => $receiptUrl,
        ]);
    }
    
    /**
     * Handle PayMongo webhook for payment confirmation
     * This is the secure way to store donations
     */
    public function webhook(Request $request)
    {
        $payload = $request->all();
        Log::info('PayMongo Webhook received', $payload);

        try {
            $eventType = $payload['data']['attributes']['type'] ?? null;

            // Process successful payment
            if ($eventType === 'payment.paid') {
                $payment = $payload['data']['attributes']['data']['attributes'];

                // DonationDriveData::create([
                //     'donation_drive_id' => $payment['metadata']['donation_drive_id'] ?? null,
                //     'amount'            => ($payment['amount'] ?? 0) / 100,
                //     'from'              => $payment['billing']['name'] ?? 'Anonymous',
                //     'email'             => $payment['billing']['email'] ?? null,
                //     'receipt'           => $payment['receipt']['url'] ?? null,
                //     'confirmed'         => true
                // ]);
            }

            return response()->json(['status' => 'ok']);
        } catch (\Exception $e) {
            Log::error('Webhook Error: ' . $e->getMessage());
            return response()->json(['status' => 'error'], 500);
        }
    }
}
