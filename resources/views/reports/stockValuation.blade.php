@extends('layouts.master')
<style>
	.table td,
	.card .table td,
	.card .dataTable td{
		padding: 0px 8px;
		vertical-align: middle;
	}

	.table th,
	.card .table th,
	.card .dataTable th{
		padding: 5px 8px;
		vertical-align: middle;
	}
	.select2-results {
		max-height: 150px;
	}
</style>
@section('content')
<br/>
<div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
<div class="row">
<div class="col-sm-12">
<div class="card card-topline-green">
    <div class="card-head">
      <header>Stock Valuation Report</header>
      
    </div>
<div class="card-body">
  <div class="table-scrollable">
    <table class="table text-center table-striped">
    <thead >
        <tr class="bg-info">
            <th>  Barcode  </th>
            <th>  Name  </th>
             <th>  Purchase Price  </th>
              <th>   Stock  </th>
             <th>  Valuation </th>
        </tr>

    </thead>
    <?php $total=0;?>
   @foreach ($items as $item)
    <tr >
<?php 
 $stock=$item->totalPurchase()+($item->totalSale());
 $valuation=$stock*$item->averagePurchasePrice();

 $total+=$valuation;
 

?>

<td class="text-danger">{{$item->barcode}}</td>
<td >  {{$item->name}}</td>
<td class="text-warning">{{number_format($item->averagePurchasePrice(),2)}}</td>
<td class=" color-brown">{{number_format($stock,2)}}</td>
<td>{{number_format($valuation,2)}}</td>
</tr>
@endforeach
   
</table>
</div>

<div class="row bordered-1">

    <table class="table table-bordered tseparate-1 tfs16boldc tfs20boldp ">
    <tbody class="text-center bordered-1">

        <tr class="success">
            <td> Total</td>
            <td class=" text-danger"> {{number_format($total,2)}} $</td>
        </tr>


<br>    
</tbody>
</table>
</div>
</div></div></div></div></div></div>
@endsection

@section('afterFooter')
 <script type="text/javascript">
    $(document).ready(function () {
  $("#menu-top li a").removeClass("menu-top-active");              
  $('#report').addClass('menu-top-active');
  });
 </script>

 @endsection