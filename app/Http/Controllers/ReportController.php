<?php

namespace App\Http\Controllers;

use App\Item;
use App\Supplier;
use Illuminate\Http\Request;

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

    public function stock(){
        $cat=Request('cat');
        $items=\App\Item::where('category_id',$cat)->get();
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

    public function stockByItem(){
        $barcode = request('barcode');
        $items = Item::where('barcode',$barcode)->get();
        return view('reports.stock',compact('items'));
    }

    public function supplierDebt(){
        $supplier_id=request('supplier_id');
        if($supplier_id !== -1)
            $suppliers=Supplier::with('purchases')->where('id',$supplier_id)->get();
        else
            $suppliers=Supplier::with('purchases')->get();
        return $suppliers;
    }
}