@extends('layouts.master')
@section('content')
<br/>
  <div class="row bordered-2" >  


</div>
<div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
<div class="row">
<div class="col-sm-12">
<div class="card card-topline-green">
    <div class="card-head">
      <header>List of Sales</header>
      
    </div>
<div class="card-body">
  <div class="table-scrollable">
    <table class="table text-center">
    <thead >

        <tr class="custom_centered">
             <th>#</th>
            <th class="">Employee name</th>
            <th class="">Date</th>
            <th class="">Amount (IQD)</th>
            <th class="">Description</th>
        </tr>

    </thead>
    <tbody>
<?php $i=1;?>
@foreach ($sales as $sale)

    <tr class="custom_centered">
         <td>{{$i++}}</td>
        <td class=" ">{{$sale->user->name}}</td>
        <td class=" ">{{$sale->created_at->format('d-m-Y')}}</td>
        <td class=" ">{{number_format($sale->calculatedPaid,0)}}</td>
        <td class="">{{$sale->description}}</td>
    </tr>   
    
@endforeach


</tbody>
<tfoot>
 <tr class="h5"> 
   <td> Total : <span>{{ number_format($sales->sum('total'),0) }}</span></td>
   <td> Discount : <span> {{ number_format($sales->sum('discount'),0) }} </span> </td>
   <td> Grand total : <span> {{ number_format($sales->sum('total') - $sales->sum('discount'),0) }} </span> </td>
 </tr>
</tfoot>
</table>

</div>

</div></div></div></div></div></div>


@endsection
