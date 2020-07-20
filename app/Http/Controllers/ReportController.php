<?php

namespace App\Http\Controllers;

use App\Item;
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

    public function stockByItem(){
        $barcode = request('barcode');
        $items = Item::where('barcode',$barcode)->get();
        return view('reports.stock',compact('items'));
    }
}
