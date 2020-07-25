<?php

namespace App\Http\Controllers;
use App\Events\SaleCreatedEvent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use \App\Sale;
use \App\Item;
use DB;
class SaleController extends Controller
{
   public function index()
   {    
   	 return view('sales.addSale');
   }
   public function seeSales($id=0)
   {
   		if($id==0)
   		{
   		    if(\Auth::user()->type=='mandwb')
   		    {
   		        $sales=Sale::with('items')->where('user_id',\Auth::user()->id)->latest()->paginate(15);
   		    }
   		    else
   		    {
   			    $sales=Sale::with('items')->latest()->paginate(15);
   		    }
   		}
   		else
   		{
   			$sales=Sale::with('items')->where('id',$id)->paginate(1);
   		}
   		return view('sales.seeSales',compact('sales'));
   }

   public function viewReturned()
	{
		$sales=Sale::where('type','returned_sale')->latest()->paginate(25);
		return view('sales.seeSales',compact('sales'));
  }
  
   public function create(Request $request,$id=0)
   {
      $this->validate($request,[
        "total"=>"required",
        ]);

      if($id==0)
      {
          $sale=new Sale();
          $sale->rate=$request['rate'];
          $sale->user_id=\Auth::user()->id;
          $sale->status=1;
      }
      else{
            $sale=Sale::find($id);
            $sale->items()->detach();
            DB::table('stocks')->where('type',$sale->type)->where('source_id',$sale->id)->delete();
            $sale->items()->detach();
      }

      $howManyItems=$request['howManyItems'];
      $sale->type = $request['type'];
      $sale->description=$request['description'];
      $sale->discount=$request['discount'];
      $sale->dinars=$request['total'];
      $sale->dollars=0;
      $sale->total = $request['total']-$request['discount'];
      $sale->calculatedPaid = $sale->total;
      

		  $sale->save();
		for($i=0; $i<=$howManyItems; $i++)
		{
			if($request->has('barcode'.$i))
			{
        		$barcode = $request['barcode'.$i];
        		$quantity = $request['quantity'.$i];
            $item = Item::find($barcode);
            $ppi = $request['ppi'.$i];
            $singles = $request['singles'.$i];
            $exp = $request['exp'.$i];

				if($barcode==0 || ($quantity==0 && $singles==0))
				{
					continue;
				}

    			$sale->items()->attach($barcode,['ppi'=>$ppi,'quantity'=>$quantity,'singles'=>$singles,'exp'=>$exp]);
			}
		}
    event(new SaleCreatedEVent($sale));
    session()->flash('sale-id',$sale->id);
		return redirect(route('add-sale'));
   }
   
