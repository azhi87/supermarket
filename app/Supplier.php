<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Supplier extends Model
{
    public function purchases(){
        return $this->hasMany(Purchase::class);
    }
    public function paybacks(){
        return $this->hasMany(Payback::class);
    }
    public function debt(){
        return $this->purchases->sum('total') - ($this->paybacks->sum('paid') + $this->paybacks->sum('discount'));
    }
}
