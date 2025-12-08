<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index()
    {
        $user = User::findOrFail(1);

        return view('inventory.account', [
            'user' => $user
        ]);
    }

    public function updateAccount(Request $request)
    {

        try {

            $validated = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
            ]);

            $user = Auth::user();

            $user->fill($validated);
            $user->save();

            return redirect()->back()->with(['message' => 'Account updated!']);

        } catch (\Exception $e) {

            $message = $e->getMessage();

            if ($e->getCode() == 23000) { // Integrity constraint violation
                $message = 'User email is already taken!';
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
}
