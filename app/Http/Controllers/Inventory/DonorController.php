<?php

namespace App\Http\Controllers\Inventory;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Address;
use App\Models\Donor;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class DonorController extends Controller
{

    public function index(Request $request)
    {
        $query = Account::query();

        $query->when($request->input('search'), function ($query) use ($request) {
            $query->where(function ($query) use ($request) {
                $query->whereLike('code', '%' . $request->input('search') . '%');
                $query->orWhereLike('name', '%' . $request->input('search') . '%');
                $query->orWhereLike('email', '%' . $request->input('search') . '%');
                $query->orWhereLike('mobile', '%' . $request->input('search') . '%');
            });
        });

        $query->when($request->input('status') && $request->input('status') != 'ALL', function ($query) use ($request) {
            $query->where('status', UserStatus::valueOf($request->input('status')));
        });

        $query->when($request->input('order'), function ($query) use ($request) {
            $query->orderBy($request->input('order'), $request->input('sort'));
        });

        $query->whereIn('type', [UserType::DONOR->value]);
        $query->with(['address']);

        $donors = $query->paginate();

        return view('inventory.donors', [
            'donors' => $donors,
        ]);
    }

    public function addDonor(Request $request)
{
    try {
        DB::beginTransaction();

        $validated = $request->validate([
            'code' => 'required|unique:accounts',
            'name' => 'required|string',
            'mobile' => 'required|string',
            'email' => 'nullable|email',
            'status' => [Rule::enum(UserStatus::class)],
            'address' => 'required|string',
        ]);

        // Set donor type explicitly
        $validated['type'] = UserType::DONOR->value;

        $account = Account::create($validated);

        Address::create([
            'account_id' => $account->id,
            'address' => $validated['address'],
        ]);

        DB::commit();

        return redirect()->back()->with(['message' => 'Donor account created']);

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->withErrors(['message' => $e->getMessage()]);  // Show actual error temporarily
    }
}

    public function deleteDonor($donorID)
{
    try {
        DB::beginTransaction();

        // Delete related addresses
        Address::where('account_id', $donorID)->delete();

        // Delete related items (if any)
        Item::where('account_id', $donorID)->delete();

        // Delete the donor account
        $account = Account::findOrFail($donorID);
        $account->delete();

        DB::commit();

        return redirect()->back()->with(['message' => 'Donor deleted successfully.']);
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->withErrors(['message' => $e->getMessage()]);
    }
}

    public function updateDonor(Request $request, $donorID)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'code' => [
                    'required',
                    Rule::unique('accounts')->ignore($donorID),
                ],
                'name' => 'required|string',
                'mobile' => 'required|string',
                'email' => [
                    'nullable',
                    'email',
                    Rule::unique('accounts')->ignore($donorID),
                ],
                'status' => [Rule::enum(UserStatus::class)],
                'address' => 'required|string',
            ],[
                'code.unique' => 'Code is already taken',
                'email.unique' => 'Email is already taken',
            ]);

            Address::where('account_id', $donorID)
                ->update([
                    'address' => $validated['address'],
                ]);

            $account = Account::findOrFail($donorID);

            $account->fill($validated);
            $account->save();

            DB::commit();

            return redirect()->back()->with(['message' => 'updated!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }

}
