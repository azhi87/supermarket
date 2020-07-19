<?php

namespace App;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
class Customer extends Model
{


    public function scopeNotDeleted($query)
    {
        return $query->where('deleted', '=', 'active');
    }
    
    public function garak()
    {
    	return $this->belongsTo('\App\Garak');
    }

    public function sales()
    {
    	return $this->hasMany('\App\Sale');
    }

    public function notes()
    {
    	return $this->hasMany('\App\Note');
    }

    public function debts()
    {
    	return $this->hasMany('\App\Debt');
    }
    
    public function customerDebt()
    {
    	$total= $this->sales()->sum('total');
    	$paid=$this->sales->sum('calculatedPaid');
    	$repaid=$this->debts->sum('calculatedPaid');
    	return round(($total-($paid+$repaid)),2);
    }
    
    public function customerDebtIncludingNotOk()
    {
    	$total= $this->sales()->where('status','1')->sum('total');
    	$paid=$this->sales->where('status','1')->sum('calculatedPaid');
    	$repaid=$this->debts->sum('calculatedPaid');
    	return round(($total-($paid+$repaid)),2);
    }
    
    public function customerReturnsQuantityByDate($from,$to)
    {
        return $this->returns()->whereDate('created_at','>=',$from)
                             ->whereDate('created_at','<=',$to)
                             ->sum('quantity');
    }
    public function customerReturnsAmountByDate($from,$to)
    {
        return $this->returns()->whereDate('created_at','>=',$from)
                             ->whereDate('created_at','<=',$to)
                             ->sum(DB::raw('(ppi * quantity)'));
    }
    public function returns()
    {
        return $this->hasMany('\App\Ireturn');
    }
    public function totalReturnsRemainedPrice()
    {
       return DB::table('ireturns')->where('payback','0')
                                ->where('customer_id',$this->id)
                                ->sum(DB::raw('(ppi * quantity)'));
    }
    public function daysFromLastDebtPayment()
    {

        if (count($this->debts->max('created_at')) && floor($this->customerDebt())>0) 
        { 
            if($this->debts()->latest()->first()->new_total_debt<1 )
            {
                if(count($this->sales->where('created_at','>',$this->debts()->latest()->first()->created_at)))
                {
                    return $this->sales()
                                 ->where('created_at','>',$this->debts()->latest()->first()->created_at)
                                 ->latest()
                                 ->first()
                                 ->created_at
                                 ->diffInDays(Carbon::now());
                }
                return $this->debts()->latest()->first()->created_at->diffInDays(Carbon::now());      
                }
            else
            {
                return $this->debts()->latest()->first()->created_at->diffInDays(Carbon::now());
            }
        }
        elseif(floor($this->customerDebt())<=0)
        {
            return 'هیچ قەرزار نیە';
        }
        elseif(floor($this->customerDebt())>0)
        {
             if (count($this->sales->max('created_at')))
             {
                 return $this->sales()
                                 ->latest()->first()->created_at
                                 ->diffInDays(Carbon::now());
             }
             else 
             {
                 return 'هیچ کڕیبێکی نییە';
             }
        }
        else
        {
            return 'قەرزدانەوەی نیە';
        }
    }

    public function daysFromLastSale()
    {
        if (count($this->sales->max('created_at'))) 
        { 
            return $this->sales->max('created_at')->diffInDays(Carbon::now());
        }
        else
        {
            return 'هیچ کڕینێکی نییە';
        }
    }
    public function bgChange()
    {
        if($this->daysFromLastDebtPayment()>=20 && $this->daysFromLastDebtPayment()<40)
            return 'bg-yellow';
        elseif($this->daysFromLastDebtPayment()>=40)
        {
            return 'bg-red';
        }
    }
    public function hasUnConfirmedDebts()
    {
        $count=\App\Debt::where('status','1')->where('customer_id',$this->id)->count();
        if($count>0 && \Auth::user()->type!='accountant_high' && \Auth::user()->type!="admin")
            {
                return true;
            }
        else
            {
                return false;
            }
        
    }
    public function addAutoNote()
    {
        $message="";
        if($this->naqdOrQarz=="naqd")
        {
             $message="نەقد - ";
        }
        elseif($this->naqdOrQarz=="qarz")
        {
            $message="قەرز - ";
        }
        
        if(!count($this->sales))
        {
            $message.="ئەم کڕیارە تازەیە ";
        }
      
        return $message;
    }

}
?>