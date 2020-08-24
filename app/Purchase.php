<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    public function items()
    {
        return $this->belongsToMany('App\Item', 'purchase_items')->withPivot('quantity', 'ppi', 'bonus', 'exp', 'batch_no')->withTimestamps();
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }
}
