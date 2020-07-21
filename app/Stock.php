<?php

namespace App;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    public function oneMonthExpirey($months)
    {
    	$date=Carbon::today();
    	$date->add($months,'month');
    	$items=DB::table('stocks')->whereDate('exp','<=',$date)
                                ->select('item_id as id','exp',DB::raw('sum(quantity) as quantity'))
                                ->groupBy('item_id','exp')
                                ->having("quantity",">",0)
                                ->get();


        return $items;
    }
    public function item(){
        return $this->belongsTo(Item::class);
    }
}
