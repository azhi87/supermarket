<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaybackController extends Controller
{
	public function index()
	{
		$paybacks=\App\Payback::latest()->paginate(100);
		return view('paybacks.payback',compact('paybacks'));
	} 
	public function store(Request $request,$id=0)
	{
	   
		if($id==0)
		{
			$payback=new \App\Payback();
		
			$result='پارەدانەوەکە بە سەرکەوتوویی تۆمارکرا';
		}
		else
		{
			$payback=\App\Payback::find($id);
			$result='گۆڕانکاریەکە بە سەرکەوتوویی تۆمارکرا';
		}
			$payback->user_id=$request['user_id'];
		$payback->paid=$request['paid'];
		$payback->description=$request['description'];
		$payback->currency=$request['currency'];
		$payback->save();
		\Session::flash('message',$result);
		return redirect('/paybacks');
	}
	public function edit($id)
	{
		$payback=\App\Payback::find($id);
		return view('paybacks.updatePayback',compact('payback'));
	}
	
		public function printing($id)
	{
		$payback=\App\Payback::find($id);
		return view('paybacks.printPayback',compact('payback'));
	}
	
}
