@extends('layouts.master')
@section('content')
<div class="row bordered-2" >
  
<div class="col-md-12 col-sm-12 col-sx-12 text-center">
</br>
  <strong><p style="font-size: 48px; "> ڕاپۆرتی مەندووبەکان</p> </strong>
    </br>
    </br>
</div>
</div>

<div class="row bordered-1" >

<br>

        <table class="table table-bordered tseparate-1 tfs16boldc tfs24boldp " >
    <tbody  class="text-center">

        <tr >
            <td class="col-print-11 bordered-0" ></td>
            <td class="col-print-4"> {{Auth::user()->name}}</td>
            <td class="col-print-11 bg-info">: ناو</td> 
            <td class="col-print-11 bordered-0" > </td>  
        </tr>  

</tbody>
</table>

       <table class="table table-bordered tseparate-1 tfs16boldc tfs24boldp ">
    <tbody  class="text-center">

      <tr  >
            <td class="col-print-11 bordered-0"></td>
            <td class="col-print-2"> {{$to}}</td>
            <td class="col-print-1 bg-info">: بۆ</td> 

            <td class="col-print-2"> {{$from}}</td>
            <td class="col-print-1 bg-info">: لە</td> 
            <td class="col-print-11 bordered-0" > </td>  
        </tr>

</tbody>
</table>

</div>


<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">

<table class="table table-bordered table-striped table-responsive">
  <thead class="bg-primary">

    <tr class="custom_centered">
      <th> کۆی فرۆش</th>
      <th colspan="2"> کۆی پارەی وەرگیراو</th>
    </tr>

  </thead>

  <thead class="bg-info">
    <tr class="custom_centered">

      <th class="text-danger">بڕی پارە بە دۆلار</th> 
      <th class="text-success">بڕی پارە بە دینار</th>
      <th class="text-danger">بڕی پارە بە دۆلار</th>

     
 
    </tr>
  </thead>

  <tbody>
  

      <tr class="text-center">
        <td class="text-danger bg-warning"> <strong> {{number_format($saleMoney,2)}} </strong></td>
        <td class="text-success bg-warning"> <strong> {{number_format($returnedDinars,0)}} </strong></td>
        <td class="text-danger bg-warning"> <strong> {{number_format($returnedDollars,2)}} </strong></td>
       
      </tr>
  </tbody>
       
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