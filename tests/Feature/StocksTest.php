<?php

namespace Tests\Feature;

use App\Item;
use App\Rate;
use App\Sale;
use App\Supplier;
use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StocksTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function add_a_sale($item_id, $quantity, $singles, $type)
    {
        $rate = factory(Rate::class)->create();
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $data = [
            'type' => $type,
            'total' => $this->faker->numberBetween(1, 1000),
            'rate' => $rate->rate,
            'discount' => 0,
            'item' => [
                'barcode' => [$item_id],
                'ppi' => [$this->faker->randomNumber(4)],
                'quantity' => [$quantity],
                'exp' => [$this->faker->date],
                'batch_no' => [$this->faker->word],
                'singles' => [$singles],
            ]
        ];
        $this->post(route('store-sale'), $data);
    }
    public function add_a_purchase($item_id, $quantity, $bonus, $type)
    {
        $this->actingAs(factory(User::class)->create());

        $attributes = [
            'total' => 10,
            'invoice_no' => 'abcd',
            'type' => $type,
            'supplier_id' => factory(Supplier::class)->create()->id,
            'item' => [
                'quantity' => [$quantity],
                'bonus' => [$bonus],
                'ppi' => [$this->faker->numberBetween(1, 20)],
                'sppi' => [1000],
                'batch_no' => ['111111'],
                'barcode' => [$item_id],
                'exp' => ['2022-01-01']
            ]
        ];

        $this->post(route('store-purchase'), $attributes);
    }
    public function update_a_purchase($purchase_id, $item_id, $quantity, $bonus, $type)
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $attributes = [
            'total' => $this->faker->numberBetween(1, 1000),
            'invoice_no' => $this->faker->word,
            'type' => $type,
            'supplier_id' => factory(Supplier::class)->create()->id,
            'item' => [
                'quantity' => [$quantity],
                'bonus' => [$bonus],
                'ppi' => [$this->faker->randomNumber(1)],
                'sppi' => [$this->faker->randomNumber(4)],
                'batch_no' => [$this->faker->word],
                'barcode' => [$item_id],
                'exp' => [$this->faker->date],

            ]
        ];


        $this->post(route('store-purchase', $purchase_id), $attributes);
    }
    /** @test */
    public function  added_sale_will_decrease_stock()
    {
        $this->withoutExceptionHandling();
        $quantity = 20;
        $singles = 10;
        $item = factory(Item::class)->create();
        $this->add_a_sale($item->id, $quantity, $singles, 'sale');
        $expectedStock = -1 * ($quantity + ($singles / $item->items_per_box));
        $this->assertEquals($item->maxzan(), $expectedStock);
    }

    /** @test */
    public function  returned_sale_will_increase_stock()
    {
        $this->withoutExceptionHandling();
        $quantity = 20;
        $singles = 10;
        $item = factory(Item::class)->create();
        $this->add_a_sale($item->id, $quantity, $singles, 'returned_sale');
        $expectedStock = ($quantity + ($singles / $item->items_per_box));
        $this->assertEquals($item->maxzan(), $expectedStock);
    }

    /** @test */
    public function  deleting_a_sale_will_decrease_stock()
    {
        $this->withoutExceptionHandling();
        $quantity = 20;
        $singles = 10;
        $item = factory(Item::class)->create();
        $this->add_a_sale($item->id, $quantity, $singles, 'sale');
        $expectedStock = -1 * ($quantity + ($singles / $item->items_per_box));
        $this->assertEquals($item->maxzan(), $expectedStock);
        $this->get(route('delete-sale', 1));
        $this->assertEquals($item->maxzan(), 0);
    }

    /** @test */
    public function  added_purchase_will_increase_stock()
    {
        $this->withoutExceptionHandling();
        $quantity = 20;
        $bonus = 10;
        $item = factory(Item::class)->create();
        $this->add_a_purchase($item->id, $quantity, $bonus, 'purchase');
        $expectedStock = $quantity + $bonus;
        $this->assertEquals($item->maxzan(), $expectedStock);
    }
    /** @test */
    public function  returned_purchase_will_reflect_stock()
    {
        $this->withoutExceptionHandling();
        $quantity = 20;
        $bonus = 10;
        $item = factory(Item::class)->create();
        $this->add_a_purchase($item->id, $quantity, $bonus, 'returned_purchase');
        $expectedStock = -1 * ($quantity + $bonus);
        $this->assertEquals($item->maxzan(), $expectedStock);
    }
    /** @test */
    public function  deleting_purchase_will_reflect_stock()
    {
        $this->withoutExceptionHandling();
        $quantity = 20;
        $bonus = 10;
        $item = factory(Item::class)->create();
        $this->add_a_purchase($item->id, $quantity, $bonus, 'purchase');
        $expectedStock = $quantity + $bonus;
        $this->assertEquals($item->maxzan(), $expectedStock);
        $this->get(route('delete-purchase', 1));
        $this->assertEquals($item->maxzan(), 0);
    }
    /** @test */
    public function  updating_purchase_will_reflect_stock()
    {
        $this->withoutExceptionHandling();
        $quantity = 20;
        $bonus = 10;
        $item = factory(Item::class)->create();
        $this->add_a_purchase($item->id, $quantity, $bonus, 'purchase');
        $expectedStock = $quantity + $bonus;
        $this->assertEquals($item->maxzan(), $expectedStock);
        $quantity = 30;
        $bonus = 8;
        $this->update_a_purchase(1, $item->id, $quantity, $bonus, 'purchase');
        $expectedStock = $quantity + $bonus;
        $this->assertEquals($item->maxzan(), $expectedStock);
    }
}
