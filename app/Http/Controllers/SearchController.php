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

        //$profits['exchange']=($this->totalExchangeByDate($from,$to));
       
        $profits['expense']=($this->totalExpenseByDate($from,$to));
       // $profits['broken']=($this->sumBroken($from,$to));
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

    public function getTotalSales($from,$to)
    {
        return DB::table('sales')->where('type','sale')->where('created_at','>=',$from)
                          ->where('created_at','<=',$to)
                                        ->sum('total');
    }

    public function getTotalReturnedSales($from,$to){
        return DB::table('sales')->where('type','returned_sale')->where('created_at','>=',$from)
                          ->where('created_at','<=',$to)
                                        ->sum('total');
    }
    public function getTotalPurchase($from,$to)
    {
        return DB::table('purchases')->where('type','purchase')->where('created_at','>=',$from)
                          ->where('created_at','<=',$to)
                                        ->sum('total');
    }

     public function getTotalReturnedPurchases($from,$to)
    {
        return DB::table('purchases')
                            ->where('type','returned_purchase')
                            ->where('created_at','>=',$from)
                            ->where('created_at','<=',$to)
                            ->sum('total');
    }

    public function totalExpenseByDate($from,$to)
    {
        return DB::table('expenses')
                    ->whereDate('created_at','>=',$from)
                    ->whereDate('created_at','<=',$to)
                    ->sum('amount');
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
}
    

