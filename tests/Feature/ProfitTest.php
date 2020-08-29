<?php

namespace Tests\Feature;

use App\Item;
use App\Stock;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfitTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function  can_create_stock()
    {

        $this->withoutExceptionHandling();
        $this->signIn();
        $item = factory(Item::class)->create();
        $stock = factory(Stock::class)->create(['item_id' => $item->id]);
        $this->assertDatabaseHas('stocks', ['item_id' => $item->id]);
    }
    /** @test */
    public function  item_profit_can_be_found()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $item = factory(Item::class)->create();
        $stockPurchase = factory(Stock::class, 1)->create(['item_id' => $item->id, 'type' => 'purchase', 'ppi' => $item->purchase_price]);
        $stockSale = factory(Stock::class)->create(['item_id' => $item->id, 'type' => 'sale', 'ppi' => $item->sale_price_id]);
        $purchases = Stock::whereType('purchase')->sum(DB::raw('quantity * ppi'));
        $yesterday = Carbon::yesterday();
        $tomorrow = Carbon::tomorrow();
        $sales = Stock::whereType('sale')->sum(DB::raw('quantity * ppi'));
        $this->assertEquals(Stock::profit($yesterday, $tomorrow), -1 * $stockSale->quantity * ($item->sale_price_id / $stockSale->rate - $item->purchase_price));
    }
}
