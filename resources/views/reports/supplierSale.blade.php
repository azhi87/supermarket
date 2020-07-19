@extends('layouts.master')
@section('content')
<div class="row bordered-2">
	
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
</br>
	<strong><p style="font-size: 48px; "> ڕاپۆرتی کۆمپانیا </p> </strong>
    </br>
    </br>
</div>
</div>

<div class="row bordered-1" >

<br>
    <table class="table table-bordered tseparate-1 table-text-center tfs18boldc tfs24boldp " >
    <tbody>

        <tr  >
            <td class="col-print-11 bordered-0" ></td>
            <td class="col-print-4 " > {{$name}}</td>
            <td class="col-print-2 bg-info">: ناوی کۆمپانیا</td> 
            <td class="col-print-11 bordered-0" ></td>
             
        </tr>  
</tbody>
</table>

        <table class="table table-bordered table-text-center tseparate-1 tfs18boldc tfs24boldp  ">
    <tbody  >

      <tr  >
            <td class="col-print-11 bordered-0" > </td>
            <td class="col-print-2 "> {{$to}}</td>
            <td class="col-print-1 bg-info">: بۆ</td> 
            <td class="col-print-2 "> {{$from}}</td>
            <td class="col-print-1 bg-info">: لە</td> 
            <td class="col-print-11 bordered-0" > </td>
        </tr>

</tbody>
</table>

</div>

<div class="row bordered-1" >

		<table class="table table-bordered table-striped table-responsive table-text-center tfs18boldc tfs24boldp " >
    <thead >
        <tr  class="bg-info">
           
            <th class="col-print-2">سەرجەمی کارتۆن</th>
            <th class="col-print-6">ناوی مەواد</th>
            <th class="col-print-2">کۆدی مەواد</th>
        
        </tr>

    </thead>

<body>
<?php $total=0;$totalWeight=0;?>
@foreach ($items as $item)
    
   <?php $total+=$item->totalSaleIncludingXasmByDate($from,$to);
         $totalWeight+=$item->weight*$item->totalSaleIncludingXasmByDate($from,$to)?>
    <tr >
        <td class="bg-warning color-brown">{{number_format($item->totalSaleIncludingXasmByDate($from,$to),2)}}</td>
        <td > {{$item->name}}</td>
        <td class="bg-warning color-brown"">{{$item->id}}</td>
    </tr>

   {{-- expr --}}
@endforeach
</body>


</table>
</div>

<div class="row bordered-1" >

<br>

        <table class="table tseparate-1 table-bordered table-text-center tfs18boldc tfs24boldp ">
    <tbody  class="bordered-1">

        <tr  >
            <td class="col-print-3 bg-warning text-danger"> {{number_format($total,2)}}</td>
            <td class="col-print-2 bg-info"> :سەرجەمی کارتۆن</td>
            
            <td class="col-print-3 bg-warning text-danger">{{number_format($totalWeight/1000,2)}}</td>
            <td class="col-print-2 bg-info">:کۆی کێش-طن</td>
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