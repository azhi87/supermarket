
@extends('layouts.master')
@section('content')


<div style="page-break-after: always;">
<div class="for-watermark-div visible-print">Golden Led Light</div>

<div class="row bordered-2 gradient4" >
  <br />
<div class="col-sm-4 col-md-4 col-xs-4 text-center " >

  <p class="txtdarkblue" style="font-size: 28px; font-weight: bold;"> Golden Led Light Company</p> 
</div>

<div class="col-sm-4 col-md-4 col-xs-4 text-center " >

 
  <img width="180" height="120" src="/public/golden_logo.png" alt="Golden Led Light">

</div>

<div class="col-sm-4 col-md-4 col-xs-4 text-center " >

  <p class="txtdarkblue" style="font-size: 30px;"> کۆمپانیای <br /> گۆڵدن لید لایت </p> 
</div>

<br />  
<div class="col-md-12 col-xs-12 col-sm-12">

<br />
  <p class="tfs18boldc tfs14boldp text-center text-danger" style="letter-spacing: 1px;"> 0770 187 7424 _ 0770 221 0905 _ 0770 466 1919 </p> 

</div>

<div class="col-md-12 col-xs-12 col-sm-12  ">

<p class="tfs18boldc tfs14boldp text-right " style="letter-spacing: 1px;">  ناونیشان: سلێمانی - گەڕەکی ڕزگاری - بەرامبەر مەعرەزەکان  </p> 

</div>

</div>

<br>
<hr class="bg-primary">


<div class="row">
 <div class="col-md-12 col-sm-12 col-xs-12 table-responsive ">
<table class="table table-bordered table-striped table-responsive tfs16boldc tfs16boldp">
	
	<thead >
	    
		<tr class="custom_centered bg-info">

			<th>جۆری دراو</th>
			<th>بڕی پارەی گەڕاوە</th>
			<th>ناوی تیملیدەر</th>
			<th>بەرواری پارە گەڕانەوە</th>

		</tr>
	</thead>

	<tbody>
	
			<tr class="text-center">
			 	
			 	
				<td>{{$payback->currency}}</td>
				<td>{{number_format($payback->paid)}}</td>
				<td>{{$payback->teamLeader->name}}</td>
				<td>{{$payback->created_at->format('d/m/Y')}}</td>

			</tr>
	</tbody>
</table>
</div>


<div class="row">
 <div class="col-md-12 col-sm-12 col-xs-12 table-responsive ">
<table class="table table-bordered table-striped table-responsive tfs18boldc tfs16boldp">
	
	<thead class="bg-success">
	   
		<tr class="text-right">
			<td class="text-right"> : زانیاری زیاتر {{$payback->description}}</td>
		</tr>
	</thead>


</table>
</div>
</div>



<div class="row  bordered-2 bgivory">
<div class="col-md-12 col-sm-12 col-xs-12 ">

<br>
<table class="table table-bordered tfs16boldc tfs16boldp margin-1 bgivory">
<tbody >
        
<tr >

<td class="col-print-5" style="text-align: right; vertical-align: middle; line-height: 80px; ">  :ناوی محاسب</td>
        
<td class="col-print-5" style="text-align: right; vertical-align: middle; line-height: 80px; ">  :ناوی وەرگر </td> </tr>

</tbody>


</table>
<br>
</div>
</div>


<div class="row bordered-1 " >

<table class="table table-text-center tfs16boldc tfs14boldp" style="margin-bottom: 1px !important;">
  <tbody>
    
    <tr class=" bg-ivory">
    <td> Golden Led Light Company For General Trade Limited --- کۆمپانیای گۆڵدن لید لایت بۆ بازرگانی گشتی سنوردار  </td>
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
  $('#debtHeader').addClass('menu-top-active');
  });
 </script>

 @endsection