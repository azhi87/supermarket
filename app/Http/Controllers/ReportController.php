<?php

namespace App\Http\Controllers;

use App\Broken;
use App\Item;
use App\Stock;
use App\Expense;
use App\Payback;
use App\Purchase;
use App\Sale;
use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;

class ReportController extends Controller
{
    public function stockValuation()
    {
        $items = DB::table('stocks')
            ->join('items','stocks.item_id','items.id')
            ->select('items.barcode as barcode')
            ->addSelect('items.name as name')
            ->addSelect('items.purchase_price as ppi')
            ->addSelect(DB::raw('sum(quantity) as stock'))
            ->addSelect(DB::raw('sum(quantity * items.purchase_price) as subtotal'))
            ->groupBy('items.name','items.barcode')
            ->having('stock','>',0)
            ->get();
        return view('reports.stockValuation', compact('items'));
    }

    public function showStock()
    {
        $items = \App\Item::whereHas('stock')->notDeleted()->get();
        return view('reports.stock', compact('items'));
    }

    public function showStockByManufacturer()
    {
        $man_id = Request('manufacturer_id');
        $items = Item::where('manufacturer_id', $man_id)->get();
        return view('reports.stock', compact('items'));
    }


    public function income(Request $request)
    {
        $from = $request['from'];
        $to = $request['to'];
        $sales = \App\Sale::whereDate('created_at', '>=', $request['from'])
            ->whereDate('created_at', '<=', $request['to'])
            ->get();
        return view('reports.income', compact(['from', 'to', 'sales']));
    }
    public function incomeByUser(Request $request)
    {
        $from = $request['from'];
        $to = $request['to'];
        $user_id = $request['user_id'];
        $user = User::find($user_id)->name;
        $sales = DB::table('sales')
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->where('user_id', $user_id)
            ->select('total', 'discount', 'type')
            ->get();
        return view('reports.incomeByUser', compact(['from', 'to', 'sales', 'user']));
    }

    public function stockByItem()
    {
        $barcode = request('barcode');
        $items = Item::where('id', $barcode)->get();
        return view('reports.stock', compact('items'));
    }

    public function supplierDebt()
    {
        $supplier_id = request('supplier_id');
        if ($supplier_id !== '-1')
            $suppliers = Supplier::with(['purchases', 'paybacks'])->where('id', $supplier_id)->get();
        else
            $suppliers = Supplier::with(['purchases', 'paybacks'])->get();

        return view('reports.supplierDebt', compact('suppliers'));
    }

    public function profit()
    {
        $from = request('from');
        $to = request('to');
        $itemProfit = Stock::profit($from, $to);
        $paybackDiscounts = Payback::whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->sum('discount');
        $paybacks = Payback::whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->sum('paid');
        $expenses = Expense::whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->sum(DB::raw('amount / rate'));
        $purchases = Purchase::whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->sum('total');
        $sold = Sale::whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->sum(DB::raw('total / rate'));
        $saleDiscounts = Sale::whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->sum(DB::raw('discount / rate'));
        $brokens = -1 * Stock::whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->whereType('broken')->sum('ppi');
        $profit = $itemProfit - $saleDiscounts + $paybackDiscounts - $expenses - $brokens;
        return view(
            'reports.profits',
            compact('itemProfit', 'paybackDiscounts', 'paybacks', 'expenses', 'purchases', 'sold', 'saleDiscounts', 'profit', 'brokens', 'from', 'to')
        );
    }
}
