<?php

namespace Tests\Feature;

use App\Rate;
use App\Sale;
use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function  a_user_with_status_0_will_not_be_displayed_in_the_home_page()
    {
        $this->withoutExceptionHandling();
        $blockedUser = factory(User::class)->create(['status' => '0']);
        $activeUser = factory(User::class)->create();
        $this->signIn($activeUser);
        $this->get('/')
            ->assertStatus(200)
            ->assertDontSee($blockedUser->name);
    }
    /** @test */
    public function only_admin_users_can_access_income_by_user_report()
    {
        $this->withoutExceptionHandling();
        $staffUser = factory(User::class)->create(['type' => 'staff']);
        $this->signIn($staffUser);
        $this->post(route('show-income-byUser'))
            ->assertSessionHasErrors();
    }
    /** @test */
    public function only_admins_can_access_debt_report()
    {
        $this->withoutExceptionHandling();
        $staffUser = factory(User::class)->create(['type' => 'staff']);
        $this->signIn($staffUser);
        $this->post(route('supplier-debt-report'))
            ->assertSessionHasErrors();
    }

    /** @test */
    public function only_admins_can_access_income_report()
    {
        $this->withoutExceptionHandling();
        $staffUser = factory(User::class)->create(['type' => 'staff']);
        $this->signIn($staffUser);
        $this->post(route('income-money'))
            ->assertSessionHasErrors();
    }

    /** @test */
    public function sum_of_sales_for_today_is_correct()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create(['type' => 'staff']);
        $this->signIn($user);
        $sale = factory(Sale::class)->create(['user_id' => $user->id]);
        $sale2 = factory(Sale::class)->create(['user_id' => $user->id]);
        // sale3 is stored yesterday hence shouldn't be counted
        $sale3 = factory(Sale::class)->create(['user_id' => $user->id]);
        $sale3->created_at = Carbon::yesterday();
        $sale3->save();
        // sale4 is for a different user hence shouldn't be counted 
        $sale4 = factory(User::class)->create();
        $this->assertEquals($user->todayAmount()->total, $sale->total + $sale2->total);
        $this->assertEquals($user->todayAmount()->discount, $sale->discount + $sale2->discount);
    }
}
