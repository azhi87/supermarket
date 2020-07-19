<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Bank;
class BankController extends Controller
{
	public $user;
	public function __construct()
	{
		if(\Auth::check())
		{
			$this->user=\Auth::user();
		}
	}
    public function index()
    {
    	// if(\Auth::user()->type=="mandwb")
    	// {
    	// 	$banks=Bank::where('user_id',\Auth::user()->id)->paginate(15);
    	// }
    	// else
    	// {
            if(\Auth::user()->type!='admin')
            {
                $banks=Bank::whereDate('created_at',Carbon::today())->where('user_id',\Auth::user()->id)->latest()->paginate(200);
            }
            else
            {
                $banks=Bank::latest()->paginate(200);
            }

    	return view('banks.bankHome',compact('banks'));
    }
    public function store($id=0)
    {
    	$this->validate(request(),[
            "amount"=>"required",
            "type"=>"required",
            "account_code"=>"required"            
    		]);
        if($id==0)
        {
            $bank=new Bank();
            $bank->user_id=\Auth::user()->id;
            $message='پارە بەسەرکەوتوویی زیادکرا';
        }
    	else
        {
            $bank=Bank::findOrFail($id);
            $message='گۆڕانکاریەکە بەسەرکەوتوویی تۆمارکرا';
        }
        $bank->amount=request('amount');
        $bank->type=request('type');
        $bank->account_code=request('account_code');
    	$bank->description=request('description');
    	
    	if($bank->save())
    		\Session::flash('message',$message);
    	return redirect('/banks');
    }

    public function searchReason(Request $request)
    {
        $from=null;
        $to=null;
        if($request->has('start_date') && $request->has('end_date') && $request->has('description'))
        {
            $from=$request['start_date'];
            $to=$request['end_date'];
            $reason=Request('description');
            $banks=Bank::whereDate('created_at','>=',$request['start_date'])
                        ->whereDate('created_at','<=',$request['end_date'])
                        ->where('description','like','%'.$reason.'%')->paginate(5000);
        }
      elseif((!$request->has('start_date') || !$request->has('end_date')) &&($request->has('description')))
      {

    	$reason=Request('description');
    	$banks=Bank::where('description','like','%'.$reason.'%')->paginate(5090);
      }
      elseif($request->has('start_date') && $request->has('end_date') && (!$request->has('description')))
      {
          $from=$request['start_date'];
        $to=$request['end_date'];
           $banks=Bank::whereDate('created_at','>=',$request['start_date'])
                        ->whereDate('created_at','<=',$request['end_date'])
                       ->paginate(5000);
      }
      else
      {
          return back();
      }
        $searchBanks=$banks;
         return view('banks.bankHome',compact(['searchBanks','from','to']));
    }
    
    
    // public function search(Request $request)
    // {
    //     if(!$request->has('start_date') || !$request->has('end_date'))
    //     {
    //         return back();
    //     }
    // 	$expenses=Expense::whereDate('created_at','>=',$request['start_date'])
    //                     ->whereDate('created_at','<=',$request['end_date'])
    //                     ->get();
    // 	return view('expenses.expenseHome',compact('expenses'));
    // }
}
