<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
    public function formattedAmount()
	{
    	return number_format($this->attributes['amount']);
	}

	public function scopeSearchFilter($query,$request)
    {
    	if($request->has('start_date'))
    		$query=$query->where('created_at','>=',$request['start_date']);
    	if($request->has('end_date'))
    		$query=$query->where('created_at','<=',$request['end_date']);
    	if($request->has('user_id'))
    		$query=$query->where('user_id','>=',$request['user_id']);
        
        return $query;
    }
}
