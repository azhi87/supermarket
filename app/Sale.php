<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
	public function items()
	{
		return $this->belongsToMany('App\Item', 'sale_items')->withPivot('quantity', 'ppi', 'singles', 'exp', 'id', 'batch_no')->withTimestamps();
	}

	public function user()
	{
		return $this->belongsTo('App\User');
	}
	public function customer()
	{
		return $this->belongsTo('App\Customer');
	}
	public function addItems($items)
	{
		$total = 0;

		foreach ($items['barcode'] as $i => $barcode) {
			$item = Item::find($barcode);
			$singles = $items['singles'][$i];
			$ppi = $items['ppi'][$i];
			$quantity = $items['quantity'][$i];
			$exp = $items['exp'][$i];
			$batch_no = $items['batch_no'][$i];

			if ($quantity == 0 && $singles == 0) {
				continue;
			}
			// $total += $ppi * ($quantity + ($singles / $item->items_per_box));

			$this->items()->attach($barcode, [
				'ppi' => $ppi,
				'quantity' => $quantity,
				'singles' => $singles,
				'exp' => $exp,
				'batch_no' => $batch_no,
			]);
		}
		// $this->total = $total;
		// $this->save();
	}
}
