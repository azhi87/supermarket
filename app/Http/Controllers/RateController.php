<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Rate;
class RateController extends Controller
{
	public function create(Request $request)
	{
		$rate=new Rate();
		$rate->user_id=\Auth::user()->id;
		$rate->rate=$request['rate'];
		$rate->save();
		return back();
	}    
}
