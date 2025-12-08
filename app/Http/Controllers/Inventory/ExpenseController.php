<?php

namespace App\Http\Controllers\Inventory;

use App\Enums\ExpenseType;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{

    public function donate(Request $request)
    {
        try {

            $validated = $request->validate([
                'recipient' => 'required',
                'amount' => 'required',
                'purpose' => 'required|string',
            ]);

            DB::beginTransaction();

            $recipient = Account::findOrFail($validated['recipient']);

            Expense::create([
                'amount' => $validated['amount'],
                'purpose' => $validated['purpose'],
                'type' => ExpenseType::DONATE->value,
                'account_id' => $recipient->id,
            ]);

            DB::commit();

            return redirect()->back()->with(['message' => 'donation success']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => 'Something went wrong while processing donation!']);
        }
    }

    public function expense(Request $request)
    {
        try {

            $validated = $request->validate([
                'receipt' => 'file',
                'purpose' => 'required',
                'amount' => 'required'
            ]);

            DB::beginTransaction();

            $filename = $request->file('receipt')->store('public');

            if (!$filename) {
                throw new \Exception('Unable to save receipt');
            }

            Expense::create([
                'amount' => $validated['amount'],
                'purpose' => $validated['purpose'],
                'type' => ExpenseType::EXPENSE->value,
                'receipt' => $filename,
            ]);

            DB::commit();

            return redirect()->back()->with(['message' => 'Expense added']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => 'Something went wrong while expense!']);
        }
    }
}