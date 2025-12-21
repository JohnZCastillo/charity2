<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $user = User::findOrFail(1);

        return view('inventory.account', [
            'user' => $user
        ]);
    }

    public function addPaymentMethod(Request $request){
        try {
            $validated = $request->validate([
                'bank_name' => 'required|string|max:255',
                'account_name' => 'required|string|max:255',
                'account_number' => 'required|string|max:50|unique:payment_methods',
                'qr_code' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            // Create new payment method
            $paymentMethod = PaymentMethod::create([
                'bank_name' => $validated['bank_name'],
                'account_name' => $validated['account_name'],
                'account_number' => $validated['account_number'],
                'user_id' => auth()->id() // Optional: associate with user
            ]);

            // Handle QR code upload if provided
            if ($request->hasFile('qr_code')) {
                $qrPath = $request->file('qr_code')->store('qr_codes', 'public');
                $paymentMethod->update(['qr_code' => $qrPath]);
            }

            return redirect()->back()->with(['message' => 'Payment method created successfully!']);

        } catch (\Exception $e) {
            $message = $e->getMessage();
            
            if ($e->getCode() == 23000) {
                $message = 'Account number already exists!';
            }

            return redirect()->back()->withErrors(['message' => $message]);
        }
    }


    public function updatePaymentMethod($id, Request $request){
        try {
            $validated = $request->validate([
                'bank_name' => 'required|string|max:255',
                'account_name' => 'required|string|max:255',
                'account_number' => 'required|string|max:50',
                'qr_code' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $paymentMethod = PaymentMethod::findOrFail($id);

            // Update basic fields
            $paymentMethod->update([
                'bank_name' => $validated['bank_name'],
                'account_name' => $validated['account_name'],
                'account_number' => $validated['account_number']
            ]);

            // Only update QR if file is provided
            if ($request->hasFile('qr_code')) {
                // Delete old QR if exists

                if ($paymentMethod->qr_code) {
                    Storage::disk('public')->delete($paymentMethod->qr_code);
                }
                
                $qrPath = $request->file('qr_code')->store('qr_codes', 'public');
                $paymentMethod->update(['qr_code' => $qrPath]);
            }

            return redirect()->back()->with(['message' => 'Payment method updated successfully!']);

        } catch (\Exception $e) {
            $message = $e->getMessage();
            
            if ($e->getCode() == 23000) {
                $message = 'Account number already exists!';
            }

            return redirect()->back()->withErrors(['message' => $message]);
        }
    }


    public function updatePassword(Request $request)
    {

        try {

            $validated = $request->validate([
                'password' => 'required|string',
                'newPassword' => 'required|string',
                'confirmPassword' => 'required|string|same:newPassword',
            ], [
                'same' => 'New password and confirm password does not match',
            ]);

            $user = User::findOrFail(Auth::id());

            if (!Hash::check($request->input('password'), $user->password)) {
                throw new \Exception('Incorrect password');
            }

            $user->password = bcrypt($request->input('newPassword'));

            $user->save();

            return redirect()->back()->with(['message' => 'Password Changed!']);

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function deletePaymentMethod($id){
        try {
            $paymentMethod = PaymentMethod::findOrFail($id);

            // Delete QR code file if exists
            if ($paymentMethod->qr_code) {
                Storage::disk('public')->delete($paymentMethod->qr_code);
            }

            // Delete the record
            $paymentMethod->delete();

            return redirect()->back()->with(['message' => 'Payment method deleted successfully!']);

        } catch (\Exception $e) {
            $message = 'Error deleting payment method!';
            
            return redirect()->back()->withErrors(['message' => $message]);
        }
    }

}
