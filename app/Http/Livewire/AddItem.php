<?php

namespace App\Http\Livewire;

use \App\Item;
use \App\Category;
use App\Manufacturer;
use Livewire\Component;

class AddItem extends Component
{
    public $barcode;
    public $name;
    public $name_en;
    public $items_per_box;
    public $category_id;
    public $manufacturer_id;
    public $description;
    public $cats;
    public $mans;
    
    public function mount(){
        $this->cats=Category::all();
        $this->mans=Manufacturer::all();
    }
    public function updated($field)
    {   
            $this->validateOnly($field,[
            'name'=>'required|min:3',
            'name_en'=>'required|min:3',
            'category_id'=>'required|exists:categories,id',
            'items_per_box'=>'required|numeric|min:1',
            'barcode'=>'required|unique:items,barcode',
            
            ]);
    }
    public function render()
    {
        return view('livewire.add-item');
    }
    
    public function store(){
       $data= $this->validate([
            'name'=>'required|min:3',
            'name_en'=>'required|min:3',
            'category_id'=>'required|exists:categories,id',
            'items_per_box'=>'required|numeric|min:1',
            'barcode'=>'required|unique:items,id',
            'manufacturer_id' => 'numeric',
            
            ]);
            
        $item=Item::create($data);
        session()->flash('message','Success');
        $this->name='';
        $this->name_en='';
        $this->category_id=1;
        $this->manufacturer_id=1;
        $this->items_per_box='';
        $this->barcode='';
        $this->emit('refreshItems');
    }
}
