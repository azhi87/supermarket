<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class CustomerItemController extends Controller
{
    public function index($id)
    {

    }

    public function store(Request $request)
    {
        $ci= new \App\CustomerItem();
        $customer_id=$request['customer_id'];
        $customer=\App\Customer::find($customer_id);
        $customer->specialPrice='1';
        $customer->save();
        DB::table('customer_items')->where('customer_id',$customer_id)->delete();
        foreach ($request['item_id'] as $key => $value) {
            $ci= new \App\CustomerItem();
            $ci->customer_id=$customer_id;
            $ci->sale_price=$request['sale_price'][$key];
            $ci->item_id=$value;
            $ci->user_id=\Auth::user()->id;
            $ci->save();

        }
        return redirect('/customerItems/'.$ci->customer_id);
    }
}