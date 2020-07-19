<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class BrokenController extends Controller
{
    public function index()
	{

		$brokens=\App\Broken::latest()->paginate(366);
		return view('items.brokens',compact('brokens'));
	}

	public function edit($id=0)
	{
		$broken=\App\Broken::find($id);
		return view('items.updateBroken',compact('broken'));
	}

	public function store(Request $request,$id=0)
	{
		$this->validate(request(),[
			'barcode'=>'required',
			'quantity'=>'required|numeric',
			'singles'=>'required|numeric',
			]);
		if($id==0)
		{
			$broken=new \App\Broken();
		}
		else
		{
			$broken=\App\Broken::find($id);
            DB::table('stocks')->where('type','broken')->where('source_id',$id)->delete();

		}
		$broken->item_id=$request['barcode'];
		$item=\App\Item::find($request['barcode']);
		$broken->quantity=$request['quantity'];
		$broken->singles=$request['singles'];
		$broken->exp=$request['exp'];
		$broken->user_id=\Auth::user()->id;
		$broken->save();
		 $stock=new \App\Stock();
         $stock->item_id=$request['barcode'];
         $stock->exp=$request['exp'];
         $stock->type="broken";
         $stock->source_id=$broken->id;
         $stock->quantity=-($request['quantity']+($request['singles']/$item->items_per_box));
         $stock->description="زیادکردنی وەصلی تەلەف";
         $stock->save();
		return redirect('/broken');
	}
	public function search(Request $request)
	{
		$brokens=\App\Broken::where('item_id',$request['barcode'])->get();
		return view('items.brokens',compact('brokens'));
	}
	public function searchByDate(Request $request)
	{
		$from=$request['from'];
		$to=$request['to'];
		$brokens=\App\Broken::whereDate('created_at','>=',$from)
                             ->whereDate('created_at','<=',$to)
                             ->get();
		return view('items.brokens',compact('brokens'));
	}
}