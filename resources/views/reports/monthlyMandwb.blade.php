@extends('layouts.master')
@section('content')
<br/>

<div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
<div class="row">
<div class="col-sm-12">
<div class="card card-topline-green">
    <div class="card-head">
      <header>Stock Report</header>
    </div>
<div class="card-body">
  <div class="table-scrollable">
    <table class="table text-center">
    <thead >
        <tr>
            <td>Employee Name: {{$user->name}}</td>
            <td><span>From : {{$from}}</span></td><td><span>To : {{$to}}</td>
        </tr>
        <tr class="bg-info">
            <th>Invoice ID</th>
            <th>Date</th>          
            <th>Total (IQD)</th>
        </tr>

    </thead>

@foreach ($sales as $sale)
    

<tr >

<td class="col-print-11 text-danger"><a href="/sale/seeSales/{{$sale->id}}" target="_blank"><span class="badge badge-primary h3">{{$sale->id}}</span></a></td>
<td class="col-print-11">{{$sale->created_at->format('d/m/Y')}}</td>
<td class="col-print-2">{{number_format($sale->total,0)}}</td>
</tr>
@endforeach


</table>
</div></div></div></div></div></div></div>

@endsection

@section('afterFooter')
 <script type="text/javascript">
    $(document).ready(function () {
  $("#menu-top li a").removeClass("menu-top-active");              
  $('#report').addClass('menu-top-active');
  });
 </script>

 @endsection