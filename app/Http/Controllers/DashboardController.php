<?php

namespace App\Http\Controllers;

use App\Enums\ItemStatus;
use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\Account;
use App\Models\Appointment;
use App\Models\Donation;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\ItemStockIn;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ActivityLog;
use App\Models\Inquiry;

class DashboardController extends Controller
{
    public function index()
    {
        $donutChartIds = [];
        $donutChartHeader = [];
        $donutChartValues = [];
        $newItemsCount = [];
        $lineChartLabel = [];

        $donors = Account::select(DB::raw('COUNT(id) as total_count'))
            ->where('type', UserType::DONOR->value)
            ->where('status', UserStatus::ENABLED->value)
            ->value('total_count');

        $recipients = Account::select(DB::raw('COUNT(id) as total_count'))
            ->where('type', UserType::RECIPIENT->value)
            ->where('status', UserStatus::ENABLED->value)
            ->value('total_count');

        $items = Item::select(DB::raw('COUNT(id) as total_count'))
            ->where('deleted', false)
            ->where('status', ItemStatus::ENABLED->value)
            ->value('total_count');

        $StockItems = Item::select(['id', 'name', 'code'])
            ->withSum('stocks as active_stock', 'active_quantity')  
            ->where('deleted', false)
            ->where('status', ItemStatus::ENABLED->value)
            ->get();

        $lowStockItem = Item::select(['id', 'name', 'code'])
        ->withSum('stocks as active_stock', 'active_quantity')
        ->where('deleted', false)
        ->where('status', ItemStatus::ENABLED->value)
        ->having('active_stock', '<', 20)
        ->orderBy('active_stock', 'asc')
        ->get();

        $itemsStock = Item::with('stocks')
            ->where('deleted', false)
            ->where('status', ItemStatus::ENABLED->value)
            ->get();

        $othersItemStock = ItemStockIn::select([DB::raw('SUM(active_quantity) as total_stock')])
            ->whereHas('item', function ($qb) use ($donutChartIds) {
                $qb->where('status', ItemStatus::ENABLED->value)
                    ->where('deleted', false)
                    ->whereIn('id', $donutChartIds);
            })
            ->value('total_stock');

        foreach ($itemsStock as $index => $item) {
            $donutChartIds[$index] = $item->id;
            $donutChartHeader[$index] = $item->name;
            $donutChartValues[$index] = $item->stock;
        }

        if ($othersItemStock) {
            $donutChartHeader[count($donutChartIds)] = 'Others';
            $donutChartValues[count($donutChartIds)] = $othersItemStock;
        }

        $months = [];
        $donatedItems = [];

        $period = CarbonPeriod::create(Carbon::now()->startOfYear(), '1 month', Carbon::now());

        foreach ($period as $index => $date) {
            $months[$index] = $date->format('M');

            $donatedItems[$index] = Donation::select([DB::raw('SUM(quantity) as donation')])
                ->whereDate('created_at', '>=', $date->firstOfMonth()->format('Y-m-d H:i'))
                ->whereDate('created_at', '<=', $date->endOfMonth()->format('Y-m-d H:i'))
                ->value('donation') ?? 0;

            $newItemsCount[$index] = Item::select([DB::raw('COUNT(id) as total')])
                ->whereDate('created_at', '>=', $date->firstOfMonth()->format('Y-m-d H:i'))
                ->whereDate('created_at', '<=', $date->endOfMonth()->format('Y-m-d H:i'))
                ->value('total');

            $lineChartLabel[$index] = $date->format('Y-m');

        }

        $types = ItemCategory::select(['id','name'])
            ->get();

        $startDate = Carbon::now()->subMonths(3)->startOfMonth()->startOfDay()->format('Y-m-d H:m');
        $endDate = Carbon::now()->endOfMonth()->endOfDay()->format('Y-m-d H:m');
      
        $donatedItemHistory = DB::select("
            SELECT i.name as name, sum(d.quantity) as total from donations d
            LEFT JOIN items i on i.id = d.item_id
            where i.created_at between :start and :end
            group by i.id, i.name
        ",[
            'start' => $startDate,
            'end' => $endDate
        ]);

        // dd($donatedItemHistory);

        $itemsCountCategory = Item::select(
            'item_category_id',
            DB::raw(
                'COUNT(id) as total'
            )
        )
            ->groupBy('item_category_id')
            ->orderBy('item_category_id','desc')
            ->get()
            ->toArray();

        $totalAppointment = Appointment::count();
            
        $itemCategories = ItemCategory::select('id','name')
            ->whereIn('id',array_map(fn($value)=>$value['item_category_id'], $itemsCountCategory))
            ->orderBy('id','desc')->get()->toArray();

        $stocksPerCategory =  DB::table('item_stock_ins')
            ->select(DB::raw('SUM(active_quantity) as stock'), 'item_categories.id as category_id')
            ->join('items', 'item_stock_ins.item_id', '=', 'items.id')
            ->join('item_categories','items.item_category_id','=','item_categories.id')
            ->groupBy('item_categories.id')
            ->orderBy('item_categories.id','desc')
            ->get()
            ->toArray();

        $stocksPerCategoryLabel = ItemCategory::select('id','name')
            ->whereIn('id',array_map(fn($value)=>$value->category_id, $stocksPerCategory))
            ->orderBy('id','desc')->get()->toArray();

        $itemCategoryType = ItemCategory::get();
        
        $inquiries = Inquiry::where('is_read', false)->count();

        $queryAppointment = Appointment::select('id', 'name', 'date', 'start', 'end')
        ->where('status', 'confirmed');

        // if ($request->has('filter') && $request->filter === 'monthly') {
        //     $queryAppointment->whereMonth('date', now()->month)
        //         ->whereYear('date', now()->year);
        // }

        $confirmedAppointments = $queryAppointment->get();

          ActivityLog::create([
             'user_id' => auth()->user()->id,
            'activity' => 'Visited Dashboard.'
        ]);

        return view('dashboard', [
            'donors' => $donors,
            'recipients' => $recipients,
            'items' => $items,
            'StockItems' => $StockItems,
            'donutChartHeaders' => $donutChartHeader,
            'donutChartValues' => $donutChartValues,
            'barChartLabels' => $months,
            'barChartValues' => $donatedItems,
            'newItemsCount' => $newItemsCount,
            'lineChartLabel' => $lineChartLabel,
            'types' => $types,
            'totalAppointment' => $totalAppointment,
            'itemCategories' => $itemCategories,
            'itemsCountCategory' => $itemsCountCategory,
            'stocksPerCategory' => $stocksPerCategory,
            'stocksPerCategoryLabel' => $stocksPerCategoryLabel,
            'itemCategoryType' => $itemCategoryType,
            'inquiries' => $inquiries,
            'confirmedAppointments' => $confirmedAppointments,
            'lowStockItem' => $lowStockItem,
            'donatedItemHistory' => $donatedItemHistory, 
        ]);
    }
}