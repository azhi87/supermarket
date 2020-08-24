<?php

namespace App\Listeners;

use App\Events\SaleCreatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateStockForSaleListener
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
     * @param  SaleCreatedEvent  $event
     * @return void
     */
    public function handle(SaleCreatedEvent $event)
    {
        $sale = $event->sale;
        foreach ($sale->items as $item) {

            $stock = new \App\Stock();
            $stock->item_id = $item->id;
            $stock->exp = $item->pivot->exp;
            $stock->type = $sale->type;
            $stock->source_id = $sale->id;
            $stock->rate = $sale->rate;
            $stock->batch_no = $item->pivot->batch_no;

            if ($sale->type === 'sale') {
                $stock->quantity = - ($item->pivot->quantity + ($item->pivot->singles / $item->items_per_box));
                $stock->description = "Add sale Invoice";
                $stock->ppi = $item->pivot->ppi;
            } else {
                $stock->quantity = ($item->pivot->quantity + ($item->pivot->singles / $item->items_per_box));
                $stock->description = "Return sale Invoice";
                $stock->ppi = -1 * $item->pivot->ppi;
                $sale->total = -1 * abs($sale->total);
                $sale->save();
            }


            $stock->save();
        }
    }
}
