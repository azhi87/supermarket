<?php

namespace App\Http\Controllers;
use DB;
use App\Sale;
use Illuminate\Http\Request;
class SearchController extends Controller
{

    public function allProfit(Request $request)
    {
        $from=$request['from'];
        $to=$request['to'];
        $profits=array();
        $profits['xasm']=($this->totalXasm($from,$to));
        $profits['exchange']=($this->totalExchangeByDate($from,$to));
        $profits['expense']=($this->totalExpenseByDate($from,$to));
        $profits['broken']=($this->sumBroken($from,$to));
        $profits['purchase']=($this->totalPurchaseByDate($from,$to));
        $profits['itemProfit']=($this->totalItemProfit($from,$to));
        $profits['sale']=($this->totalSaleByDate($from,$to));

   //     $profits['debt']=($this->totalDebtByDate($from,$to));
        $profits['totalProfit']=$profits['itemProfit']-($profits['xasm']+(-1*$profits['exchange'])+$profits['expense']+$profits['broken']);
        return view('reports.allProfit',compact(['profits','from','to']));
    }
    public function searchSale(Request $request)
    {
     $query=Sale::query();
        if (!empty($request['sale_id']) )
            $query->where('id',$request['sale_id']);
            
        if (!\Auth::user()->type=='admin') 
            $query->where('user_id',Auth::user()->id);
            
        elseif(!empty($request['user_id']))
            $query->where('user_id',$request['user_id']);

        if (!empty($request['from'])) 
            $query->whereDate('created_at','>=',$request['from']);
            
        
        if (!empty($request['to'])) 
            $query->whereDate('created_at','<=',$request['to']);

       
           $sales=$query->with('items')->paginate(30);

           $sales->setPath('/sale/seeSales');
        
        return view('sales.seeSales',compact('sales'));
   		
    	return view('sales.seeSales',compact('sales'));
    }

    public function totalSaleByDate($from,$to)
    {
        return DB::table('sales')->where('created_at','>=',$from)
                          ->where('created_at','<=',$to)
                                        ->sum('total');
    }
    public function totalPurchaseByDate($from,$to)
    {
        return DB::table('purchases')->where('created_at','>=',$from)
                          ->where('created_at','<=',$to)
                                        ->sum('total');
    }
    
   
    
    public function totalExpenseByDate($from,$to)
    {
        return DB::table('expenses')->whereDate('created_at','>=',$from)
                          ->whereDate('created_at','<=',$to)->sum('amount');
    }

    public function totalExchangeByDate($from,$to)
    {
        return DB::table('exchanges')->whereDate('created_at','>=',$from)
                                     ->whereDate('created_at','<=',$to)->sum('profit');
    }

     public function sumBroken($from,$to)
    {
    
        return DB::table('brokens')->whereDate('brokens.created_at','>=',$from)
                                   ->whereDate('brokens.created_at','<=',$to)
                                   ->join('items','brokens.item_id','items.id')
                        ->select(DB::raw('SUM(brokens.quantity * items.purchase_price) as total'))->first()->total;


    }
      public function totalXasm($from,$to)
    {
        $items=\App\Item::all();
        $result=0;
        foreach($items as $item)
        {
           $result+= $item->totalProfitWithoutDiscount($from,$to) - $item->totalProfit($from,$to);
        }
        return $result;
    }

    public function totalItemProfit($from,$to)
    {
        $items=\App\Item::all();
        $result=0;
        foreach($items as $item)
        {
           $result+=$item->totalProfitWithoutDiscount($from,$to);
        }
        return $result-$this->totalCustomerDiscount($from,$to);
    }
    public function today()
    {
        $Sales=\App\Patient::where('created_at','>=',Carbon::today())->orderBy('created_at')->get();
        return view('today',compact('patients'));
    }
    
/*     public function totalDebtByDate($from,$to)
    {
        return DB::table('debts')->whereDate('created_at','>=',$from)
                          ->whereDate('created_at','<=',$to)->sum('calculatedPaid');
        -
        return DB::table('sales')->where('created_at','>=',$from)
        ->where('created_at','<=',$to)
                      ->sum('calculated');

    } */
}
