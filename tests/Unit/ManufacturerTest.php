<?php

namespace Tests\Unit;

use App\Http\Livewire\AddManufacturer;
use App\Manufacturer;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

class ManufacturerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */

    /** @test */
    public function can_add_manufacturer()
    {
        $this->actingAs(factory(User::class)->create());
        Livewire::test(AddManufacturer::class)
            ->set('name', 'anything')
            ->call('store');
        $this->assertDatabaseHas('manufacturers', ['name' => 'anything']);
    }

    /** @test */
    public function name_is_required()
    {
        $this->actingAs(factory(User::class)->create());
        Livewire::test(AddManufacturer::class)
            ->set('name', '')
            ->call('store')
            ->assertHasErrors('name');
    }
    /** @test */
    public function name_should_be_unique()
    {
        $this->actingAs(factory(User::class)->create());
        $manufacturer = factory(Manufacturer::class)->create();
        Livewire::test(AddManufacturer::class)
            ->set('name', $manufacturer->name)
            ->call('store')

            ->assertHasErrors('name');
    }


    /** @test */
    public function  can_see_show_item_component()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(factory(User::class)->create());
        $this->get(route('add-item'))
            ->assertSeeLivewire('show-item');
    }
}
