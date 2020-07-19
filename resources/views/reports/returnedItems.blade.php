@extends('layouts.master')

@section('content')

<br/>

<div class="row bordered-2">
	
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
</br>
	<strong><p style="font-size: 48px; "> ڕاپۆرتی مەوادی گەڕاوە </p> </strong>
    </br>
    </br>
</div>
</div>


<div class="col-md-12 col-sm-12 col-xs-12 text-center">

        <table class="table table-bordered table-responsive table-text-center tseparate-1 tfs18boldc tfs24boldp  ">
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

		<table class="table table-bordered table-striped table-responsive tseparate-1 table-text-center tfs18boldc tfs24boldp " >
    <thead >
        <tr  class="bg-info">
           
            <th class="col-print-3">سەرجەمی کارتۆنی گەڕاوە</th>
            <th class="col-print-3">بڕی پارەی گەڕاوە </th>
            <th class="col-print-3">ناوی کڕیار</th>
            <th class="col-print-3">کۆدی کڕیار</th>
        
        </tr>

    </thead>

<tbody>
    <?php $sumQuantity=0;$sumAmount=0;?>
     @foreach($customers as $customer)
     <?php $sumQuantity+=$customer->customerReturnsQuantityByDate($from,$to);
           $sumAmount+=$customer->customerReturnsAmountByDate($from,$to);?>
    <tr >
        <td >{{$customer->customerReturnsQuantityByDate($from,$to)}}</td>
        <td >{{$customer->customerReturnsAmountByDate($from,$to)}}</td>
        <td > {{$customer->name}}</td>
        <td class="bg-warning text-danger">{{$customer->id}}</td>
    </tr>
    
    @endforeach
</tbody>


</table>
</div>

<div class="row bordered-1" >

<br>

        <table class="table tseparate-1 table-bordered table-text-center tfs18boldc tfs24boldp ">
    <tbody  class="bordered-1">

        <tr  >
            <td class="col-print-2 bordered-0" ></td>
            <td class="col-print-3 bg-warning text-danger">$ {{$sumAmount}}</td>
            <td class="col-print-2 bg-info"> :سەرجەمی پارە</td>
            <td class="col-print-2 bordered-0" ></td>
        </tr>

        <tr  >
            <td class="col-print-2 bordered-0" ></td>
            <td class="col-print-3 bg-warning text-danger"> {{$sumQuantity}}</td>
            <td class="col-print-2 bg-info"> سەرجەمی کارتۆن</td>
            <td class="col-print-2 bordered-0" ></td>
        </tr>
        
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