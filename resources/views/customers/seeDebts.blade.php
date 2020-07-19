@extends('layouts.master')
@section('content')
<?php $user=new \App\User();$mandwbs=$user->Mandwbs();?>

<br>
<div class="row">
<div class="well col-md-12 col-sm-12 ">
<div class="col-md-12 text-center"><span class="h3"><b>گەڕان لە بەشی قەرز</b></span></div>
<table class="table table-borderless ">
	<thead >
		<tr>
	<th><ul class="nav navbar-nav" >
  <li class="dropdown">
  <button  class="dropdown-toggle btn btn-primary btn3d hidden-print" data-toggle="dropdown"><span class="h4">قەرز بەپێی کارمەند <span class="caret"></span></span></button>
  <ul class="dropdown-menu" style="background-color: white;">
  @foreach ($mandwbs as $mandwb)
                <li ><a href="/debt/confirm/{{$mandwb->id}}">{{$mandwb->name}}</a></li>
              @endforeach
                <li class="divider"></li>
              <li><a href="/debt/confirm">هەموو وەصلەکان</a></li>             
  </ul>
    
  </li>
</ul></th>
			<th class="text-right color-red h3"><strong> {{$debts->count()}} </strong></th>
			<th class="text-left h3"> :ژمارەی وەصلەکان</th>
			<th class="text-right color-red h3"><strong>{{number_format($debts->sum('dinars'),0)}}</strong></th>
			<th class="text-left h3">:سەرجەمی دینار</th>
			<th class="text-right color-red h3"><strong>$ {{$debts->sum('dollars')}} </strong></th>
			<th class="text-left h3"> :سەرجەمی دۆلار</th>
	 </tr>
	</thead>

</table>
</div>


<div>

<div class="row hidden-print">
	<div class="col-md-8 col-sm-6 col-xs-12 col-md-offset-2 hidden-print">
	<form method="POST" action="/debt/confirm/time" >
		{{csrf_field()}}
		
<div class="input-group">

				   		<span class="input-group-btn"><input type="submit" value="گەڕان" class="btn btn-primary"></span>
				   		<select  name="mandwb_id" class="form-control">
				   			<option value="0">-------------</option>
				   			@foreach ($mandwbs as $mandwb)
               					 <option value="{{$mandwb->id}}">{{$mandwb->name}}</option>
              				@endforeach
				   		</select>
				   		<span class="input-group-addon">کارمەند</span>
					    <input type="date" required="required" name="to" class="form-control"/>
						 <span class="input-group-addon">بۆ</span>
					    <input type="date" required="required"  name="from" class="form-control" />
	   					 <span class="input-group-addon">لە</span>
					</div>
					
	</form>

</div>
</div>




<div class="col-md-5"></div>

</div>
<br/>
<div class="row">
 <div class="col-md-12 col-sm-12 col-xs-12">
<table class="table table-bordered table-striped table-responsive">
	<thead class="bg-success">
		<tr class="custom_centered">
			<th class="hidden-print hidden">گۆڕانکاری</th>
			<th class="hidden-print hidden">ئەدمین</th>
			<th>زانیاری</th>
			<th>کۆ</th>
			<th>نرخی دۆلار</th>
			<th>دینار</th>
			<th>دۆلار</th>
			<th>کارمەند</th>
			<th>بەڕێز</th>
			<th>بەروار</th>
		</tr>
	</thead>

	<tbody>
	
		@foreach ($debts as $debt) 
			<tr class="text-center">
				<td class="hidden-print hidden"><a href={{"/debts/edit/".$debt->id}}><span class="fa fa-edit fa-1x"></span></a></td>
				<td class="hidden-print hidden">{{$debt->statusText()}}</td>
				<td>{{$debt->description}}</td>
				<td>$ {{number_format($debt->calculatedPaid,2)}}
				<td>{{$debt->rate}}</td>
				<td>{{$debt->dinars}}</td>
				<td>$ {{$debt->dollars}}</td>
				<td>{{$debt->user->name}}</td>
				<td> {{$debt->customer->name}} - {{$debt->customer->id}}</td>
				<td>{{$debt->created_at}}</td>
			</tr>
		@endforeach
	</tbody>
       
</table>
</div>
</div>
@endsection

@section('afterFooter')
 <script type="text/javascript">
 	$(document).ready(function () {
  $("#menu-top li a").removeClass("menu-top-active");              
  $('#debt').addClass('menu-top-active');
  });
 </script>

 @endsection