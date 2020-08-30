<?php

namespace Tests\Unit;

use App\Item;
use App\Rate;
use App\Sale;
use App\Stock;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SaleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    /** @test */
    public function can_see_add_sale_form()
    {
        $this->withoutExceptionHandling();
        factory(Rate::class)->create();
        $this->actingAs(factory(User::class)->create());
        $this->get(route('add-sale'))
            ->assertStatus(200)
            ->assertSee('Total')
            ->assertSee('Discount')
            ->assertSee('Type');
    }

    /** @test */
    public function total_is_required()
    {
        factory(Rate::class)->create();
        $this->actingAs(factory(User::class)->create());
        $attributes = [
            'total' => ''
        ];
        $this->post(route('store-sale'))
            ->assertSessionHasErrors(['total']);
    }

    /** @test */
    public function can_add_sale_with_one_item()
    {
        $this->withoutExceptionHandling();
        $rate = factory(Rate::class)->create();
        $this->actingAs(factory(User::class)->create());
        $item = factory(Item::class)->create();

        $data = [
            'type' => 'sale',
            'total' => 3 * $item->sale_price_id * 3,
            'rate' => $rate->rate,
            'discount' => 0,
            'item' => [
                'barcode' => [$item->id],
                'ppi' => [$item->sale_price_id],
                'quantity' => [3],
                'exp' => ['2025-1-1'],
                'singles' => [1],
                'batch_no' => [''],
                'howManyItems' => 1,

            ]
        ];
        $this->post(route('store-sale'), $data);
        $this->assertDatabaseHas('sales', ['discount' => '0']);
        $this->assertDatabaseHas('sale_items', ['singles' => '1']);
        $this->assertEquals($item->stock()->count(), 1);
    }
    /** @test */
    public function can_add_sale_with_three_item()
    {
        $this->withoutExceptionHandling();
        $rate = factory(Rate::class)->create();
        $this->actingAs(factory(User::class)->create());
        $item = factory(Item::class)->create();

        $data = [
            'howManyItems' => 3,
            'type' => 'sale',
            'total' => 3 * $item->sale_price_id * 3,
            'rate' => $rate->rate,
            'discount' => 0,
            'item' => [
                'barcode' => [$item->id, $item->id, $item->id],
                'ppi' => [$item->sale_price_id, $item->sale_price_id, $item->sale_price_id],
                'quantity' => [1, 2, 3],
                'exp' => ['2025-1-1', '2025-1-1', '2025-1-1'],
                'singles' => [0, 1, 2],
                'batch_no' => ['', '', ''],
            ]
        ];
        $this->post(route('store-sale'), $data);
        $this->assertDatabaseHas('sales', ['discount' => '0']);
        $this->assertDatabaseHas('sale_items', ['quantity' => '1.0']);
        $this->assertDatabaseHas('sale_items', ['quantity' => '2.0']);
        $this->assertDatabaseHas('sale_items', ['quantity' => '3.0']);
        $this->assertDatabaseHas('stocks', ['item_id' => $item->id, 'quantity' => '-1.0']);
        $this->assertEquals($item->stock()->count(), 3);
        $this->get(route('delete-sale', 1));
        $this->assertEquals($item->stock()->count(), 0);
    }
    /** @test */
    public function can_delete_sale()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(factory(User::class)->create());
        $sale = factory(Sale::class)->create();
        $this->assertTrue(Sale::exists());
        $this->get(route('delete-sale', $sale->id));
        $this->assertTrue(Sale::count() === 0);
    }
    /** @test */
    public function can_view_sales()
    {
        $this->actingAs(factory(User::class)->create());
        $sale = factory(Sale::class)->create();
        $this->get(route('show-sales'))
            ->assertStatus(200)
            ->assertSee('barcode')
            ->assertSee(route('edit-sale', $sale->id))
            ->assertSee('/sale/print/' . $sale->id);
    }
    /** @test */
    public function can_edit_sales()
    {
        $this->withoutExceptionHandling();
        $rate = factory(Rate::class)->create();
        $this->actingAs(factory(User::class)->create());
        $sale = factory(Sale::class)->create();
        $this->get(route('edit-sale', $sale->id))
            ->assertStatus(200)
            ->assertSee($sale->total)
            ->assertSee($sale->discount)
            ->assertSee($sale->type);
    }
    /** @test */

    public function  can_update_sale()
    {
        $rate = factory(Rate::class)->create();
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $item = factory(Item::class)->create();

        $data = [
            'type' => 'sale',
            'total' => $item->sale_price_id * 1,
            'rate' => $rate->rate,
            'discount' => 0,
            'item' => [
                'barcode' => [$item->id],
                'ppi' => [$item->sale_price_id],
                'quantity' => [1],
                'exp' => ['2025-1-1'],
                'batch_no' => [''],
                'singles' => [0],
            ]
        ];

        $this->post(route('store-sale'), $data);
        $this->assertDatabaseHas('sale_items', ['quantity' => '1.0']);
        $this->assertDatabaseHas('stocks', ['item_id' => $item->id, 'quantity' => '-1.0']);
        $this->assertEquals($item->stock()->count(), 1);
        $this->assertEquals($user->todayAmount()->total, $data['total']);
        $data['item']['quantity'] = [10];
        $data['item']['total'] = 20;
        $this->post(route('store-sale', 1), $data);
        $this->assertDatabaseHas('stocks', ['item_id' => $item->id, 'quantity' => '-10.0']);
        $this->assertEquals(Stock::count(), 1);
        $this->assertEquals($user->todayAmount()->total, $data['total']);

        // $data['type'] = 'returned_sale';
        // $this->post(route('store-sale', 1), $data);
        // $this->assertDatabaseHas('stocks', ['item_id' => $item->id, 'quantity' => '10.0']);
    }
}
