<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function stockExpiry(Request $request)
    {
    	$date=$request['date'];
    	$items=DB::table('stocks')->whereDate('exp','<=',$date)
                                ->select('item_id as id','exp',DB::raw('sum(quantity) as quantity'))
                                ->groupBy('item_id','exp')
                                ->get();

        return view('reports.stockExpiry',compact('items'));
    }
}
