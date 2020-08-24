<?php

namespace Tests\Unit;

use App\Payback;
use App\Purchase;
use App\Supplier;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SupplierTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic unit test example.
     *
     * @return void
     */

    /** @test */
    public function  can_add_supplier()
    {
        $this->actingAs(factory(User::class)->create());
        $this->withoutExceptionHandling();
        $supplier = factory(Supplier::class)->raw();
        $this->post(route('store-supplier'), $supplier);
        $this->assertDatabaseHas('suppliers', ['name' => $supplier['name']]);
    }

    /** @test */
    public function  can_view_suppliers()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(factory(User::class)->create());
        $supplier = factory(Supplier::class)->create();

        $this->get(route('show-suppliers'))
            ->assertStatus(200)
            ->assertSee($supplier->name)
            ->assertSee($supplier->mobile)
            ->assertSee($supplier->address)
            ->assertSee(route('edit-supplier', $supplier->id))
            ->assertSee($supplier->debt());
    }

    /** @test */
    public function purchases_increase_supplier_debt()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $supplier = factory(Supplier::class)->create();
        $anotherSupplier = factory(Supplier::class)->create();
        $purchase = factory(Purchase::class)->create(['supplier_id' => $supplier->id]);
        // $this->assertEquals($supplier->debt(), $purchase->total);
        $purchase2 = factory(Purchase::class)->create(['supplier_id' => $supplier->id]);
        $anotherSupplierPurchase = factory(Purchase::class)->create(['supplier_id' => $anotherSupplier->id]);
        $this->assertEquals($supplier->debt(), $purchase->total + $purchase2->total);
        $this->assertEquals($anotherSupplier->debt(), $anotherSupplierPurchase->total);
    }

    /** @test */
    public function  payback_decreases_supplier_debt()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $supplier = factory(Supplier::class)->create();
        $purchase = factory(Purchase::class)->create(['supplier_id' => $supplier->id]);
        $purchase2 = factory(Purchase::class)->create(['supplier_id' => $supplier->id]);
        $this->assertEquals($supplier->debt(), $purchase->total + $purchase2->total);
        $payback = factory(Payback::class)->create(['supplier_id' => $supplier->id]);
        $debt = ($purchase->total + $purchase2->total - $payback->amount);
        $this->assertEquals($supplier->debt(), $debt);
    }
}
