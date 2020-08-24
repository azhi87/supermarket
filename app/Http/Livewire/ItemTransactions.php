<?php

namespace App\Http\Livewire;

use DB;
use App\Item;
use App\Stock;
use Livewire\Component;

class ItemTransactions extends Component
{
    public $item_id;
    public $query;
    public function mount($id)
    {
        $this->item_id = $id;
        $this->transactions = Stock::with('item')
            ->where('item_id', $this->item_id)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function render()
    {
        return view('livewire.item-transactions', [
            'transactions' => $this->transactions,
        ]);
    }
}
