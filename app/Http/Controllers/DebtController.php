<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use \App\Customer;
use \App\Debt;
use Illuminate\Http\Request;
use Redirect;
use DB;
class DebtController extends Controller
{
	public function index($id=0)
	{
		if($id==0)
		{
		return view('customers.debts');
		}
		else
		{
			$customer=Customer::find($id);
			return view('customers.debts',compact('customer'));
		}
	}
	
	public function search(Request $request)
	{

		if($request->has('customer_id'))
		{
			$customer=Customer::find($request['customer_id']);

		}
		elseif($request->has('name'))
		{
			$customer=Customer::where('name','LIKE','%'.$request['name'].'%')->first();
		}
		else
		{
			\Session::flash('message','تکایە کۆدی کڕیار داخڵبکە');
			return redirect('/debts');
		}
		if(!count($customer))
		{
			\Session::flash('message','کۆدی کڕیار هەڵەیە');
			return redirect('/debts');
		}
		
		else
		{
		return redirect('/debts/'.$customer->id);
		}
	}
	
	public function store(Request $request,$id=0)
	{
		//dd($request);
		$this->validate($request,[
    		"customer_id"=>"required",
    		"dinars"=>"required",
            "dollars"=>"required",
            "calculatedPaid"=>"required",
    		]);
		if($id==0)
		{
			$debt=new Debt();
			$debt->customer_id=$request['customer_id'];
		    $customer=\App\Customer::find($debt->customer_id);
		    if($customer->hasUnConfirmedDebts() && \Auth::user()->type=="mandwb")
			{
			    \Session::flash('message', 'ناتوانی لە ئێستادا قەرزدانەوە تۆمار بکەیت');
			    return back();
			}
			
			$debt->user_id=\Auth::user()->id;
			$debt->rate=$request['rate'];
			
		}
		else
		{
			$debt=Debt::find($id);
			if($debt->status=='0' && $request['status']=='1')
    		{
    		    $debt->created_at = Carbon::now();
    		}
			$debt->status=1;
			$customer=\App\Customer::find($debt->customer_id);
			$debt->new_total_debt=$debt->new_total_debt+$debt->calculatedPaid;
		}

		
		$debt->dinars=$request['dinars'];
		$debt->dollars=$request['dollars'];
		$debt->description=$request['description'];
		$debt->calculatedPaid=$request['dollars']+($request['dinars']/$request['rate']);
		
		if($id==0)
		{
			$debt->new_total_debt=$customer->customerDebt()-$debt->calculatedPaid;
			 $debt->user_sequence=\Auth::user()->debts->count();
		}
		else
		{
		    $debt->new_total_debt=$customer->customerDebt()-$debt->calculatedPaid;
		}
		 if(($customer->customerDebt() - $debt->calculatedPaid) <= $customer->maxDebt)
	    {
	    	$customer->status="active";
	    	$customer->save();
	    }
       
		$debt->save();
		
		return redirect('/debts/'.$request['customer_id']);
	}
	public function income(Request $request)
    {
    	$debt=new \App\Debt();
        	$from=$request['from'];
        	$to=$request['to'];
        	$debts=$debt->whereDate('created_at','>=',$request['from'])
        			   ->whereDate('created_at','<=',$request['to'])->get();
        $sales=\App\Sale::whereDate('created_at','>=',$request['from'])
        			   ->whereDate('created_at','<=',$request['to'])->get();
        return view('reports.income',compact(['debts','from','to','sales']));

    }
    public function money()
    {
    
        	$debt=new \App\Debt();
        	$yesterday=Carbon::now()->subDay();
            
        	$oldDebts=$debt->whereDate('created_at','<=',$yesterday)
        			   ->sum('calculatedPaid');
  
            $oldSales=\App\Sale::whereDate('created_at','<=',$yesterday)->sum('total');
           
            $todayDebts=$debt->whereDate('created_at','>',$yesterday)
        			   ->sum('calculatedPaid');

					   $todaySales=\App\Sale::whereDate('created_at','>',$yesterday)
							->sum('total');
							
			$allincomeSales=\App\Sale::sum('calculatedPaid');
	 
			$allincomeDebts=\App\Debt::sum('calculatedPaid');
					
			return view('reports.money',compact(['oldSales','oldDebts','todaySales','todayDebts','allincomeSales','allincomeDebts']));     			   	
	}
	
    public function thresholdReport(Request $request)
    {
        $debts=\App\Customer::all();
        if($request->has('from'))
        {
        	$from=date("Y-m-d H:i:s",strtotime($request['from']));
        	$predebt=true;
        	$debts= DB::select( DB::raw("
       		select id,name,
			(
			    SELECT IFNULL(sum(total),0) FROM sales where sales.customer_id=customers.id 
			)
			-
			(
			   SELECT  IFNULL(SUM(calculatedPaid),0) from debts where customers.id=debts.customer_id 
			)
			    AS totalDebt,
			(
			    SELECT IFNULL(sum(total),0) FROM sales where sales.customer_id=customers.id  and created_at<='".$from."'
			)
			-
			(
			   SELECT  IFNULL(SUM(calculatedPaid),0) from debts where customers.id=debts.customer_id  and created_at<='".$from."'
			)
			  as predebt

			     from customers 
			    GROUP BY customers.id
			    HAVING totalDebt>=".$request['threshold']
       		));
        }
        else
        {

        	$predebt=false;
       	$debts= DB::select( DB::raw("
       		select id,name,
			(
			    SELECT IFNULL(sum(total),0) FROM sales where sales.customer_id=customers.id
			)
			-
			(
			   SELECT  IFNULL(SUM(calculatedPaid),0) from debts where customers.id=debts.customer_id
			)

			    AS totalDebt from customers 
			    GROUP BY customers.id
			    HAVING totalDebt>=".$request['threshold']
       		));
       }
		return view('reports.debtThreshold',compact(['debts','predebt']));        
    }
    public function debtPrint($id)
    {
        $debt=\App\Debt::find($id);
        return view('customers.debtPrint',compact('debt'));
    }
    public function debtConfirmTime(Request $request)
    {
    		$from=$request['from'];
	    	$to=$request['to'];
	    	$user_id=$request['mandwb_id'];
	    	if($user_id!='0')
	    	{
	    		$debts=\App\Debt::where('created_at','>=',$from)->where('created_at','<=',$to)->where('user_id',$user_id)->get();
	    	}
	    	else
	    	{
	    		$debts=\App\Debt::where('created_at','>=',$from)->where('created_at','<=',$to)->get();
	    	}
	    	
	    	return view('customers.seeDebts',compact('debts'));
    }
    
    public function recent()
    {
      $debt= \App\Debt::where('user_id',\Auth::user()->id)->latest()->first();
      return view('customers.debtPrint',compact('debt'));
    }
   
}
