<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class uEvent extends Model
{
    public function user()
    {
    	return $this->belongsTo('\App\User','user_id');
    }
    public function holiday($user_id,$days=1)
    {
    	for($i=1; $i<=$days; $i++)
    	{
	    	$maxSeq=DB::table('u_events')->where('user_id',$user_id)->max('sequence');
	    	if($maxSeq==0)
	    	{
	    		break;
	    	}
	    	DB::statement('update u_events set sequence=mod(sequence,'.$maxSeq.')+1 where user_id='.$user_id);
	    	$event=new \App\Event();
	    	$event->user_id=$user_id;
	    	$event->title="پشوو";
	    	$event->start_date=Carbon::today()->addDays($i-1);	
	    	$event->save();
    	}
    }

    public function cancelHoliday($user_id,$days=1)
    {
    	$test=[];
    	$maxSeq=DB::table('u_events')->where('user_id',$user_id)->max('sequence');
    	for($i=1; $i<=$days; $i++)
    	{
	    	$test[$i]='update u_events set sequence='.$maxSeq.' where sequence=0 & user_id='.$user_id;
	    	if($maxSeq==0)
	    	{
	    		break;
	    	}
	    	//DB::statement('update u_events set sequence=sequence-1 where user_id='.$user_id);
	    	DB::table('u_events')->where('user_id',$user_id)->decrement('sequence');
	    	DB::table('u_events')->where('user_id',$user_id)->where('sequence',0)->update(['sequence'=>$maxSeq]);
	    	//DB::statement('update u_events set sequence='.$maxSeq.' where sequence=0 & user_id='.$user_id);
	    	DB::table('events')->where('user_id',$user_id)
	    						->where('start_date',Carbon::today()->addDays($i-1))
	    						->where('title','پشوو')
	    						->delete();
    	}
    }

    public function publicHoliday($days)
    {
    	$users=\App\User::all();
    	foreach ($users as $key => $value) {
    		$this->holiday($value->id,$days);	
    	}
    }
    public function cancelPublicHoliday($days)
    {
    	$users=\App\User::all();
    	foreach ($users as $key => $value) {
    		$this->cancelHoliday($value->id,$days);	
    	}
    }
}


