<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Purchase;
use Carbon\Carbon;
use DB;
class PurchaseController extends Controller
{
	public function index($id=0)
	{
		if($id==0)
		{
			$purchases=Purchase::latest()->paginate(50);
		}
		else
		{
			$purchases=Purchase::where('id',$id)->paginate(1);
		}
		
		return view('purchases.seePurchase',compact('purchases'));
	}
    public function add()
	{
		return view('purchases.addPurchase');
	}
	public function store(Request $request)
	{
		$howManyItems=$request['howManyItems'];
		$purchase=new Purchase();
		$purchase->supplier_id=$request['supplier_id'];
		$purchase->invoice_no=$request['invoice_no'];
		$purchase->total=$request['total'];
		$purchase->user_id=\Auth::user()->id;
		$purchase->save();
		for($i=0; $i<=$howManyItems; $i++)
		{
		
			if($request->has('barcode'.$i))
			{

				$barcode=$request['barcode'.$i];
		        $item=\App\Item::find($barcode);
		        $item->sale_price_id=$request['sppi'.$i];
		        $item->purchase_price=$request['ppi'.$i];
				$item->save();
				$quantity=$request['quantity'.$i];
				$ppi=$request['ppi'.$i];
				$exp=$request['exp'.$i];
				$bonus=$request['bonus'.$i];

				if($barcode==0 ||  ($quantity==0 && $bonus==0))
				{
					continue;
				}
				 $purchase->items()->attach($barcode,['ppi'=>$ppi,'quantity'=>$quantity,'bonus'=>$bonus,'exp'=>$exp]);
				 $stock=new \App\Stock();
				 $stock->item_id=$barcode;
				 $stock->exp=$exp;
				 $stock->type="purchase";
				 $stock->source_id=$purchase->id;
				 $stock->quantity=($bonus+$quantity);
				 $stock->description="Add Purchase Invoice";
				 $stock->save();

				
			}
		}
		 return redirect('/purchase/see/'.$purchase->id);
	}
	public function update(Request $request,$id)
	{
		$howManyItems=$request['howManyItems'];
		$purchase=Purchase::find($id);
		$purchase->supplier_id=$request['supplier_id'];
		$purchase->invoice_no=$request['invoice_no'];
		$purchase->total=$request['total'];
		$purchase->user_id=\Auth::user()->id;
		$purchase->save();
		$purchase->items()->detach();
		DB::table('stocks')->where('type','purchase')->where('source_id',$purchase->id)->delete();
		for($i=0; $i<=$howManyItems; $i++)
		{
			if($request->has('barcode'.$i))
			{
				$barcode=$request['barcode'.$i];
			    $item=\App\Item::find($barcode);
		        $item->sale_price_id=$request['sppi'.$i];
		        $item->purchase_price=$request['ppi'.$i];
				$item->save();
				$quantity=$request['quantity'.$i];
				$ppi=$request['ppi'.$i];
				$exp=$request['exp'.$i];
				$bonus=$request['bonus'.$i];

				if($barcode==0 ||  ($quantity==0 && $bonus==0))
				{
					continue;
				}
				 $purchase->items()->attach($barcode,['ppi'=>$ppi,'quantity'=>$quantity,'bonus'=>$bonus,'exp'=>$exp]);
				 $stock=new \App\Stock();
				 $stock->item_id=$barcode;
				 $stock->exp=$exp;
				 $stock->type="purchase";
				 $stock->source_id=$purchase->id;
				 $stock->quantity=$quantity+$bonus;
				 $stock->description="Update Purchase Invoice";
				 $stock->save();
				
			}
		}
		 return redirect('/purchase/see/'.$purchase->id);
	}
	public function edit($id)
	{
		$purchase=Purchase::find($id);
		return view('purchases.updatePurchase',compact('purchase'));
	}
	
	public function search(Request $request)
	{
        $id=$request['purchase_id'];
        $from =$request['start_date'];
        $to=$request['end_date'];
        
		$query=Purchase::query();
		
		if(!empty($id))
	        $query->where('invoice_no','=',$id);
	    
		if(!empty($from))
		    $query->whereDate('created_at','>=',$from);


		if(!empty($to))
		    $query->whereDate('created_at','<=',$to);

		$purchases=$query->paginate(500);
		return view('purchases.purchaseReports',compact('purchases'));
	}
	
	public function searchByItem(Request $request)
	{
        $barcode=$request['barcode'];
        
        if(empty($barcode))
            return redirect('/purchase/see');
            
        
        $purchases=Purchase::whereHas('items',function($query) use ($barcode){
		    $query->where('barcode',$barcode); 
		})->paginate(25);
		return view('purchases.seePurchase',compact('purchases'));
	}
	
	public function delete($id)
	{
		DB::table('purchase_items')->where('purchase_id',$id)->delete();
		Purchase::destroy($id);
		DB::table('stocks')->where('type','purchase')->where('source_id',$id)->delete();
	
		\Session::flash('message','Successfuly Deleted');
		\Session::flash('type','success');
		return redirect('/purchase/see');
	}
}
