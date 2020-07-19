<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\StaffDebt;
class StaffDebtController extends Controller
{
	
	public function index(Request $request,$id=0)
	{
		if($id!=0)
		{

			$selectedUser=\App\User::find($id);
			
			if($request->has('from') && $request->has('to'))
			{	
				$staffDebts=StaffDebt::where('user_id',$selectedUser->id)
									->whereDate('created_at','>=',$request->from)
									->whereDate('created_at','<=',$request->to)
									->get();
			}
			else
			{
				$staffDebts=StaffDebt::where('user_id',$selectedUser->id)->get();
			}
			
		    
			return view('staff.staffHome',compact(['staffDebts','selectedUser']));
		}
		return view('staff.staffHome');
	}
	
	public function store(Request $request,$id=0)
	{
		if($id!=0)
		{
			$staffDebts=StaffDebt::find($id);
			\Session::flash('message','گۆڕانکاریەکە بەسەرکەوتوی تۆمارکرا');
			
		}
		else
		{
			$staffDebts=new StaffDebt();
			$staffDebts->user_id=($request['user_id']);
			\Session::flash('message','قەرزەکە بەسەرکەوتوی زیادکرا');
		}
		
		$staffDebts->description=($request['description']);
		$staffDebts->amount=($request['amount']);	
		$staffDebts->save();
		return redirect('/staff/'.$staffDebts->user_id);
	}
	public function edit($id)
	{

		$staffDebt=StaffDebt::find($id);
		return view('staff.staffUpdate',compact('staffDebt'));
	}
	public function search(Request $request)
	{

		return redirect('/staff/'.$request['user_id']);
	}
}
