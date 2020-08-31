<?php

namespace App\Http\Livewire;

use App\Broken;
use App\Stock;
use Livewire\Component;
use Livewire\WithPagination;

class ShowBrokens extends Component
{
    use WithPagination;
    protected $listeners = ['refresh'];
    public $showDeleteButton = false;
    public $query;
    public function render()
    {
        $term = '%' . $this->query . '%';
        return view('livewire.show-brokens', [
            'brokens' =>  Broken::whereHas('item', function ($query) use ($term) {
                $query->where('name', 'like', $term)->orWhere('barcode', 'like', $term);
            })->latest()->paginate(10)
        ]);
    }
    public function delete($id)
    {
        Stock::whereType('broken')->where('source_id', $id)->delete();
        Broken::destroy($id);
        $this->showDeleteButton = false;
    }
    public function showDeleteButton()
    {
        $this->showDeleteButton = true;
    }
    public function refresh()
    {
        $this->reset();
    }
}
