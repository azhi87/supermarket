<?php

namespace App\Http\Controllers;

use DB;
use App\Item;
use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;

class ReportController extends Controller
{
    public function stockValuation(){
        $items=\App\Item::notDeleted()->get();
		return view('reports.stockValuation',compact('items'));
    }

    public function showStock(){
        $items=\App\Item::whereHas('stock')->notDeleted()->get();
		return view('reports.stock',compact('items'));
    }

    public function showStockByManufacturer(){
        $man_id=Request('manufacturer_id');
        $items=Item::where('manufacturer_id',$man_id)->get();
        return view('reports.stock',compact('items'));
    }


    	public function income(Request $request) {

            $from=$request['from'];
            $to=$request['to'];
            $sales=\App\Sale::whereDate('created_at','>=',$request['from'])
                             ->whereDate('created_at','<=',$request['to'])
                             ->get();
        return view('reports.income',compact(['from','to','sales']));

    }
    public function incomeByUser(Request $request) {

    $from=$request['from'];
    $to=$request['to'];
    $user_id=$request['user_id'];
    $user=User::find($user_id)->name;
    $sales=DB::table('sales')
                ->whereDate('created_at','>=',$from)
                ->whereDate('created_at','<=',$to)
                ->where('user_id',$user_id)
                ->select('total','discount','type')
                ->get();
        return view('reports.incomeByUser',compact(['from','to','sales','user']));

        }

    public function stockByItem(){
        $barcode = request('barcode');
        $items = Item::where('id',$barcode)->get();
        return view('reports.stock',compact('items'));
    }

    public function supplierDebt(){
        $supplier_id=request('supplier_id');
        if($supplier_id !== '-1')
            $suppliers=Supplier::with(['purchases','paybacks'])->where('id',$supplier_id)->get();
        else
            $suppliers=Supplier::with(['purchases','paybacks'])->get();
        return view('reports.supplierDebt',compact('suppliers'));
    }
}
