<?php

namespace App\Http\Livewire;

use App\Category;
use App\Item;
use App\Manufacturer;
use Livewire\Component;

class UpdateDrug extends Component
{
    public $barcode;
    public $name;
    public $name_en;
    public $items_per_box;
    public $category_id;

    public $purchase_price;
    public $sale_price_id;

    public $manufacturer_id;
    public $description;
    public $cats;
    public $mans;
    public $item_id;
    public $updated = false;
    public function mount(Item $item)
    {
        $this->name = $item->name;
        $this->name_en = $item->name_en;
        $this->items_per_box = $item->items_per_box;
        $this->category_id = $item->category_id;
        $this->manufacturer_id = $item->manufacturer_id;
        $this->description = $item->description;
        $this->cats = $item->cats;
        $this->mans = $item->mans;
        $this->sale_price_id = $item->sale_price_id;
        $this->purchase_price = $item->purchase_price;
        $this->item_id = $item->id;
        $this->barcode = $item->barcode;
    }
    public function updated($field)
    {
        $data = $this->validateOnly($field, [
            'name' => 'required|min:3',
            'name_en' => 'required|min:3',
            'category_id' => 'required|exists:categories,id',
            'items_per_box' => 'required|numeric|min:1',
            'barcode' => 'required|unique:items,barcode',
            'manufacturer_id' => 'numeric',
            'sale_price_id' => 'numeric'
        ]);
        $item = Item::find($this->item_id);
        $item->update($data);
        $this->updated = true;
    }
    public function render()
    {
        return view('livewire.update-drug', [
            'categories' => Category::all(),
            'manufacturers' => Manufacturer::all()
        ]);
    }
    public function update()
    {
    }
}
