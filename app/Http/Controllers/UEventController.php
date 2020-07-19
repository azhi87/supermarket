<?php

namespace App\Http\Controllers;
use Calendar;
use Illuminate\Http\Request;
use \App\uEvent;
use DB;
use Carbon\Carbon;
class UEventController extends Controller
{
    public function index($id=0)
    {
    	
    	if($id==0)
    	{
    		return view('calendar.addUserEvents',compact('todaySequence'));
    	}
    	else
    	{
    		$selectedUser=\App\User::find($id);
    		$calendar=$selectedUser->generateUserCalendar();
    		return view('calendar.addUserEvents',compact(['selectedUser','calendar']));
    	}
    }
    public function show(Request $request)
    {
    	$selectedUser=\App\User::find($request['user_id']);
    	$calendar=$selectedUser->generateUserCalendar();
    	return view('calendar.addUserEvents',compact(['selectedUser','calendar']));
    }
    public function store(Request $request,$id)
    {
    	if($id!=$request['user_id'])
    	{
    		return back()->withErrors('هەڵەیەک ڕوویدا');
    	}
    	
    	DB::table('u_events')->where('user_id',$id)->delete();
    	for($i=1; $i<=31; $i++)
    	{
    		if(!empty($request['description'.$i]))
    		{
    			$uevent=new uEvent();
    			$uevent->sequence=$request['sequence'.$i];
    			$uevent->description=$request['description'.$i];
    			$uevent->user_id=$id;
    			$uevent->save();
    		}
    		else
    		{
    			break;
    		}

    	}
    	return redirect('/user-events/'.$id);
    }

   
}
