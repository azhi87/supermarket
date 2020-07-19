<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
	public function items()
	{
		return $this->belongsToMany('App\Item','sale_items')->withPivot('quantity','ppi','singles','exp','id')->withTimestamps();
	}
	
	public function user()
	{
		return $this->belongsTo('App\User');
	}
	public function customer()
	{
		return $this->belongsTo('App\Customer');
	}
	public function countUnConfirmed()
	{
		if(\Auth::user()->type=='mandwb')
			{
				return $this->where('status','0')->where('user_id',\Auth::user()->id)->count();
			}
			else
			{
				return $this->where('status','0')->count();
				
			}
	} 
	public function statusText()
	{
		if($this->status=='0')
		{
			return'NO';
		}
		else
		{
			return 'OK';
		}
	}
	public function driverName()
	{
		if($this->driver=="")
		{
			return "";
		}
		else
		{
			return \App\User::find($this->driver)->name;
		}
	}

	public function drivermobile()
	{
		if($this->driver=="")
		{
			return "";
		}
		else
		{
			return \App\User::find($this->driver)->mobile;
		}
	}


}
