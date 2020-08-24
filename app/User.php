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
        'name', 'email', 'password', 'status', 'type', 'mobile'
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
        return $this->where('type', 'driver')->where('status', '1')->get();
    }
    public function sales()
    {
        return $this->hasMany('\App\Sale');
    }


    public function isAdmin()
    {
        if ($this->type === 'admin')
            return true;
        else {
            return false;
        }
    }
    public function typeText()
    {
        if ($this->type == 'admin') {
            return 'Admin';
        }
        if ($this->type == 'staff') {
            return 'Staff';
        }
    }
    public function toggleStatus()
    {
        if ($this->status == "1")
            $this->status = "0";
        elseif ($this->status == "0") {
            $this->status = "1";
        }
        $this->save();
    }
    public function suppliers()
    {
        return DB::table('user_suppliers')->where('user_id', $this->id)->pluck('supplier_id')->toArray();
    }



    public function todayAmount()
    {
        return DB::table('sales')
            ->where('user_id', $this->id)
            ->where('created_at', '>=', Carbon::today())
            ->selectRaw('SUM(total) as total,SUM(discount) as discount')
            ->first();
    }
}
