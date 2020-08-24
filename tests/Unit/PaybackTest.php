<?php

namespace Tests\Unit;

use App\Payback;
use App\Purchase;
use App\Supplier;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaybackTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    /** @test */
    public function  can_view_paybacks()
    {
        $this->withoutExceptionHandling();
        $supplier = factory(Supplier::class)->create();
        $this->actingAs(factory(User::class)->create());
        $purchases = factory(Purchase::class, 100)->create(['supplier_id' => $supplier->id]);
        $paybacks = factory(Payback::class, 100)->create(['supplier_id' => $supplier->id]);
        $this->get(route('payback', $supplier->id))
            ->assertStatus(200)
            ->assertSee(htmlspecialchars($supplier->name))
            ->assertSee(number_format($supplier->purchases()->sum('total'), 2))
            ->assertSee($supplier->paybacks->sum('amount'))
            ->assertSee($supplier->purchases->sum('discount'))
            ->assertSee(route('show-supplier-purchases', $supplier->id));
    }

    /** @test */
    public function  can_add_payback()
    {
        $this->withoutExceptionHandling();
        $this->be(factory(User::class)->create());
        $payback = factory(Payback::class)->raw();
        $this->post(route('store-payback'), $payback);
        $this->assertDatabaseHas('paybacks', ['paid' => $payback['paid'], 'supplier_id' => $payback['supplier_id']]);
    }

    /** @test */
    public function amount_is_requried()
    {
        $data = factory(Payback::class)->raw(['paid' => '']);
        $this->actingAs(factory(User::class)->create());
        $this->post(route('store-payback'), $data)
            ->assertSessionHasErrors('paid');
    }

    /** @test */
    public function discount_is_required()
    {
        $data = factory(Payback::class)->raw(['discount' => '']);
        $this->actingAs(factory(User::class)->create());
        $this->post(route('store-payback'), $data)
            ->assertSessionHasErrors('discount');
    }


    /** @test */
    public function  can_edit()
    {
        $this->actingAs(factory(User::class)->create());
        $payback = factory(Payback::class)->create();
        $this->get(route('edit-payback', $payback->id))
            ->assertStatus(200)
            ->assertSee($payback->paid)
            ->assertsee($payback->supplier_id)
            ->assertsee('Discount')
            ->assertSee($payback->note);
    }
    /** @test */
    public function can_update()
    {
        $this->actingAs(factory(User::class)->create());
        $payback = factory(Payback::class)->create();
        $payback = $payback->toArray();
        $payback['paid'] = 111;
        $payback['discount'] = 222;
        $payback['note'] = '';
        $this->post(route('store-payback', $payback));
        $this->assertDatabaseHas('paybacks', [
            'paid' => 111,
            'discount' => 222,
            'note' => 'note'
        ]);
    }

    /** @test */
    public function can_print_payback()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(factory(User::class)->create());
        $payback = factory(Payback::class)->create();
        $this->get(route('print-payback', $payback->id))
            ->assertStatus(200);
    }
}
