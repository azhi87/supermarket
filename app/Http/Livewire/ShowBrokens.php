<?php

namespace App\Http\Livewire;

use App\Broken;
use Livewire\Component;
use Livewire\WithPagination;

class ShowBrokens extends Component
{
    use WithPagination;
    protected $listeners = ['refresh'];
    public function render()
    {
        return view('livewire.show-brokens', [
            'brokens' => Broken::latest()->paginate(10)
        ]);
    }
    public function delete($id)
    {
        Broken::destroy($id);
    }
    public function refresh()
    {
        $this->reset();
    }
}
