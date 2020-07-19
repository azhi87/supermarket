@extends('layouts.master')

@section('content')

<br/>

<div class="row bordered-2">
	
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
</br>
	<strong><p style="font-size: 48px; "> ڕاپۆرت مەندووب - کارتۆن </p> </strong>
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
            <td class="col-print-4 " > Value2</td>
            <td class="col-print-2 bg-info">: ناوی مەندووب</td> 
            <td class="col-print-11 bordered-0" ></td>
             
        </tr>  
</tbody>
</table>

        <table class="table table-bordered table-text-center tseparate-1 tfs18boldc tfs24boldp  ">
    <tbody  >

      <tr  >
            <td class="col-print-11 bordered-0" > </td>
            <td class="col-print-2 "> Value2</td>
            <td class="col-print-1 bg-info">: بۆ</td> 
            <td class="col-print-2 "> Value2</td>
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
<tr >

<td class="bg-warning color-brown">Value3</td>
<td > Value2</td>
<td class="bg-warning color-brown"">Value1</td>

</tr>
</body>


</table>
</div>

<div class="row bordered-1" >

<br>

        <table class="table tseparate-1 table-bordered table-text-center tfs18boldc tfs24boldp ">
    <tbody  class="bordered-1">

        <tr  >
            <td class="col-print-2 bordered-0" ></td>
            <td class="col-print-3 bg-warning text-danger"> Value2</td>
            <td class="col-print-2 bg-info"> :سەرجەمی کارتۆن</td>
            <td class="col-print-2 bordered-0" ></td>
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