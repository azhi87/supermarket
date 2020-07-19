<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Expense;
class ExpenseController extends Controller
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
    	// 	$expenses=Expense::where('user_id',\Auth::user()->id)->paginate(15);
    	// }
    	// else
    	// {
            if(\Auth::user()->type!='admin')
            {
                $expenses=Expense::whereDate('created_at',Carbon::today())->where('user_id',\Auth::user()->id)->latest()->paginate(200);
            }
            else
            {
                $expenses=Expense::latest()->paginate(200);
            }

    	return view('expenses.expenseHome',compact('expenses'));
    }
    public function store($id=0)
    {
    	$this->validate(request(),[
    		"reason"=>"required|min:6",
    		"amount"=>"required"
    		]);
        if($id==0)
        {
            $expense=new Expense();
            $expense->user_id=\Auth::user()->id;
            $message='مەصروفاتەکە بەسەرکەوتوویی زیادکرا';
        }
    	else
        {
            $expense=Expense::findOrFail($id);
            $message='گۆڕانکاریەکە بەسەرکەوتوویی تۆمارکرا';
        }
    	$expense->amount=request('amount');
    	$expense->currency='$';
    	$expense->reason=request('reason');
    	
    	if($expense->save())
    		\Session::flash('message',$message);
    	return redirect('/expenses');
    }

    public function searchReason(Request $request)
    {
        $from=null;
        $to=null;
        if($request->has('start_date') && $request->has('end_date') && $request->has('reason'))
        {
            $from=$request['start_date'];
            $to=$request['end_date'];
            $reason=Request('reason');
            $expenses=Expense::whereDate('created_at','>=',$request['start_date'])
                        ->whereDate('created_at','<=',$request['end_date'])
                        ->where('reason','like','%'.$reason.'%')->paginate(5000);
        }
      elseif((!$request->has('start_date') || !$request->has('end_date')) &&($request->has('reason')))
      {

    	$reason=Request('reason');
    	$expenses=Expense::where('reason','like','%'.$reason.'%')->paginate(5090);
      }
      elseif($request->has('start_date') && $request->has('end_date') && (!$request->has('reason')))
      {
          $from=$request['start_date'];
        $to=$request['end_date'];
           $expenses=Expense::whereDate('created_at','>=',$request['start_date'])
                        ->whereDate('created_at','<=',$request['end_date'])
                       ->paginate(5000);
      }
      else
      {
          return back();
      }
        $searchExpenses=$expenses;
         return view('expenses.expenseHome',compact(['searchExpenses','from','to']));
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
