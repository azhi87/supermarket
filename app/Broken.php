<?php

namespace App;

use App\Item;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Broken extends Model
{
    protected $guarded = [];
    public function  item()
    {
        return $this->belongsTo(Item::class);
    }
    public function  user()
    {
        return $this->belongsTo(User::class);
    }
}
