<?php

namespace Tests\Unit;

use App\Expense;
use App\Rate;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExpenseTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /** @test */
    public function  home_page_is_accessible()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(factory(User::class)->create());
        $this->get(route('expenses'))
            ->assertStatus(200);
    }
    /** @test */
    public function  can_store_expense()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(factory(User::class)->create());
        $expense = factory(Expense::class)->raw();
        $this->post(route('store-expense'), $expense);
        $this->assertDatabaseHas('expenses', ['amount' => $expense['amount']]);
    }
    /** @test */
    public function  can_edit_expense()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(factory(User::class)->create());
        $expense = factory(Expense::class)->create();
        $this->get(route('edit-expense', $expense->id))
            ->assertStatus(200)
            ->assertSee(route('store-expense', $expense->id));
    }

    /** @test */
    public function can_update_expense()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(factory(User::class)->create());
        $expense = factory(Expense::class)->raw();
        $this->post(route('store-expense'), $expense);
        $this->assertDatabaseHas('expenses', ['amount' => $expense['amount']]);
        $expense['amount'] = 24.32;
        $id = Expense::latest()->first()->id;
        $this->post(route('store-expense', $id), $expense);
        $this->assertDatabaseHas('expenses', [
            'amount' => 24.32
        ]);
    }
}
