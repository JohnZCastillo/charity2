<?php

namespace App\Http\Controllers;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Helpers\IdHelper;
use App\Models\Account;
use App\Models\Address;
use App\Models\Recipient;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RecipientController extends Controller
{
    public function index(Request $request)
    {
        $query = Account::query();

        $query->when($request->input('search'), function ($query) use ($request) {
            $query->where(function ($query) use ($request) {

                $id = $request->input('search');

                $query->whereLike('id', '%' . IdHelper::parse($id,'BN'). '%');

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

        $query->whereIn('type', [UserType::RECIPIENT->value]);
        $query->with(['address']);

        $recipients = $query->paginate();

        return view('inventory.recipients', [
            'recipients' => $recipients,
        ]);
    }

    public function addRecipient(Request $request)
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
                // other rules
            ]);

            $validated['type'] = UserType::RECIPIENT->value;

            $account = Account::create($validated);

            Address::create([
                'account_id' => $account->id,
                'address' => $validated['address'],
            ]);

            DB::commit();

            return redirect()->back()->with(['message' => 'Recipient account created']);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => 'Unable to create recipient account']);
        }
    }

    public function getRecipient($recipientID)
    {
        $recipient = Account::findOrFail($recipientID);

        return view('inventory.edit-recipient', [
            'recipient' => $recipient
        ]);
    }

    public function deleteRecipient($recipientID)
{
    try {
        DB::beginTransaction();

        // Delete related addresses
        Address::where('account_id', $recipientID)->delete();

        // Delete related items (if applicable)
        Item::where('account_id', $recipientID)->delete();

        // Delete the account itself
        $account = Account::findOrFail($recipientID);
        $account->delete();

        DB::commit();

        return redirect()->back()->with('message', 'Recipient deleted successfully.');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->withErrors(['message' => $e->getMessage()]);
    }
}


    public function updateRecipient(Request $request, $donorID)
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
