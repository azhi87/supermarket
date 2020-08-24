<?php

namespace Tests\Unit;

use App\Item;
use App\Purchase;
use App\Rate;
use App\Supplier;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    /** @test */
    public function can_see_add_purchase_form()
    {
        $this->withoutExceptionHandling();
        factory(Rate::class)->create();
        $this->actingAs(factory(User::class)->create());
        $this->get(route('add-purchase'))
            ->assertStatus(200)
            ->assertSee('Total')
            ->assertSee('Supplier')
            ->assertSee('Type')
            ->assertSee('invoice')
            ->assertSee('Note');
    }

    /** @test */
    public function total_is_required()
    {
        $this->actingAs(factory(User::class)->create());
        $attributes = [
            'total' => ''
        ];
        $this->post(route('store-purchase'), $attributes)
            ->assertSessionHasErrors(['total']);
    }
    /** @test */
    public function can_add_purchase()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(factory(User::class)->create());
        $supplier = factory(Supplier::class)->create();
        $item = factory(Item::class)->create();
        $item2 = factory(Item::class)->create();
        $attributes = [
            'total' => 10,
            'invoice_no' => 'abcd',
            'type' => 'purchase',
            'supplier_id' => $supplier->id,
            'quantity' => [1, 1],
            'bonus' => [100, 110],
            'ppi' => [1, 2],
            'sppi' => [1000, 1100],
            'batch_no' => ['111111', '222222'],
            'barcode' => [$item->id, $item2->id],
            'exp' => ['2022-01-01', '2023-01-01']
        ];
        $this->post(route('store-purchase'), $attributes);
        $this->assertDatabaseHas('purchases', ['total' => 10]);
        $this->assertEquals(2, Purchase::find(1)->items->count());
        $this->assertEquals(Purchase::find(1)->total, 10);
        $this->assertDatabaseHas('stocks', [
            'item_id' => $item->id,
            'quantity' => 101.0,
            'ppi' => -1.0,
            'exp' => '2022-01-01',
            'batch_no' => '111111'
        ]);
    }
    /** @test */
    public function can_return_purchase()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(factory(User::class)->create());
        $supplier = factory(Supplier::class)->create();
        $item = factory(Item::class)->create();
        $item2 = factory(Item::class)->create();
        $attributes = [
            'total' => 10,
            'invoice_no' => 'abcd',
            'type' => 'returned_purchase',
            'supplier_id' => $supplier->id,
            'quantity' => [1, 1],
            'batch_no' => ['', ''],
            'bonus' => [100, 110],
            'ppi' => [1, 2],
            'sppi' => [1000, 1100],
            'barcode' => [$item->id, $item2->id],
            'exp' => ['2022-01-01', '2023-01-01']
        ];
        $this->post(route('store-purchase'), $attributes);
        $this->assertDatabaseHas('purchases', ['total' => '-10.0']);
        $this->assertEquals(2, Purchase::find(1)->items->count());
        $this->assertEquals(Purchase::find(1)->total, -10);
        $this->assertDatabaseHas('stocks', [
            'item_id' => $item->id,
            'quantity' => -101.0,
            'ppi' => 1.0,
            'exp' => '2022-01-01'
        ]);
    }
    /** @test */
    public function can_edit_purchase()
    {
        $this->actingAs(factory(User::class)->create());
        $purchase = factory(Purchase::class)->create();
        $this->get(route('edit-purchase', $purchase->id))->assertStatus(200);
    }
}