   public function destroy($id)
   {
     $sale = Sale::findOrFail($id);

      DB::table('sale_items')->where('sale_id',$sale->id)->delete();
      Sale::destroy($id);
      DB::table('stocks')->where('type',$sale->type)->where('source_id',$id)->delete();

      return redirect('/sale/seeSales');
   }
   public function salePrint($id)
   {
     	$sale=Sale::with('items')->find($id);
     	return view('sales.salePrint',compact(['sale']));
   }
   public function update(Request $request,$id)
   {
   	    $howManyItems=$request['howManyItems'];
   	    $rate=$request['rate'];
   	    $total=0;    
		$sale=Sale::findOrFail($id);
			
	
		
		if(\Auth::user()->type!='mandwb')
		{
		    $sale->status=$request['status'];
		    $sale->driver=$request['driver'];
		    
		}
		
		$sale->customer_id=$request['customer_id'];
		$sale->description=$request['description'];
	
		$sale->save();
		$sale->items()->detach();
		for($i=0; $i<=$howManyItems; $i++)
		{
			if($request->has('barcode'.$i))
			{
				$barcode=$request['barcode'.$i];
				$quantity=$request['quantity'.$i];
				$discount=$request['discount'.$i];
         $ppi=$request['ppi'.$i];
        $item=Item::notDeleted()->where('barcode',request('barcode'))->get()->first();      
        if($quantity>$item->stock())
        {
          $sale->totalBeforeDiscount-=($quantity*$ppi);
          $quantity=$item->stock();
        }

        if($ppi<$item->min)
        {
          $sale->totalBeforeDiscount-=($quantity*$ppi);
          $ppi=$item->min;
          $sale->totalBeforeDiscount+=($quantity*$ppi);
        }
				if($barcode==0 || $ppi==0 || $quantity==0)
				{
					continue;
				}
				
                $total+=$ppi*$quantity;
				$sale->items()->attach($barcode,['ppi'=>$ppi,'quantity'=>$quantity,'discount'=>$discount]);

				
				
			}
		}
	
		$sale->totalBeforeDiscount=$total;
		$sale->total=$sale->totalBeforeDiscount-($sale->customer->discount * $sale->totalBeforeDiscount/100);
		$sale->discount=$sale->customer->discount;
		$sale->save();
		 return redirect('sale/print/'.$sale->id);
   }

  
   public function mandwbSaleReport(Request $request)
   {

   		$to=$request['to'];
        $from=$request['from'];
   	    $sales=DB::table('sales')
   	    				->where('user_id',$request['user_id'])
   	    				->whereDate('sales.created_at','>=',$from)
                ->whereDate('sales.created_at','<=',$to)
   	    				->join('sale_items','sales.id','=','sale_items.sale_id')
   	    				->join('items','sale_items.item_id','items.id')
   	    				->select(DB::raw('date(sales.created_at) as date'),
   	    						 DB::raw('SUM(sales.total) as total'),
   	    						 DB::raw('COUNT(sale_items.id) as n' ),
   	    						 DB::raw('SUM(sale_items.quantity) as quantity'),
   	    						 DB::raw('SUM(sale_items.quantity * weight) as weight'))

   	    				->groupBy(DB::raw('date'))->orderBy('sales.created_at','desc')->get();
   	   	//$sales->total=$sales->total/$sale->n;
        $user=DB::table('users')->where('id',$request['user_id'])->pluck('name');  
        $user=$user[0]; 
       return view('reports.drivers',compact(['from','to','sales','user']));
   
   	  	// $to=$request['to'];
       //  $from=$request['from'];
   	   //  $sales=DB::table('sales')
   	   //  				->where('user_id',$request['user_id'])
   	   //  				->whereBetween('sales.created_at',[$from,$to])
   	   //  				->select(DB::raw('date(sales.created_at) as date'),
   	   //  						 DB::raw('SUM(sales.total) as total'))
   	   //  				->groupBy(DB::raw('date'))->latest()->get();

   	   // 	//$sales->total=$sales->total/$sale->n;
       //  $user=DB::table('users')->where('id',$request['user_id'])->first()->name;  
       return view('reports.mandwbSales',compact(['from','to','sales','user']));
   }

public function mandwbTotalByDate(Request $request)
{
  $from=$request['from'];
  $to=$request['to'];
  $user=\App\User::find(\Auth::user()->id);

  $saleMoney=$user->sales()->where('status','1')->whereDate('created_at','>=',$from)->sum('total');
  $returnedDinars=$user->debts()->where('status','1')->whereDate('created_at','>=',$from)->sum('dinars');
  $returnedDollars=$user->debts()->where('status','1')->whereDate('created_at','>=',$from)->sum('dollars');
  return view ('reports.mandwbTotalByDate',compact(['from','to','saleMoney','returnedDinars','returnedDollars']));  
}

 public function salesByDate(Request $request)
    {
        $from=$request['from'];
        $to=$request['to'];
        $driver_id=$request['driver_id'];
        if($driver_id=='all')
        {
            $sales=\App\Sale::where('status','1')
                            ->whereDate('created_at','>=',$from)
                            ->whereDate('created_at','<=',$to)
                            ->orderBy('driver')
                            ->get();
        }
        else
        {
            $sales=\App\Sale::where('status','1')
                            ->whereDate('created_at','>=',$from)
                            ->whereDate('created_at','<=',$to)
                            ->where('driver',$driver_id)
                            ->get();
        }
        return view('reports.salesByDate',compact('sales','from','to'));
    }

    public function searchByItem(Request $request)
	{
        $barcode=$request['barcode'];
        if(empty($barcode))
            return redirect('/sale/seeSales');
        $sales=Sale::whereHas('items',function($query) use ($barcode){
		      $query->where('barcode',$barcode); 
		    })->paginate(25);
		return view('sales.seeSales',compact('sales'));
	}

  
    public function search()
    {
      $id=Request('sale_id');
      return redirect('/sale/seeSales/'.$id);
    }

    public function edit($id){
      $sale=Sale::find($id);
      return view('sales.updateSale',compact('sale'));
    }
     
    
}
