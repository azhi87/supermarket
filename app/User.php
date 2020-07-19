<?php

namespace App;
use DB;
use Calendar;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','status','type','mobile'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function rates()
    {
        return $this->hasMany('\App\Rate');
    }
    public function drivers()
    {
        return $this->where('type','driver')->where('status','1')->get();
    }
    public function sales()
    {
        return $this->hasMany('\App\Sale');
    }
    public function debts()
    {
        return $this->hasMany('\App\Debt');
    }
    public function Mandwbs()
    {
        return $this->whereIn('type',['mandwb','accountant_hight','admin'])
            ->where('status','1')
            ->where('email','!=','azhi.faraj@gmail.com')
            ->get();
    }
    public function typeText()
    {
        if($this->type=='admin')
        {
            return 'ئەدمین';
        }
        if($this->type=='accountant')
        {
            return 'محاسب';
        }
        if($this->type=='accountant_high')
        {
            return 'محاسب باڵا';
        }
        if($this->type=='mandwb')
        {
            return 'مەندوب';
        }
        if($this->type=='driver')
        {
            return 'شۆفێر';
        }
        if($this->type=='accouantant_hight')
        {
            return 'محاسب باڵا';
        }
        if($this->type=='super_admin')
        {
            return 'ئەدمینی باڵا';
        }
        
        if($this->type=='supervisor')
        {
            return 'س.مەخزەن';
        }
    }
    public function toggleStatus()
    {
        if($this->status=="1")
            $this->status="0";
        elseif($this->status=="0")
        {
            $this->status="1";
        }
        $this->save();
    }
    public function suppliers()
    {
         return DB::table('user_suppliers')->where('user_id',$this->id)->pluck('supplier_id')->toArray();
    }

    public function hasSupplier($supplier_id)
    {
       if(in_array($supplier_id,$this->suppliers()))
       {
            return true;
       }
       else
       {
        return false;
       }
    }
    public function totalUnconfirmedDollars()
    {
        return DB::table('debts')->where('user_id',$this->id)
                                ->where('status','1')
                                ->sum('dollars');
    }
     public function totalUnconfirmedDinars()
    {
        return DB::table('debts')->where('user_id',$this->id)
                                ->where('status','1')
                                ->sum('dinars');
    }
    
    public function sumDebt()
    {

        return DB::table('staff_debts')->where('user_id',$this->id)->sum('amount');
    } 
   
   public function todayAmount()
   {
     return DB::table('sales')->where('user_id',$this->id)->where('created_at','>=',Carbon::today())->sum('total');
   }
   public function uevents()
   {
     return $this->hasMany('\App\uEvent','user_id')->orderBy('sequence');
   }

   public function events()
   {
     return $this->hasMany('\App\Event','user_id')->orderBy('sequence');
   }

   public function todaySequence($specific_date=0)
   {
            $begin_date=Carbon::createFromFormat('Y-m-d', '2018-06-02');
            if($specific_date!=0)
            {
                $now=Carbon::createFromFormat('Y-m-d', $specific_date);
            }
            else
            {
                $now=Carbon::now();
                
            }
            $todaySequence = $now->diffInDaysFiltered(function(Carbon $date) {
            return !($date->dayOfWeek == Carbon::FRIDAY);
            }, $begin_date);
            $udata=\App\uEvent::where('user_id',$this->id)->get();
            if($udata->count()==0)
            {
                return 0;
            }
            $todaySequence=($todaySequence)%($udata->count())+1;
            
            // if($now->dayOfWeek==Carbon::FRIDAY)
            //     {
            //         $todaySequence++;
            //     }
            if($todaySequence==0)
            {
                $todaySequence=$udata->count();
            }
            return $todaySequence;
   }

   public function dayEvent($specific_date)
   {
       return DB::table('u_events')->where('user_id',$this->id)
                                   ->where('sequence',$this->todaySequence($specific_date))
                                   ->value('description');
   }
    public function generateUserCalendar()
    {
        $events = [];
        $data = Event::where('user_id',$this->id)->get();
        if($data->count()) {
            foreach ($data as $key => $value) {
                $events[] = Calendar::event(
                    $value->title,
                    true,
                    new \DateTime($value->start_date),
                    new \DateTime($value->end_date.' +1 day'),
                    null,
                    // Add color and link on event
                    [
                        'color' => '#f05050',
                        // 'url' => '#',
                    ]
                );
            }
        }
        $begin_date=Carbon::createFromFormat('Y-m-d', '2018-06-02');
        $now=Carbon::now();
        $todayTask = $now->diffInDaysFiltered(function(Carbon $date) {
            return !($date->dayOfWeek == Carbon::FRIDAY);
            }, $begin_date);
            
                $udata=uEvent::where('user_id',$this->id)->orderBy('sequence')->get();
        if($udata->count()) {
            $todayTask=($todayTask)%$udata->count();
            $j=0;
            for($i=0; $i<=$udata->count(); $i++) 
            {

                if(Carbon::now()->addDays($j)->dayOfWeek==Carbon::FRIDAY)
                {
                    $j++;
                }
                // add a single more record 
                
                $events[] = Calendar::event
                (
                    $udata[$todayTask%$udata->count()]->description,
                    true,
                    new \DateTime(Carbon::now()->addDays($j)->format('Y-m-d')),
                    new \DateTime(Carbon::now()->addDays($j)->format('Y-m-d')),
                    null,
                    [
                        'color' => '#9f9d3a',
                        // 'url' => '#',
                    ]
                );
                $j++;
                $todayTask++;
            }
        }

        $calendar = Calendar::addEvents($events)->setOptions([
          'header:'=>'{
                        left:"prev,next",
                        center: "title",
                        right: ""
                    }'
        ])
        ->setCallbacks([ 
        'dayClick' => 'function(date, Event) { 
                                            window.location.href = "/dayEvents/"+date.format();
                                   }',
        'eventClick'=> 'function(event, jsEvent) {
            $("#modalBody").html(event.title);
            $("#fullCalModal").modal();
        }'

            ]);

        return $calendar;
    }
}
