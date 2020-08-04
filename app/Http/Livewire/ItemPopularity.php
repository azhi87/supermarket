<?php

namespace App\Http\Livewire;

use DB;
use App\Stock;
use Carbon\Carbon;
use Livewire\Component;

class ItemPopularity extends Component
{
    public $populars;
    public $leastPopulars;
    public $days=30;
    public function mount(){
        $this->updated();
    }
    public function updated(){
        if(!is_numeric($this->days))
            $this->days=1;
        $start_date=Carbon::today()->addDays(-1 * $this->days);
        $this->populars=Stock::where('type','sale')
                        ->whereDate('created_at','>=',$start_date)
                        ->select(DB::raw('sum(quantity) as quantity'),'item_id')
                        ->groupBy('item_id')
                        ->orderBy('quantity')
                        ->limit(100)
                        ->get();

         $this->leastPopulars=Stock::where('type','sale')
                         ->whereDate('created_at','>=',$start_date)
                        ->select(DB::raw('sum(quantity) as quantity'),'item_id')
                        ->groupBy('item_id')
                        ->orderBy('quantity','desc')
                        ->limit(100)
                        ->get();

    }
    public function render()
    {
        return view('livewire.item-popularity',[
            'populars' => $this->populars,
            'leastPopular' => $this->leastPopulars
        ]);
    }
}
