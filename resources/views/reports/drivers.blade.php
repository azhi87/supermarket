@extends('layouts.master')
@section('content')
<div class="row bordered-2" >
	
<div class="col-md-12 col-sm-12 col-sx-12 text-center">
</br>
	<strong><p style="font-size: 48px; ">ڕاپۆرتی کارمەند - فرۆشتن </p> </strong>
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
            <td class="col-print-4"> {{$user}}</td>
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

<div class="row bordered-1">


		<table class="table table-bordered table-striped table-responsive tseparate table-text-center tfs16boldc tfs24boldp " >
    <thead>
        <tr class="bg-info" >
            <th >کێشی گشتی</th>
            <th >سەرجەمی کارتۆن</th>
            <th >سەرجەمی فرۆشتن</th>
            <th >بەرواری فرۆشتن</th>
        </tr>
<?php $totalSale=0;$totalWeight=0;$totalQuantity=0;?>
@foreach ($sales as $sale)

<?php $totalSale+=($sale->total/$sale->n);
      $totalWeight+=$sale->weight;
      $totalQuantity+=$sale->quantity;?>
<tr class="bg-warning text-danger">

<td >{{number_format($sale->weight,2)}}</td>
<td >{{number_format($sale->quantity,2)}}</td>
<td >{{number_format($sale->total/$sale->n,2)}}</td>
<td >{{$sale->date}}</td>
</tr>
@endforeach


</tbody>
</table>
</div>


<div class="row bordered-1">

    <table class="table table-bordered tseparate-1 tfs16boldc tfs24boldp ">
    <tbody class="text-center bordered-1">

        <tr  >
            <td class="col-print-11 bordered-0" ></td>
            <td class="col-print-4 bg-warning text-danger"> {{number_format($totalSale,2)}}</td>
            <td class="col-print-2 bg-info"> : سەرجەمی فرۆشتن</td>
            <td class="col-print-11 bordered-0" ></td>
        </tr>

        <tr  >
            <td class="col-print-11 bordered-0" ></td>
            <td class="col-print-4 bg-warning text-danger"> {{number_format($totalQuantity,2)}}</td>
            <td class="col-print-2 bg-info"> : سەرجەمی کارتۆن</td>
            <td class="col-print-11 bordered-0" ></td>
        </tr>

        <tr  >
            <td class="col-print-11 bordered-0" ></td>
            <td class="col-print-4 bg-warning text-danger"> {{number_format($totalWeight,2)}}</td>
            <td class="col-print-2 bg-info"> : سەرجەمی کێش</td>
            <td class="col-print-11 bordered-0" ></td>
        </tr>
<br>    
</tbody>
</table>
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