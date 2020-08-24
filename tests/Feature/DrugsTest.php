<?php

namespace Tests\Feature;

use App\Category;
use App\Http\Livewire\AddItem;
use App\Manufacturer;
use Tests\TestCase;
use App\User;
use App\Rate;
use App\Item;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

class DrugsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function homepage_is_accessible()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $rate = factory(Rate::class)->create();
        $this->actingAs($user);
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee("Today's Income");
        $response->assertSee('Three Month Expiry');
        $response->assertSee("One Month Expiry");
    }

    /** @test */
    public function  authenticated_users_can_view_drugs()
    {
        $user = factory(User::class)->create();
        $item = factory(Item::class)->create();
        $this->be($user);
        $this->get(route('show-items'))
            ->assertStatus(200)
            ->assertSee($item->barcode);
    }

    /** @test */
    public function  authenticated_users_can_update_drug_link()
    {
        $user = factory(User::class)->create();
        $item = factory(Item::class)->create();
        $this->be($user);
        $this->get(route('show-items'))
            ->assertStatus(200)
            ->assertSee($item->barcode)
            ->assertSee(route('edit-item', $item->id));
    }
    /** @test */
    public function can_add_drug()
    {
        $this->actingAs(factory(User::class)->create());
        Livewire::test(AddItem::class)
            ->set('name', 'Paracetamol1')
            ->set('name_en', 'Paracetamol scientific')
            ->set('category_id', factory(Category::class)->create()->id)
            ->set('items_per_box', 20)
            ->set('barcode', '12312312312312')
            ->set('manufacturer_id', factory(Manufacturer::class)->create()->id)
            ->call('store');
        $this->assertTrue(Item::whereName('Paracetamol1')->exists());
        $this->assertTrue(Item::whereBarcode('12312312312312')->exists());
    }



    /** @test */
    public function  can_see_add_manufacturer_component()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(factory(User::class)->create());
        $this->get(route('add-item'))
            ->assertSeeLivewire('add-manufacturer');
    }

    /** @test */
    public function  can_see_all_manufacturers()
    {
        $this->actingAs(factory(User::class)->create());
        $manufacturer = factory(Manufacturer::class)->create();
        $this->get(route('add-item'))
            ->assertSee($manufacturer->name);
    }
    /** @test */
    public function  can_update_item()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(factory(User::class)->create());
        $item = factory(Item::class)->create();
        $data = $item->toArray();
        $data = [
            "barcode" => 266632459,
            "sale_price" => 5851,
            "sale_price_id" => 2729,
            "items_per_box" => 10,
            "purchase_price" => 10,
            "description" => "Eius expedita qui natus maiores vitae consequuntur vero.",
            "category_id" => 1,
            "supplier_id" => 1,
            "manufacturer_id" => 1,
            "sale_price_discount" => 0,
            "status" => "1",
            "maxzan" => 21,
            "name" => "hello",
            "name_en" => "Delaney Kozey",

        ];
        $this->post(route('update-item', $item->id), $data);
        $this->assertTrue(Item::whereName('hello')->exists());
    }
}
