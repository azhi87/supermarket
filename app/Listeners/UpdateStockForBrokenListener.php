<?php

namespace App\Listeners;

use App\Stock;
use App\Events\BrokenCreatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateStockForBrokenListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  BrokenCreatedEvent  $event
     * @return void
     */
    public function handle(BrokenCreatedEvent $event)
    {
        $broken = $event->broken;
        Stock::create([
            'item_id' => $broken->item_id,
            'batch_no' => $broken->batch_no,
            'exp' => $broken->exp,
            'rate' => 0,
            'type' => 'broken',
            'source_id' => $broken->id,
            'quantity' => -1 * $broken->quantity,
            'bonus' => 0,
            'ppi' => -1 * $broken->item->purchase_price,
            'description' => 'Add Expired Drug',
        ]);
    }
}
