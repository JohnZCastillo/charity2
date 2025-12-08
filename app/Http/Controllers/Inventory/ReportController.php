<?php

namespace App\Http\Controllers\Inventory;

use App\Enums\ExpenseType;
use App\Enums\ItemType;
use App\Enums\ReportType;
use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\DonationDriveData;
use App\Models\Expense;
use App\Models\Item;
use App\Models\ItemCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class ReportController extends Controller
{

    public function index(Request $request)
    {

        $validated = $request->validate([
            'date' => 'required|date',
            'type' => 'required',
            'reportType' => ['required', new Enum(ReportType::class)],
        ]);

        switch (ReportType::valueOf($validated['reportType'])) {
            case ReportType::DONOR:
                return $this->donorReport($request);
            case ReportType::RECIPIENT:
                return $this->recipientReport($request);
            default:
                return response()->json(['message' => 'invalid report type'], 400);
        }
    }

    public function generateReport(Request $request)
    {

        try {

            $validated = $request->validate([
                'type' => 'required',
                'from' => 'required',
                'option' => 'nullable'
            ]);

            if ($validated['type'] === 'cash') {
                return  $this->cashReport($validated);
            }

            $from = Carbon::createFromFormat('Y-m', $validated['from'])
                ->startOfMonth()->startOfDay();

            $to = Carbon::createFromFormat('Y-m', $validated['from'])
                ->endOfMonth()->endOfDay();

            $items = Item::where(function ($qb) use ($validated) {
                $qb->where('deleted', false)
                    ->where('status', true)
                    ->where('item_category_id', $validated['type']);
            })
                ->withSum(['stockIns as totalQuantityForMonth' => function ($qb) use ($from, $to) {
                    $qb->whereBetween('created_at', [$from, $to]);
                }], 'active_quantity')
                ->withSum('stockOuts as lessQuantity', 'quantity')
                ->withSum([
                    'stockIns as remainingStock' => function ($qb) {
                        $qb->where('expiration', '>', Carbon::now());
                    }
                ], 'active_quantity')
                ->get();

            $type = ItemCategory::select(['name'])
                ->find($validated['type'])
                ->value('name');

            $now = Carbon::now()->toDate();

            return view('inventory.pdf.generic-report', [
                'items' => $items,
                'from' => $from,
                'generated' => $now,
                'type' => $type,
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function cashReport(array $validated)
    {

        $from = Carbon::createFromFormat('Y-m', $validated['from'])
            ->startOfMonth()->startOfDay();

        $to = Carbon::createFromFormat('Y-m', $validated['from'])
            ->endOfMonth()->endOfDay();

        $totalDonation =  DonationDriveData::select([DB::raw('SUM(amount) as total')])
            ->value('total');

        $totalDonationThisMonth =  DonationDriveData::select([DB::raw('SUM(amount) as total')])
            ->whereBetween('created_at', [$from, $to])
            ->value('total');

        $totalExpenses =  Expense::select([DB::raw('SUM(amount) as total')])
            ->whereBetween('created_at', [$from, $to])
            ->value('total');

        $donations =  DonationDriveData::whereBetween('created_at', [$from, $to])
            ->get();

        $type = $validated['type'];

        $now = Carbon::now()->toDate();

        return view('inventory.pdf.cash-report', [
            'donations' => $donations,
            'expenses' => $totalExpenses,
            'monthlyDonation' => $totalDonationThisMonth,
            'totalDonation' => $totalDonation - $totalExpenses,
            'from' => $from,
            'generated' => $now,
            'type' => $type,
        ]);
    }

    public function downloadReport($items, $from, $now)
    {

        try {

            $html = view('inventory.pdf.generic-report', [
                'items' => $items,
                'from' => $from,
                'generated' => $now
            ])->render();

            $snappdf = new \Beganovich\Snappdf\Snappdf();

            $filename = '/public/inventory-report-' . \Carbon\Carbon::now()->format('Y-m-d') . '.pdf';

            return response()->download($filename, 'report.pdf');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function report()
    {
        try {

            $items = \App\Models\Item::where('deleted', false)
                ->get();

            $html = view('inventory.pdf.report', [
                'date' => \Carbon\Carbon::now(),
                'items' => $items
            ])->render();

            $snappdf = new \Beganovich\Snappdf\Snappdf();

            $filename = '/public/inventory-report-' . \Carbon\Carbon::now()->format('Y-m-d') . '.pdf';

            $pdf = $snappdf
                ->setHtml($html)
                ->save($filename);

            return response()->download($filename, 'report.pdf', [], 'inline');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message' => 'Unable to generate report']);
        }
    }

    private function donorReport(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'type' => 'required',
        ]);

        $itemCategory = ItemCategory::findOrFail($validated['type']);

        $startOfMonth = Carbon::createFromFormat('Y-m', $validated['date'])->startOfMonth()->startOfDay()->format('Y-m-d H:i');
        $endOfMonth = Carbon::createFromFormat('Y-m', $validated['date'])->endOfMonth()->endOfDay()->format('Y-m-d H:i');

        if ($itemCategory->name === 'cash') {
            $items = DonationDriveData::where(function ($query) use ($startOfMonth, $endOfMonth) {
                $query->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                    ->where('confirmed', true);
            })->get();

            return view('inventory.pdf.donor.cash-report', [
                'date' => \Carbon\Carbon::now(),
                'items' => $items,
                'itemCategory' => $itemCategory
            ]);
        }

        $items = Item::with(['donor', 'size', 'stockIns'])
            ->where(function ($query) use ($validated, $startOfMonth, $endOfMonth) {
                $query->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                    ->where('item_category_id', $validated['type']);
            })->get();


        $html = null;

        switch ($itemCategory->name) {
            case  "medicine":
                $html =  view('inventory.pdf.donor.medicine-report', [
                    'date' => \Carbon\Carbon::now(),
                    'items' => $items,
                    'itemCategory' => $itemCategory
                ]);

                break;
            case  "supplies":
                $html =  view('inventory.pdf.donor.supplies-report', [
                    'date' => \Carbon\Carbon::now(),
                    'items' => $items,
                    'itemCategory' => $itemCategory
                ]);

                break;
            case  "clothes":
                $html =  view('inventory.pdf.donor.clothes-report', [
                    'date' => \Carbon\Carbon::now(),
                    'items' => $items,
                    'itemCategory' => $itemCategory
                ]);
                break;
            case  "goods":
                $html =  view('inventory.pdf.donor.goods-report', [
                    'date' => \Carbon\Carbon::now(),
                    'items' => $items,
                    'itemCategory' => $itemCategory
                ]);

                break;
        }

        return  $html;
    }

    private function recipientReport(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'type' => 'required',
        ]);

        $itemCategory = ItemCategory::findOrFail($validated['type']);
        $startOfMonth = Carbon::createFromFormat('Y-m', $validated['date'])->startOfMonth()->startOfDay()->format('Y-m-d H:i');
        $endOfMonth = Carbon::createFromFormat('Y-m', $validated['date'])->endOfMonth()->endOfDay()->format('Y-m-d H:i');

        if ($itemCategory->name === 'cash') {

            $donations = Expense::with(['recipient'])
                ->where(function ($query) use ($startOfMonth, $endOfMonth) {
                    $query->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                        ->where('type', ExpenseType::DONATE->value);
                })->get();

            return view('inventory.pdf.cash-report', [
                'date' => \Carbon\Carbon::now(),
                'donations' => $donations,
                'itemCategory' => $itemCategory
            ]);
        }

        $donations =  Donation::with('recipient', 'item')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->whereHas('item', function ($query) use ($validated) {
                $query->where('item_category_id', $validated['type']);
            })
            ->get();

        $html = null;

        switch ($itemCategory->name) {
            case  "medicine":
                $html = view('inventory.pdf.medicine-report', [
                    'date' => \Carbon\Carbon::now(),
                    'donations' => $donations,
                    'itemCategory' => $itemCategory
                ]);
                break;
            case  "supplies":
                $html = view('inventory.pdf.supplies-report', [
                    'date' => \Carbon\Carbon::now(),
                    'donations' => $donations,
                    'itemCategory' => $itemCategory
                ]);
                break;
            case  "clothes":
                $html = view('inventory.pdf.clothes-report', [
                    'date' => \Carbon\Carbon::now(),
                    'donations' => $donations,
                    'itemCategory' => $itemCategory
                ]);
                break;
            case  "goods":
                $html = view('inventory.pdf.goods-report', [
                    'date' => \Carbon\Carbon::now(),
                    'donations' => $donations,
                    'itemCategory' => $itemCategory
                ]);
                break;
            case  "cash":

                $html = view('inventory.pdf.cash-report', [
                    'date' => \Carbon\Carbon::now(),
                    'donations' => $donations,
                    'itemCategory' => $itemCategory
                ]);

                break;
        }

        return  $html;
    }

    public function testReport(Request $request)
    {
        try {

            $html = "Hello world";
            $snappdf = new \Beganovich\Snappdf\Snappdf();

            $snappdf
                ->setHtml($html)
                ->save('/test.pdf');

            return response()->download('/test.pdf');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}