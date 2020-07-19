<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use DB;
use \App\Sale;
class Item extends Model
{
    protected $guarded=[];

    public function scopeNotDeleted($query)
    {
        return $query->where('status', '=', '1');
    }
    public function sales()
    {
        return $this->belongsToMany('App\Sale','sale_items')->withPivot('quantity','ppi','singles','exp','id')->withTimestamps();
    }
    public function totalPurchase()
    {
         return DB::table('stocks')->where('item_id',$this->id)->where('quantity','>','0')->sum('quantity');

    }
    public function expiryDates()
    {
        return DB::table('stocks')->where('item_id',$this->id)
                                ->select('exp',DB::raw('sum(quantity) as quantity'))
                                ->groupBy('exp')
                                ->having(DB::raw('sum(quantity)'),'>',0)
                                ->get();
    }
    public function expiryStock()
    {
        return DB::select(DB::raw("select exp as expp,
                            (select sum(quantity) from stocks where item_id=".$this->id." and exp=expp) quantity,
                            (select sum(quantity) from stocks where quantity>0 and item_id=".$this->id." and exp=expp) bought, 
                            (select sum(quantity) from stocks where quantity<0 and item_id=".$this->id." and exp=expp) sold  from stocks where item_id=".$this->id."  group by item_id,exp"));
    }
    public function totalSale()
    {
    	return DB::table('stocks')->where('item_id',$this->id)->where('quantity','<','0')->sum('quantity');
    }
    public function totalSaleByDate($from,$to)
    {
        return DB::table('stocks')->where('item_id',$this->id)
                                      ->whereDate('created_at','>=',$from)
                          ->whereDate('created_at','<=',$to)
                                        ->sum('quantity');
    }

    
    public function supplier()
    {
        return $this->belongsTo('\App\Supplier');
    }
    public function category()
    {
      return $this->belongsTo('App\Category','category_id');
    }
    public function ireturns()
    {
        return $this->hasMany('\App\Ireturn');
    } 
    public function sumReturned()
    {
        return DB::table('ireturns')->where('item_id',$this->id)->sum('quantity');
    }
     public function sumBroken()
    {
        return DB::table('brokens')->where('item_id',$this->id)->sum('quantity');
    }
    public function averagePurchasePrice()
    {
        // $sumPrice=DB::table('purchase_items')->where('item_id',$this->id)
        //                                   ->sum(DB::raw('(ppi * quantity)'));
        // $sumQuantity=DB::table('purchase_items')->where('item_id',$this->id)
        //                                   ->sum('quantity');
        // if($sumQuantity==0)
        // {
        //     $sumQuantity=1;
        // }
        // return $sumPrice/$sumQuantity;
        return $this->purchase_price;
    }
    public function totalProfit($from,$to)
    {
        $xasm=DB::table('sale_items')->where('item_id',$this->id)
                                         ->whereDate('created_at','>=',$from)
                          ->whereDate('created_at','<=',$to)
                                        ->sum('discount');


         $parayXasm=($xasm/$this->items_per_box) * $this->averagePurchasePrice();
         $xerifroshtn=$this->totalProfitWithoutDiscount($from,$to);
         return $xerifroshtn-($parayXasm);
       
        //($sumPrice->averageSalePrice - $this->averagePurchasePrice())*$sumQuantity;
    }
    public function totalProfitWithoutDiscount($from,$to)
    {
        $sumPrice=DB::table('sale_items')->where('item_id',$this->id)
                                         ->whereDate('created_at','>=',$from)
                          ->whereDate('created_at','<=',$to)
                                        ->select(DB::raw('sum(ppi*quantity)/(sum(quantity)) as averageSalePrice'))->first();
        $sumQuantity=$this->totalSaleByDate($from,$to);
        return ($sumPrice->averageSalePrice-$this->averagePurchasePrice())*$sumQuantity;
    }
    public function boxesByUser($user_id,$from,$to)
    {
        return $this->sales()->where('user_id',$user_id)
                             ->whereDate('sales.created_at','>=',$from)
                             ->whereDate('sales.created_at','<=',$to)
                             ->join('items','items.id','=','sale_items.item_id')
                             ->sum(DB::raw ('sale_items.quantity+(sale_items.discount/items.items_per_box)'));
    }
    public function boxesByGarak($garak_id,$from,$to)
    {
        return $this->sales()->where('garak_id',$garak_id)
                             ->sum('quantity');
    }
    public function stock()
    {
    return floor($this->totalPurchase()+$this->sumReturned()-($this->totalSale()+$this->totalXasm()+$this->sumBroken()));
    }
    public function formattedDescription()
    {
      return nl2br($this->description);
    }
    public function specialPrice($customer_id)
    {
        if(count($c=DB::table('customer_items')->where('customer_id',$customer_id)->where('item_id',$this->id)->value('sale_price')))
        {
            return $c;
        }
        else
        {
            return $this->sale_price;
        }
    }
}