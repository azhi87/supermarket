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

                 if($purchase->type === 'purchase'){
                    $stock->quantity= ( $item->pivot->bonus + $item->pivot->quantity );
                    $stock->description = "Add Purchase Invoice";
                 }

                 else {
                        $stock->quantity = - ( $item->pivot->bonus + $item->pivot->quantity );
                        $stock->description = "Return Purchase Invoice";
                 }

				 $stock->type = $purchase->type;
				 $stock->source_id = $purchase->id;
				 $stock->description = "Add Purchase Invoice";
				 $stock->save();
        }
    }
}