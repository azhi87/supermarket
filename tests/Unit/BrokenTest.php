<?php

namespace Tests\Unit;

use App\Item;
use App\Broken;
use Tests\TestCase;
use Livewire\Livewire;
use App\Http\Livewire\AddBroken;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BrokenTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    /** @test */
    public function  can_store_broken()
    {
        $this->signIn();
        $this->withoutExceptionHandling();
        $broken = factory(Broken::class)->create();
        $this->assertDatabaseHas('brokens', [
            'id' => $broken->id,
            'item_id' => $broken->item->id
        ]);
    }
    /** @test */
    public function  livewire_components_exists()
    {
        $this->signIn();
        $this->withoutExceptionHandling();
        $broken = factory(Broken::class)->create();
        $this->get(route('show-brokens'))
            ->assertSeeLivewire('add-broken');
    }

    /** @test */
    public function  livewire_can_store_brokens()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $item = factory(Item::class)->create();
        Livewire::test(AddBroken::class)
            ->set('item_id', $item->id)
            ->set('quantity', 1)
            ->set('exp', $this->faker->date)
            ->call('store');
        $this->assertDatabaseHas('brokens', ['item_id' => $item->id]);
    }

    /** @test */
    public function  adding_broken_will_reduce_stock()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $quantity = $this->faker->randomDigitNotNull;
        $item = factory(Item::class)->create();
        Livewire::test(AddBroken::class)
            ->set('item_id', $item->id)
            ->set('quantity', $quantity)
            ->set('exp', $this->faker->date)
            ->call('store');
        $this->assertEquals($item->maxzan(), -$quantity);
    }
}
