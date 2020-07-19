@extends('layouts.master')

@section('content')

<br/>

<div class="row bordered-2">
	
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
</br>
	<strong><p style="font-size: 48px; "> ڕاپۆرتی فرۆشتن بەپێی گەڕەک </p> </strong>
    </br>
    </br>
</div>
</div>

<div class="row bordered-1" >

<br>
    <table class="table table-bordered tseparate-1 table-text-center tfs18boldc tfs24boldp " >
    <tbody>

        <tr>
            <td class="col-print-11 bordered-0" ></td>
            <td class="col-print-4 " > {{$garak}}</td>
            <td class="col-print-2 bg-info">: ناوی گەڕەک</td> 
            <td class="col-print-11 bordered-0" ></td>
             
        </tr>  
</tbody>
</table>

       <table class="table table-bordered table-text-center tseparate-1 tfs18boldc tfs24boldp  ">
    <tbody  >

      <tr>
            <td class="col-print-11 bordered-0" > </td>
            <td class="col-print-2 ">{{$to}}</td>
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
            <th class="col-print-2">سەرجەمی کارتۆن</th>
            <th class="col-print-6">ناوی مەواد</th>
            <th class="col-print-2">کۆدی مەواد</th>
            <th>#</th>
        
        </tr>
          
    </thead>

<tbody>
<?php $boxes=0;$values=0;$i=1;?>
      @foreach ($items as $item)
            <?php $boxes+=($item->tqty); $values+=($item->tppi);?>
        <tr>
            <td class="bg-warning color-brown">{{number_format($item->tppi,0)}}</td>
            <td class="bg-warning color-brown">{{number_format($item->tqty,0)}}</td>
            <td > {{$item->name}}</td>
            <td class="bg-warning color-brown">{{$item->id}}</td>
            <td>{{$i++}}</td>
        </tr>
 @endforeach

</tbody>
</table>
</div>

<div class="row bordered-1" >

<br>

        <table class="table tseparate-1 table-bordered table-text-center tfs18boldc tfs24boldp ">
    <tbody  class="bordered-1">
        <tr >
            <td class="col-print-2 bordered-0" ></td>
            <td class="col-print-3 bg-warning text-danger"> {{number_format($boxes,0)}}</td>
            <td class="col-print-2 bg-info"> :سەرجەمی کارتۆن</td>
            <td class="col-print-2 bordered-0" ></td>
        </tr>
        <tr >
            <td class="col-print-2 bordered-0" ></td>
            <td class="col-print-3 bg-warning text-danger"> {{number_format($values,0)}}</td>
            <td class="col-print-2 bg-info"> :سەرجەمی پارە</td>
            <td class="col-print-2 bordered-0" ></td>
        </tr>
<br>
        
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