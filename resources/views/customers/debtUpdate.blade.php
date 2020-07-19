@extends('layouts.master')
@section('content')
<br>
<div class="well col-md-10 col-sm-12 col-md-offset-1">

<table class="table table-borderless ">
	<thead >
		<tr>
			
			<th class="text-right color-red h3"><strong>{{$debt->customer->customerDebt()}}</strong></th>
			<th class="text-left h3"><strong>:کۆی قەرز </strong></th>
			<th class="text-right color-red h3"><strong>{{$debt->customer->lab_name}}</strong></th>
			<th class="text-left h3"><strong> : ناوی تاقیگە </strong></th>

		</tr>
	</thead>
</table>
 
</div>
<div class="col-md-3 col-sm-1"></div>
<div class="col-md-6 col-sm-10 col-xs-12 hidden-print">
@include('layouts.errorMessages')

<div class="panel panel-info">

                <div class="panel-heading text-center">

                </div>
                <div class="panel-body">

<form class="form-horizontal" method="POST" action="/debt/update/{{$debt->id}}" id="contact_form">
	{{csrf_field()}}
	<input type="hidden" name="customer_id" value="{{$debt->customer->id}}">
	<div class="form-group">
	<div class="col-md-12">
	    <div class="input-group has-warning">
		<input type="number" onkeyup="calculateTotalPaid({{$rate->rate}});" onblur="calculateTotalPaid({{$rate->rate}});" value="{{$debt->dollars}}" name="dollars" class="form-control" id="dollars">
		<span class="input-group-addon">:دۆلار</span>
	    </div>
	</div>
	</div>
<div class="form-group">

	<div class="col-md-12">
	    <div class="input-group has-warning">
	<input type="number" class="form-control" onkeyup="calculateTotalPaid({{$rate->rate}});" onblur="calculateTotalPaid({{$rate->rate}});" value="{{$debt->dinars}}" name="dinars" class="form-control" id="dinars">
			<span class="input-group-addon">:دینار</span>   
	    </div>

	</div>
</div>
<div class="form-group">
		<div class="col-md-12">
	    <div class="input-group has-warning">
			<input readonly='readonly' value="{{$debt->calculatedPaid}}" name="calculatedPaid" class="form-control" id="totalPaid" >
			<span class="input-group-addon">سەرجەم</span>

		</div></div></div>
<div class="form-group">
		<div class="col-md-12">
	    <div class="input-group has-warning">
			<input readonly='readonly' name='rate' value="{{$debt->rate}}" class="form-control" id="exampleInputEmail2">
		<span class="input-group-addon">:نرخی دۆلار</span>
		</div></div></div>

<div class="form-group">
	<div class="col-md-12 inputGroupContainer">
            <div class="input-group has-warning">
                <textarea class="form-control" name="description">{{$debt->description}}</textarea>
                <span class="input-group-addon">زانیاری</span>
            </div>
        </div>
    </div>

<div class="form-group">
<div class="col-md-12">
		<button type="submit" class="btn btn-block btn-primary btn3d"> <strong>تۆمارکردن </strong> </span></button>
</div>
</div>

</form>
</div>
</div>
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