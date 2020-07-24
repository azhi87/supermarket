<?php

namespace App\Http\Livewire;

use App\Manufacturer;
use Livewire\Component;

class AddManufacturer extends Component
{
    public $name;
    public function render()
    {
        return view('livewire.add-manufacturer');
    }
    public function updated(){
        $this->validate([
            'name' => 'required'
        ]);
    }
    public function store(){
         $data = $this->validate([
            'name' => 'required|unique:manufacturers,name'
        ]);
        Manufacturer::create($data);
        $this->name="";
         session()->flash('message','Success');
    }
}
