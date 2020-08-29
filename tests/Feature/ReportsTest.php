<?php

namespace Tests\Feature;

use App\Item;
use App\Rate;
use App\Purchase;
use App\Supplier;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReportsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function stock_is_accessible()
    {
        $this->withoutExceptionHandling();
        $item = factory(Item::class)->create();
        $quantity = $this->faker->randomNumber(4);
        $bonus = $this->faker->randomNumber(1);
        $this->add_a_purchase($item->id, $quantity, $bonus, 10, 'purchase');
        $this->assertEquals($item->maxzan(), $quantity + $bonus);
        // $this->post(route('show-item-stock', ['barcode' => $item->id]));
        // ->assertStatus(200);

        // //     ->assertSee($item->name)
        // //     // ->assertSee("$bonus")
        // ->assertSee('Expire')
        // ->assertSee('Bought')
        // ->assertSee('Sold')
        // ->assertSee('Stock');

        // ->assertSee($item->name);
    }
    /** @test */

    public function  supplier_debt_is_correct()
    {
        $this->actingAs(factory(User::class)->create());
        $supplier = factory(Supplier::class)->create();
        $item = factory(Item::class)->create(['purchase_price' => 10]);
        $quantity = 10;
        $bonus = 10;
        $ppi = $this->faker->randomDigitNotNull;
        $purchase = $this->add_a_purchase($item->id, $quantity, $bonus, $ppi, 'purchase', $supplier->id);
        $purchase2 = $this->add_a_purchase($item->id, $quantity, $bonus, $ppi, 'purchase', $supplier->id);
        $this->assertEquals($supplier->debt(),  $purchase->total + $purchase2->total);
    }

    /** @test */
    public function  debt_report_only_displays_the_chose_supplier()
    {
        $this->signIn();
        $supplier = factory(Supplier::class)->create();
        $supplier2 = factory(Supplier::class)->create();
        $this->post(route('supplier-debt-report'), ['supplier_id' => $supplier->id])
            ->assertSee($supplier->name)
            ->assertDontSee($supplier2->name)
            ->assertSee($supplier->debt());
    }

    /** @test */
    public function  debt_report_shows_all_supplier_if_explicitly_selected()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(factory(User::class)->create(['type' => 'admin']));
        $supplier = factory(Supplier::class)->create(['name' => 'azhi']);
        $supplier2 = factory(Supplier::class)->create(['name' => 'faraj']);
        $this->post(route('supplier-debt-report'), ['supplier_id' => '-1'])
            ->assertSee($supplier->name)
            ->assertSee($supplier2->name)
            ->assertSee($supplier->debt())
            ->assertSee($supplier2->debt());
    }
    public function add_a_sale($item_id, $quantity, $singles, $ppi, $type)
    {
        $rate = factory(Rate::class)->create();
        $user = factory(User::class)->create();
        $rate = factory(Rate::class)->create();
        $this->actingAs($user);

        $data = [
            'barcode' => [$item_id],
            'ppi' => [$ppi],
            'quantity' => [$quantity],
            'exp' => [$this->faker->date],
            'batch_no' => [$this->faker->word],
            'singles' => [$singles],
            'howManyItems' => 1,
            'type' => $type,
            'total' => $this->faker->numberBetween(1, 1000),
            'rate' => $rate->rate,
            'discount' => 0,
        ];
        $this->post(route('store-sale'), $data);
    }
    public function add_a_purchase($item_id, $quantity, $bonus, $ppi, $type, $supplier_id = 0)
    {

        $this->actingAs(factory(User::class)->create());
        if ($supplier_id == 0)
            $supplier_id = factory(Supplier::class)->create()->id;
        $data = [
            'total' => 10,
            'invoice_no' => 'abcd',
            'type' => $type,
            'supplier_id' => $supplier_id,
            'item' => [
                'quantity' => [$quantity],
                'batch_no' => [''],
                'bonus' => [$bonus],
                'ppi' => [$ppi],
                'sppi' => [1000],
                'barcode' => [$item_id],
                'exp' => ['2022-01-01', '2023-01-01']
            ]
        ];

        $this->post(route('store-purchase'), $data);
        return Purchase::latest()->first();
    }
}
