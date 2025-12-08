<?php

namespace App\Http\Controllers\Inventory;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{

    public function index(Request $request)
    {

        if (Gate::denies('view', Auth::user())) {
            abort(403);
        }

        $users = User::where(function ($query) {
            $query->where('role', UserRole::STAFF)
                ->where('archived', false);
        })
            ->when($request->input('search'), function ($qb) use ($request) {
                $qb->where(function ($qb) use ($request) {
                    $qb->orWhereLike('name', '%' . $request->input('search') . '%');
                    $qb->orWhereLike('email', '%' . $request->input('search') . '%');
                });
            })
            ->when($request->input('order'), function ($qb) use ($request) {
                $qb->orderBy($request->input('order'), $request->input('sort'));
            })
            ->paginate(10)
            ->appends($request->except('page'));

        return view('inventory.users', [
            'users' => $users,
        ]);
    }

    public function addUser(Request $request)
    {
        try {

            if (Gate::denies('add', Auth::user())) {
                abort(403);
            }

            DB::beginTransaction();

            $validated = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'password' => 'required',
                'password2' => 'required|same:password',
            ], [
                'same' => 'Password and Confirm password does not match'
            ]);

            User::create($validated);

            DB::commit();

            return redirect()->back()->with(['message' => 'user added!']);
        } catch (\Exception $e) {

            DB::rollBack();

            $message = $e->getMessage();

            if ($e->getCode() == 23000) { // Integrity constraint violation
                $message = 'User email is already taken!';
            }

            return redirect()->back()->withErrors(['message' => $message]);
        }
    }

    public function archivedUser(User $user)
    {
        try {

            if (Gate::denies('update', Auth::user())) {
                abort(403);
            }

            DB::beginTransaction();

            $user->archived = true;
            $user->save();

            DB::commit();

            return redirect()->back()->with(['message' => 'user archived success!']);
        } catch (\Exception $e) {

            DB::rollBack();

            $message = 'Something went wrong while archiving user';

            return redirect()->back()->withErrors(['message' => $message]);
        }
    }

    public function unArchivedUser(User $user)
    {
        try {

            if (Gate::denies('update', Auth::user())) {
                abort(403);
            }

            DB::beginTransaction();

            $user->archived = false;
            $user->save();

            DB::commit();

            return redirect()->back()->with(['message' => 'user unarchived success!']);
        } catch (\Exception $e) {

            DB::rollBack();

            $message = 'Something went wrong while un-archiving user';

            return redirect()->back()->withErrors(['message' => $message]);
        }
    }
}