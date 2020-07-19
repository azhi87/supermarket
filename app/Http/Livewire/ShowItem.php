<?php

namespace App\Http\Livewire;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use \App\Item;
use Livewire\WithPagination;
class ShowItem extends Component
{
    use WithPagination;
    use AuthorizesRequests;
	protected $listeners=['refreshItems'=>'refresh'];
    public $customer_count;
    public $ampers_sum;
    public $query;
    public function render()
    {
        $query='%' . $this->query . '%';
        return view('livewire.show-item',[
            'items'=>$this->items=Item::where('name','like', $query)->orWhere('barcode','like',$query)->latest()->paginate(10)
        ]);
    }

    public function mount()
    {
    	$this->refresh();
    }

    public function refresh()
    {
    	$this->customer_count=1;

        $this->ampers_sum=2;

    }

  



}

