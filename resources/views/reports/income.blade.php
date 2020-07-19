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
        <td class=" ">{{number_format($sale->calculatedPaid,0)}}</td>
        <td class="">{{$sale->description}}</td>
    </tr>   
    
@endforeach


</tbody>
</table>

</div>

<div class="row text-center">
       <p class="h3 text-center">Total : <span>{{$sales->sum('calculatedPaid')}}</span></p>
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