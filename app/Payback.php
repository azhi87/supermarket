<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payback extends Model
{
    public function teamLeader()
    {
    	return $this->belongsTo('\App\User','user_id');
    }
    
    	public function supplier()
	{
		return $this->belongsTo('\App\Supplier');
	}
	
		public function user()
	{
		return $this->belongsTo('\App\User','user_id');
	}
	
    public function currencyText()
    {
    	if($this->currency=='$')
    	{
    		return 'دۆلار';
    	}
    	else
    	{
    		return 'دینار';
    	}
    }
}
