<?php

namespace App\Http\Livewire;

use App\Broken;
use App\Events\BrokenCreatedEvent;
use App\Item;
use Illuminate\Console\Scheduling\Event;
use Livewire\Component;

class AddBroken extends Component
{
    public $barcode;
    public $item_id;
    public $quantity;
    public $exp;
    public $batch_no = '';
    public function render()
    {
        return view('livewire.add-broken');
    }
    public function updatedBarcode()
    {
        if ($this->barcode) {
            $item = Item::find($this->barcode);
            $this->exp = $item->expiryDatesWithExpiredItems()->last()->exp ?? '';
            $this->batch_no = $item->expiryDates()->first()->batch_no ?? '';
            $this->item_id = $this->barcode;
        }
    }
    public function store()
    {
        $data = $this->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|numeric|gt:0',
            'exp' => 'required|date',
            'batch_no' => 'max:55'
        ]);
        $data['user_id'] = auth()->user()->id;

        $broken = Broken::create($data);
        $this->reset();
        $this->emit('refresh');
        Event(new BrokenCreatedEvent($broken));
        session()->flash('message', 'success');
    }
}
