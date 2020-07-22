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
    public $days;
    public function mount(){
        $this->days=30;
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
                        ->limit(10)
                        ->get();

         $this->leastPopulars=Stock::where('type','sale')
                         ->whereDate('created_at','>=',$start_date)
                        ->select(DB::raw('sum(quantity) as quantity'),'item_id')
                        ->groupBy('item_id')
                        ->orderBy('quantity','desc')
                        ->limit(10)
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
