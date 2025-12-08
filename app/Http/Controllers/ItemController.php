<?php

namespace App\Http\Controllers;

use App\Enums\ItemStatus;
use App\Enums\UserType;
use App\Models\Account;
use App\Models\Item;
use App\Models\ItemAttachment;
use App\Models\ItemCategory;
use App\Models\ItemGender;
use App\Models\ItemSize;
use App\Models\ItemStockIn;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Nette\Utils\Paginator;

class ItemController extends Controller
{
    public function index(Request $request)
    {

        $query = Item::query();

        $query->with(['stockIns', 'donor', 'category', 'size', 'gender']);

        $query->where('deleted', 0);

        $query->withSum([
        'stockIns as quantity' => function ($qb) {
            $qb->where('expiration', '>', Carbon::now());
        }
    ], 'active_quantity');

        $query->when($request->input('status') && $request->input('status') != 'ALL', function ($qb) use ($request) {
            $qb->where('status', ItemStatus::valueOf($request->input('status')));
        });

        $query->when($request->input('search'), function ($qb) use ($request) {
            $qb->where(function ($qb) use ($request) {
                $qb->whereLike('items.code', '%' . $request->input('search') . '%');
                $qb->orWhereLike('items.name', '%' . $request->input('search') . '%');
                $qb->orWhereLike('items.description', '%' . $request->input('search') . '%');
                $qb->orWhereLike('items.status', '%' . $request->input('search') . '%');
            });
        });

        $query->when($request->input('order'), function ($qb) use ($request) {
            $qb->orderBy('quantity', $request->input('sort'));
        });

        $items = $query->paginate(9)->appends($request->except('page'));

        $categories = ItemCategory::select(['id', 'name'])
            ->get();

        $genders = ItemGender::select(['id', 'name'])
            ->get();

        $sizes = ItemSize::select(['id', 'name'])
            ->get();

        $donors = Account::select(['id', 'name'])
            ->where('type', UserType::DONOR)
            ->get();

        return view('inventory.items', [
            'items' => $items,
            'categories' => $categories,
            'genders' => $genders,
            'sizes' => $sizes,
            'donors' => $donors,
        ]);
    }

    public function addItem(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:items,code',
            'name' => 'required',
            'description' => 'required',
            'status' => [Rule::enum(ItemStatus::class)],
            'stock' => 'required|integer',
            'expiration' => 'nullable|date',
            'category' => 'required',
            'gender' => 'nullable',
            'size' => 'nullable',
            'account_id' => 'nullable',
        ]);

        try {

            DB::beginTransaction();

            $item = new Item();

            $item->fill($validated);

            $category = ItemCategory::firstOrCreate(['name' => $validated['category']]);

            $item->item_category_id = $category->id;

            if ($request->filled('gender')) {
                $gender = ItemGender::firstOrCreate(['name' => $validated['gender']]);
                $item->item_gender_id = $gender->id;
            }

            if ($request->filled('size')) {
                $size = ItemSize::firstOrCreate(['name' => $validated['size']]);
                $item->item_size_id = $size->id;
            }

            if ($request->filled('account_id')) {
                $item->account_id = $validated['account_id'];
            }

            $item->save();

            ItemStockIn::create([
                'item_id' => $item->id,
                'quantity' => $validated['stock'],
                'active_quantity' => $validated['stock'],
                'expiration' => $validated['expiration'],
            ]);

            DB::commit();

            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['errors' => $e->getMessage()]);
        }
    }

    public function deleteItem(Item $item)
    {

        try {
            DB::beginTransaction();

            $item->deleted = true;
            $item->save();

            DB::commit();

            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['errors' => $e->getMessage()]);
        }
    }

    public function viewItem(Item $item)
    {
        return view('inventory.item', [
            'item' => $item
        ]);

    }

    public function addStock(Request $request)
    {
        try {

            $validated = $request->validate([
                'item_id' => 'required',
                'quantity' => 'required',
                'expiration' => 'nullable',
            ]);

            DB::beginTransaction();

            $expiration = '';

            if ($request->filled('expiration')) {
                $expiration = $validated['expiration'];
            }

            ItemStockIn::create([
                'quantity' => $validated['quantity'],
                'active_quantity' => $validated['quantity'],
                'expiration' => $expiration,
                'item_id' => $validated['item_id'],
            ]);

            DB::commit();

            return redirect()->back()->with('success','Stock Added!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => 'Something went wrong while adding stock']);
        }
    }


    public function updateItem(Request $request, Item $item)
    {

        try {

            DB::beginTransaction();

            $validated = $request->validate([
                'image' => 'nullable|image:png,jpeg,jpg',
                'code' => 'required|string|unique:items',
                'name' => 'required|string',
                'description' => 'required|string',
                'status' => 'required',
            ]);

            $item->name = $validated['name'];
            $item->description = $validated['description'];
            $item->status = $validated['status'];

            if ($item->code != $validated['code']) {
                $item->code = $validated['code'];
            }

            if ($request->file('image')) {
                $attachment = $item->attachment;
                $attachment->file = $request->file('image')->store('public');
                $attachment->save();
            }

            $item->save();

            DB::commit();

            return redirect()->back()->with(['message' => 'item updated']);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }

    }

}
