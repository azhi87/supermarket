<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payback extends Model
{
    
    	public function supplier()
	{
		return $this->belongsTo('\App\Supplier');
	}
		public function user()
	{
		return $this->belongsTo('\App\User','user_id');
	}
	
    
}
