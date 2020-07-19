<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	public function Items()
	{
		return $this->hasMany('App\Item','category_id');
	}
    }
