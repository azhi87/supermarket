<?php

namespace App\Listeners;

use App\Events\PurchaseCreatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB;

class UpdateStockForPurchaseListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PurchaseCreated  $event
     * @return void
     */
    public function handle(PurchaseCreatedEvent $event)
    {
        $purchase=$event->purchase;
        foreach($purchase->items as $item){
				 $stock = new \App\Stock();
				 $stock->item_id = $item->id;
                 $stock->exp = $item->pivot->exp;
                 $stock->rate = 0;
                 $stock->type = $purchase->type;
                 $stock->source_id = $purchase->id;

                 if($purchase->type === 'purchase'){
                    $stock->quantity= ( $item->pivot->bonus + $item->pivot->quantity );
                    $stock->description = "Add Purchase Invoice";
                    $stock->ppi = -1 * ($item->pivot->ppi * $item->pivot->quantity);
                 }

                 else {
                        $stock->quantity = - ( $item->pivot->bonus + $item->pivot->quantity );
                        $stock->description = "Return Purchase Invoice";
                        $stock->ppi = $item->pivot->ppi * $item->pivot->quantity;
                        $purchase->total = -1 * abs($purchase->total);
                        $purchase->save();
                 }
                 $stock->save();
        }
    }
}
