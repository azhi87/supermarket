<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Calendar;
use App\Event;
use App\uEvent;
use DB;
use Carbon\Carbon;
class EventController extends Controller
{
	public function makeHoliday(Request $request)
	{
        $this->validate(request(),
            [
                'user_id'=>'required',
                'days'=>'required|integer',
            ]
        );

		$event=new uEvent();
        if($request['user_id']!=-1)
        {
            if($request['category']=='cancel')
            {
                $event->cancelHoliday($request['user_id'],$request['days']);
            }
            else
            {
                $event->holiday($request['user_id'],$request['days']);
            }
            return redirect('/user-events/'.$request['user_id']);
        }
        else
        {
            if($request['category']=='cancel')
            {
                $event->cancelPublicHoliday($request['days']);
            }
            else
            {
                $event->publicHoliday($request['days']);
            }
            return redirect('/user-events');
        }
		
	}

    public function store(Request $request)
    {
        $this->validate(request(),
            [
                'title'=>'required'
            ]
        );
        $event=new Event();
        $event->user_id=\Auth::user()->id;
        $event->title=$request['title'];
        $event->start_date=$request['start_date'];
        $event->end_date=$request['start_date'];
        $event->save();
        return redirect('dayEvents/'.$request['start_date']);
    }
    public function dayEvents($day)
    {
        $events=Event::whereDate('start_date',$day)->where('user_id',\Auth::user()->id)->get();
        return view('calendar.dayEvents',compact(['events','day']));
    }
    public function index()
    {
        $calendar=\Auth::user()->generateUserCalendar();
        return view('main.index', compact('calendar'));
    }
    public function destroy($id)
    {
        DB::table('events')->where('id',$id)->delete();
        return back();
    }
}