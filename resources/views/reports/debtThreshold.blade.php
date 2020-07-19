@extends('layouts.master')
@section('content')

<div class="row bordered-2" >
    
<div class="col-md-12 col-sm-12 text-center">
</br>
    <strong><p style="font-size: 48px; "> ڕاپۆرتی قەرزی کڕیار </p> </strong>
    </br>
        <span class="text-center">{{Carbon\Carbon::now()}}</span>

</div>
</div>


<div class="row bordered-1" >

</div>

<div class="row bordered-1">

<div class="col-md-12 col-sm-12 col-xs-12">

        <table class="table table-bordered table-responsive table-text-center tfs16boldc tfs24boldp ">
        <tr class="bg-info" >
               @if(Auth::user()->type=='admin' && $predebt==true)
             <th >قەرزی پێشتر</th>    
             @endif
            <th >سەرجەمی قەرز بە دۆلار</th>           
            <th >ناوی کڕیار</th>
            <th >کۆدی کڕیار </th>
        </tr>
        <?php 
                use Carbon\Carbon;
                $total=0;
                ?>
@foreach ($debts as $debt)
<?php
    if (count(\App\Customer::find($debt->id)->debts()->where('status','1')->max('created_at')))
    {
        $debtDays=\App\Customer::find($debt->id)->debts()->where('status','1')->latest()->first()->created_at->diffInDays(Carbon::now());
    }
    else
    {
        $debtDays=1;
    }
    if(count(\App\Customer::find($debt->id)->sales->where('status','1')->max('created_at')))
    {
        $saleDays=\App\Customer::find($debt->id)->sales()->where('status','1')->latest()->first()->created_at->diffInDays(Carbon::now());        
    }
    else
    {
        $saleDays=1;
    }
    if($debtDays===0 && $saleDays===0)
    {
        $bg="bg-green";
    }
    elseif($debtDays===0)
    {
        $bg="bg-yellow";
    }
    elseif($saleDays===0)
    {
        $bg="bg-red";
    }
    else
    {
        $bg="";
    }
?>
            <?php $total+=$debt->totalDebt;?>

<tr class="{{$bg}}">
    @if(Auth::user()->type=='admin' && $predebt==true)
     <td>{{number_format($debt->predebt,2)}}</td>
     @endif
    <td>{{number_format($debt->totalDebt,2)}}</td>
    <td>{{$debt->name}}</td>
    <td>{{$debt->id}}</td>
</tr>
@endforeach

<tr class="text-black">
    <th colspan="3"><strong>کۆی گشتی : {{number_format($total,2)}}</strong></th>

</tr>
</table>
</div>
</div>



@endsection

@section('afterFooter')
 <script type="text/javascript">
    $(document).ready(function () {
  $("#menu-top li a").removeClass("menu-top-active");              
  $('#report').addClass('menu-top-active');
  });
 </script>

 @endsection