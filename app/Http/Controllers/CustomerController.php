<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Garak;
use DB;

class CustomerController extends Controller
{

    public function index($id=0)
    {
        if($id!=0)
        {
            $customers=Customer::where('id',$id)->paginate(30);
        }
        else
        {   
           // $this->disableDueDebtCustomers();
            $customers=Customer::notDeleted()->latest()->paginate(30);
        }
    	return view ('customers.customerHome',compact('customers'));
    }

    public function store(Request $request,$id=0)
    {
    
    	if($id!=0)
    	{
    		$customer=Customer::find($id);
    	    $resultMessage='گۆڕانکاریەکە بەسەرکەوتوویی تۆمارکرا';

    		if(\Auth::user()->type!='mandwb')
    		{
                $customer->deleted=$request['deleted'];
                $customer->status=$request['status'];
    		}

    	}
    	else
    	{
    	     $this->validate($request,[
            "name"=>"required|min:1|unique:customers",
            "lab_name"=>"required|min:1|unique:customers",
            "garak_id"=>"required",
            "id"=>"unique:customers",
            ]); 
    		$customer=new Customer;
    		$customer->status="active";

    		$resultMessage='فرۆشیارەکە بەسەرکەوتوویی زیاد کرا';

    	}
    	if(\Auth::user()->type!='mandwb')
    	{
        	if($request->has('id'))
        	{
        		$customer->id=$request['id'];
        	}
            
            $customer->name=$request['name'];
            $customer->lab_name=$request['lab_name'];
            $customer->ahli=$request['ahli'];
        	$customer->garak_id=$request['garak_id'];
        	$customer->maxDebt=$request['maxDebt'];
            $customer->daysToBlock=$request['daysToBlock'];
        	
        		if($request->has('discount'))
        	{
        		$customer->discount=0;
        	}
            else
            {
                $customer->discount=0;
            }
    	}
        $customer->mobile=$request['mobile'];
    	$customer->address=$request['address'];
    	$customer->naqdOrQarz=$request['naqdOrQarz'];
    	
    	if($customer->save())
    		{	
    			\Session::flash('message',$resultMessage);
    			return redirect('/customers');
    		}
        else
    	{
    		return view('errors.404');
    	}
    }

    public function search(Request $request)
	{

		if($request->has('customer_id'))
		{
			$customer=Customer::notDeleted()->find($request['customer_id']);

		}
		elseif($request->has('name'))
		{
			$customer=Customer::notDeleted()->where('name','LIKE','%'.$request['name'].'%')->first();
		}
		else
		{
			\Session::flash('message','تکایە کۆدی کڕیار داخڵبکە');
			return redirect('/customers');
		}
		if(!count($customer))
		{
			\Session::flash('message','کۆدی کڕیار هەڵەیە');
			return redirect('/customers');
		}
		
		else
		{
		return redirect('/customers/'.$customer->id);
		}
	}
    
    
    public function addGarak()
    {
        $garak=new \App\Garak;
        $garak->city_id=request('city_id');
        $garak->garak=request('garak');
        $garak->save();
        \Session::flash('message','گەڕەکەکە بەسەرکەوتوویی زیادکرا');
        return redirect('/customers');

    }

    public function addCity()
    {
        $city=new \App\City;
        $city->city=request('city');
        $city->save();
        \Session::flash('message','شارەکە بەسەرکەوتوویی زیادکرا');
        return redirect('/customers');
    }



    public function searchGarak(Request $request)
    {
        // dd('hi');
        //   echo $request['garak_id'];
        //   exit(0);
        $garak_id=$request['garak_id'];
        $customers=Customer::notDeleted()->where('garak_id',$garak_id)->paginate(150);
        $customers->setPath('/customers/searchGarak');
       return view ('customers.customerHome',compact('customers'));
    }

    public function getDetails()
    {
        $customer=\App\Customer::find(Request('id'));
        //$customer=Customer::where('id',Request('id'))->get();
         
             return json_encode(array(
                 "customerName" => $customer->name,
      //           "LabName" => $customer->lab_name,
    //             "mobile" => $customer->mobile,
  //               "mobile2" => $customer->mobile2,
//                 "address"=>$customer->address
                 "debt" => $customer->customerDebt(),

                 )); 
      
    }

    public function signaturePrint(Request $request)
    {
          
            $customers=\App\Customer::all();
            return view('customers.dailyReport',compact('customers'));
    }

    public function kashfi7sab($id)
    {
        $customer=Customer::findOrFail($id); 
        return view('customers.kashfi7sab',compact('customer'));
    }

    public function noTransactions(Request $request)
    {
        if($request->exists('sales'))
        {
            $target='sales';
            $targetReport='reports.noTransactions';
        }
        else
        {
            $target='debts';
            $targetReport='reports.noDebtPayments';
        }
        $from=$request['from'];
        $to=$request['to'];

         if($request['garak_id']!="all")
        {
            $customers = Customer::whereDoesntHave($target, function ($query) use ($from,$to){
                    $query->whereDate('created_at', '>=', $from)
                          ->whereDate('created_at','<',$to);
                         
                    })->where('deleted','active')->where('garak_id','=',Request('garak_id'))->get();
        }
        else
        {
            $customers = Customer::whereDoesntHave($target, function ($query) use ($from,$to) {
                    $query->whereDate('created_at', '>=', $from)->whereDate('created_at','<',$to);
                    })->where('deleted','active')->get();

        }
        return view($targetReport,compact(['customers','from','to']));
    }

    public static function disableDueDebtCustomers()
    {
        $customers=\App\Customer::where('status','active')->get();
        foreach($customers as $customer)
        {
            if(floor($customer->daysFromLastDebtPayment())>=($customer->daysToBlock))
            {
                $customer->status="disabled";
                $customer->blockReason="نەگێڕانەوەی قەرز";
                $customer->save();
            }
        }
    }

    public function customerItems($id)
    {
        $name=Customer::where('id',$id)->value('name');
        $items=DB::table('sales')->where('customer_id',$id)
                          ->join('sale_items','sale_items.sale_id','sales.id')
                          ->join('items','items.id','sale_items.item_id')
                          ->select(DB::raw('sale_items.item_id as id'),
                                DB::raw('SUM(sale_items.quantity+(sale_items.discount/items.items_per_box)) as tqty'),
                                DB::raw('items.name'))
                       ->groupBy(DB::raw('item_id'))
                       ->orderByRaw('tqty desc')
                       ->get();
        $zeroItems=\App\Item::whereNotIn('id',$items->pluck('id'))->select('name','id')->get();
       return view('customers.customerItems',compact(['items','zeroItems','name']));
    }
}
