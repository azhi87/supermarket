<?php

namespace App;

use DB;
use \App\Sale;
use App\Stock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB as FacadesDB;

class Item extends Model
{
    protected $guarded = [];

    public function scopeNotDeleted($query)
    {
        return $query->where('status', '=', '1');
    }

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }

    public function sales()
    {
        return $this->belongsToMany('App\Sale', 'sale_items')->withPivot('quantity', 'ppi', 'singles', 'exp', 'id')->withTimestamps();
    }
    public function totalPurchase()
    {
        return DB::table('stocks')->where('item_id', $this->id)->where('quantity', '>', '0')->sum('quantity');
    }
    public function expiryDates()
    {
        return DB::table('stocks')->where('item_id', $this->id)
            ->whereDate('exp', '>=', Carbon::today())
            ->select('exp', DB::raw('sum(quantity) as quantity'), 'batch_no')
            ->groupBy('exp', 'batch_no')
            ->having(DB::raw('sum(quantity)'), '>', 0)
            ->get();
    }
    public function expiryStock()
    {
        return DB::select(DB::raw("select exp as expp,
                            (select sum(quantity) from stocks where item_id=" . $this->id . " and exp=expp) quantity,
                            (select sum(quantity) from stocks where (type='purchase' or type='returned_purchase') and item_id=" . $this->id . " and exp=expp) bought, 
                            (select sum(quantity) from stocks where (type='sale' or type='returned_sale') and item_id=" . $this->id . " and exp=expp) sold  from stocks where item_id=" . $this->id . "  group by item_id,exp"));
    }
    public function totalSale()
    {
        return DB::table('stocks')->where('item_id', $this->id)->where('quantity', '<', '0')->sum('quantity');
    }
    public function totalSaleByDate($from, $to)
    {
        return DB::table('stocks')->where('item_id', $this->id)
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->sum('quantity');
    }


    public function supplier()
    {
        return $this->belongsTo('\App\Supplier');
    }
    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id');
    }


    public function sumBroken()
    {
        return DB::table('brokens')->where('item_id', $this->id)->sum('quantity');
    }

    public function profit($from = null, $to = null)
    {

        $profit = DB::table('stocks')
            ->where('item_id', $this->id)
            ->whereDate('created_at', '>=', $from ?? Carbon::now()->subtract('years', 2))
            ->whereDate('created_at', '<=', $to ??  Carbon::now()->addDay())
            ->whereType('sale')
            ->select(DB::raw("SUM (quantity * ppi - (quantity * {$this->purchase_price})) as profit"))->get()->first()->profit;

        return -1 * $profit;
    }
    public function totalProfitWithoutDiscount($from, $to)
    {
        $sumPrice = DB::table('sale_items')->where('item_id', $this->id)
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->select(DB::raw('sum(ppi*quantity)/(sum(quantity)) as averageSalePrice'))->first();
        $sumQuantity = $this->totalSaleByDate($from, $to);
        return ($sumPrice->averageSalePrice - $this->averagePurchasePrice()) * $sumQuantity;
    }
    public function boxesByUser($user_id, $from, $to)
    {
        return $this->sales()->where('user_id', $user_id)
            ->whereDate('sales.created_at', '>=', $from)
            ->whereDate('sales.created_at', '<=', $to)
            ->join('items', 'items.id', '=', 'sale_items.item_id')
            ->sum(DB::raw('sale_items.quantity+(sale_items.discount/items.items_per_box)'));
    }
    //ignoring expiry dates and batch numbers
    public function maxzan()
    {
        return $this->stock()->sum('quantity');
    }
}
