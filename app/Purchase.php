<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    public function items()
    {
        return $this->belongsToMany('App\Item', 'purchase_items')->withPivot('quantity', 'ppi', 'bonus', 'exp', 'batch_no')->withTimestamps();
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }

    public function addItems($items)
    {
        $total = 0;
        foreach ($items['barcode'] as $i => $barcode) {
            $total += $items['ppi'][$i] * $items['quantity'][$i];
            $item = Item::find($barcode);
            $item->sale_price_id = $items['sppi'][$i];
            $item->purchase_price = $items['ppi'][$i];
            $this->items()->attach($barcode, [
                'ppi' => $items['ppi'][$i],
                'quantity' => $items['quantity'][$i],
                'bonus' => $items['bonus'][$i],
                'exp' => $items['exp'][$i],
                'batch_no' => $items['batch_no'][$i],
            ]);
        }
        $this->total = $total;
        $this->save();
    }
}
