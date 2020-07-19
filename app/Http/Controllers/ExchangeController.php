<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExchangeController extends Controller
{
    public function index()
    {
    	$exchanges= new \App\Exchange();
    	$totalDinars=$exchanges->incomeDinars()['dinars'];
    	$totalDollars=$exchanges->incomeDinars()['dollars'];
    	$exchanges=\App\Exchange::all();
    	return view('currencyExchange.exchangeHome',compact('exchanges','totalDinars','totalDollars'));
    }
    public function store(Request $request,$id=0)
    {
        $this->validate(request(),[
            'exchanged_amount'=>'required|numeric',
            'rate'=>'required|numeric',
            'totalDinars'=>'required|numeric',
            'totalDollars'=>'required|numeric'
            ]);
        if($id==0)
        {
            $exchanges=new \App\Exchange();
        }
        else
        {
            $exchangees=\App\Exchange::find($id);
        }
    	
    	$totalDinars=$request['totalDinars'];
    	$totalDollars=$request['totalDollars'];
    	$exchanged_amount=$request['exchanged_amount'];
    	$rate=$request['rate'];
    	$calculated_rate=$totalDinars/$totalDollars;
    	$exchanges->rate=$rate;
    	$exchanges->remained_dinars=($totalDinars-$exchanged_amount);
    	$exchanges->remained_dollars=($totalDinars-$exchanged_amount)/$calculated_rate;
    	$exchanges->profit=($exchanged_amount/$rate)-( $exchanged_amount/$calculated_rate);
    	$exchanges->save();
        $exchanges=\App\Exchange::all();
    	return redirect('/exchange')->withInput(['exchanges','totalDinars','totalDollars']);
    }
}
