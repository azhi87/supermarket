<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $guarded = [];
    public function oneMonthExpirey($months)
    {
        $date = Carbon::today();
        $date->add($months, 'month');
        $items = DB::table('stocks')->whereDate('exp', '<=', $date)
            ->join('items', 'items.id', 'stocks.item_id')
            ->select('item_id as id', 'items.name as name', 'exp', DB::raw('sum(quantity) as quantity'))
            ->groupBy('item_id', 'exp')
            ->having("quantity", ">", 0)
            ->get();


        return $items;
    }
    public static function profit($from, $to)
    {
        return DB::table('stocks')
            ->whereType('sale')
            ->whereDate('stocks.created_at', '>=', $from)
            ->whereDate('stocks.created_at', '<=', $to)
            ->join('items', 'stocks.item_id', 'items.id')
            ->select(DB::raw('Sum(-1 * quantity * ppi / rate) - SUM(-1 *quantity * items.purchase_price) as profit'))
            ->get()->first()->profit;
    }
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
