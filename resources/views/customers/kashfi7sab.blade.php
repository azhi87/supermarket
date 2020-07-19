
@extends('layouts.master')

@section('content')
<br>
<div class="row bordered-2" > 
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<br>
    <strong><p style="font-size: 38px; ">کەشفی حسابی کڕیار </p> </strong>
<br>
</div>
</div>

<div class="row bordered-1" >
        <table class="table table-bordered tfs16boldc tfs14boldp margin-2">
    <thead  class="text-center">
        <tr>
            <td class="col-print-3"> {{$customer->name}}</td>
            <td class="bg-info col-print-11">: ناوی کڕیار</td> 
            <td class="col-print-3"> {{$customer->lab_name}}</td>
            <td class="bg-info col-print-11"> : ناوی تاقگیە </td>
        </tr>
</thead>
</table>

        <table class="table table-bordered tfs16boldc tfs14boldp margin-2"  >
    <thead  class="text-center">

        <tr  >
            <td class="col-print-2"> {{$customer->mobile}}</td>
            <td class="col-print-3"> {{$customer->garak->garak}}</td>
            <td class="col-print-3"> {{$customer->garak->city->city}}</td>
            <td class="bg-info col-print-11"> :ناونیشان </td>
        </tr>

</thead>
</table>

</div>
<div class="text-right">
<h3> <span class="label box-bcolor "> بەشی قەرز دانەوە</span></h3>
</div>
<div class="row bordered-1" >

        <table class="table table-bordered table-striped table-responsive table-text-center tfs16boldc tfs14boldp margin-1" >
    <thead >
        <tr class="bg-info" >
            <th class="col-print-2">   تێبینی  </th>
            <th class="col-print-2"> كۆی پارە</th>
            <th class="col-print-11">گۆڕینەوەی دۆلار</th>
            <th class="col-print-11">پارە بە دینار</th>
            <th class="col-print-11">پارە بە دۆلار</th>
            <th class="col-print-11">بەروار</th>
            <th class="col-print-11">کارمەند</th>
        </tr>

    </thead>
@foreach ($customer->debts as $debt)
<tr >
<td >{{$debt->description}}</td>
<td >{{number_format($debt->calculatedPaid,2)}}</td>
<td >{{$debt->rate}}</td>
<td >{{$debt->dinars}}</td>
<td > {{number_format($debt->dollars,2)}}</td>
<td class="bg-warning text-danger">{{$debt->created_at->format('d/m/y')}}</td>
<td >{{$debt->user->name}}</td>
</tr>

@endforeach

</table>
</div>

<div class="text-right">
<h3 class="text-right "> <span class="label box-bcolor "> بەشی وەسڵ</span></h3>
</div>
<div class="row bordered-1">

        <table class="table table-bordered table-responsive table-striped table-text-center tfs16boldc tfs14boldp margin-1 ">
    <thead  >
        <tr class="bg-info">
           
            <th>کۆی وەسڵ</th>
            <th>کۆی پارەی دراو </th>
            <th> $ - پارەی دراو </th>
            <th> IQ - پارەی دراو </th> 
            <th>بەرواری وەسڵ</th>
            <th>ژ.وەسڵ</th>
            <th>کارمەند</th>
        </tr>

</thead>

@foreach ($customer->sales as $sale)
  
<tr  >
<td >{{number_format($sale->total,2)}}</td>
<td >{{number_format($sale->calculatedPaid,2)}}</td>
<td >{{number_format($sale->dollars,2)}}</td>
<td >{{number_format($sale->dinars,0)}}</td>
<td > {{$sale->created_at->format('d/m/Y')}}</td>
<td class="bg-warning text-danger"> <a href='/sale/print/{{$sale->id}}'>{{$sale->id}}</a></td>
<td >{{$sale->user->name}}</td>
</tr>

@endforeach

</table>
</div>

<div class="print-single text-right">
<h3 class="text-right "> <span class="label box-bcolor "> حسابی کۆتایی کڕیار</span></h3>

<div class="row bordered-1" >

        <table class="table text-center tseparate table-bordered tfs16boldc tfs14boldp margin-1">
        <tbody class="bordered-1">
        <tr  >
            <td class="col-print-0 "><i class="fa fa-dollar "></i> </td>
            <td class="col-print-3  text-danger bg-warning"> 
            {{number_format($customer->sales->sum('total'),2)}}</td>
            <td class="col-print-4 bg-info"> :سەرجەمی وەسڵی کڕیار </td>
        </tr>

        <tr  >
        <td ><i class="fa fa-dollar "></i></td>
            <td class="text-danger bg-success">  
        {{number_format($customer->sales->sum('calculatedPaid'),2)}}</td>
            </td>
            <td class="bg-success"> :سەرجەمی پارەی دراو لە وەسڵدا   </td>
        </tr>

        <tr>
            <td ><i class="fa fa-dollar "></i></td>
            <td class="text-danger bg-success"> 
            {{number_format($customer->debts->sum('calculatedPaid'),2)}}</td>
            <td class="bg-success"> :سەرجەمی پارەدانەوەی قەرز </td>
        </tr>

         <tr  >
            <td ><i class="fa fa-dollar "></i></td>
            <td class="text-danger bg-warning">  
            {{number_format($customer->sales->sum('total')
            -$customer->sales->sum('calculatedPaid')
            -$customer->debts->sum('calculatedPaid'),2)}}
            </td>
            <td class="bg-info"> :سەرجەمی قەرزی ئێستای کڕیار</td>
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
  $('#customer').addClass('menu-top-active');
  });
 </script>

 @endsection