@extends('layouts.master')
@section('content')

<div class="row bordered-2" >
    
<div class="col-md-12 col-sm-12 text-center">
</br>
    <strong><p style="font-size: 48px; "> ڕاپۆرتی فرۆشتنەکان</p> </strong>
    </br>
    @if(isset($from) && isset($to))
                    <div class="col-md-6 text-center col-md-offset-3">
                        <label class="text-center text-danger"><span class="color-black">بۆ بەرواری : </span>  {{$to}} </label> 
                        <label class="text-center text-danger"><span class="color-black">لە بەرواری: </span> {{$from}} </label>         
                    </div>
        @endif
    </br>
</div>
</div>


<div class="row bordered-1" >

</div>

<div class="row bordered-1">

<div class="col-md-12 col-sm-12 col-xs-12">

        <table class="table table-bordered table-responsive table-text-center tfs16boldc ">
        <tr class="bg-info" >
             <th >کۆی وەصل</th>    
            <th >ژمارەی وەصل</th>       
            <th >ناوی شۆفێر</th>
            <th >ناوی کڕیار</th>
            <th >کۆدی کڕیار </th>
            <th>#</th>
        </tr>
<?php $i=1;?>
@foreach ($sales as $sale)

<tr>
     <td>{{number_format($sale->total,2)}}</td>
    <td>{{$sale->id}}</td>
    <td>{{$sale->driverName()}}</td>
    <td>{{$sale->customer->name}}</td>
    <td>{{$sale->customer->id}}</td>
    <td>{{$i++}}</td>
</tr>
@endforeach

<tr class="text-black">
    <th colspan="5" class="h3 text-primary"><strong>کۆی گشتی : {{number_format($sales->sum('total'),2)}}</strong></th>

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