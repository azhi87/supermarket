@extends('layouts.master')
@section('content')
<br>

<div class="row hidden-print well">
<form method="post" action="/debts/search" class=" form-inline text-center" >
{{csrf_field()}}

@if (Auth::user()->type!="mandwb")
<!--<a href="/debt/generalSearch" type="button" class="btn btn3d btn3d-pull btn-primary"><strong>گەڕانی گشتی </strong></a>-->
@endif
                           <div class="col-md-6 col-md-offset-3 well-sm bg-info">
						   <div class="col-md-12">
						                               
                        <select name="customer_id" class="select2" id="select2" onchange="getCustomerName();"
						  style="min-width: 500px;" >
                                <option value="0">هەڵبژاردنی ناوی تاقیگە</option>
                                @foreach ($customers as $customer1)
<option value="{{$customer1->id}}">{{$customer1->id}}--{{$customer1->name}}--{{$customer1->lab_name}}--{{$customer1->mobile}}</option>
                                @endforeach
                            </select>                     
                        </div>
                        <span class="input-group-btn">
						</div>
						<div class="col-md-1">
       <button class="btn btn-magick btn3d" type="submit">
		<strong>گەڕان </strong><span class="fa fa-search fa-12x"></span></button>
      </span>
	  </div>
</form>
</div>

@if(!empty($customer))
<div class=" col-md-12 col-sm-12 col-xs-12 table-responsive" >
<table class="table table-borderless table-responsive">
	<thead >
		<tr>
    <th><a type="button"  href="/kashfi7sab/{{$customer->id}}" class="btn btn-info  btn3d"><strong>کەشفی حیساب </strong></a></th>
	<th class="text-right color-red h4"><strong>{{number_format($customer->customerDebt(),2)}}</strong></th>
	<th class="text-left h4"><strong> : کۆی قەرز - دۆلار </strong></th>
`
	<th class="text-right color-red h4"><strong>{{$customer->lab_name}} </strong></th>
	<th class="text-left h4"><strong> : ناوی تاقیگە </strong></th>

		</tr>
	</thead>
</table>
 
</div>
<hr>
<br>
<div class="row">
 <div class="col-md-8 col-sm-12 col-xs-12 table-responsive">
<table class="table table-bordered table-striped table-responsive">
	<thead class="bg-info color-black">
		<tr class="custom_centered">
		    @if(Auth::user()->type!="mandwb")
			<th class="hidden-print">گۆڕانکاری</th>
			@endif
			<th>ماوە</th>
			<th>کۆ</th>
			<th>نرخی دۆلار</th>
			<th>دینار</th>
			<th>دۆلار</th>
			<th>بەروار</th>
		</tr>
	</thead>

	<tbody>
	
		@foreach ($customer->debts->sortByDesc('created_at') as $debt) 
			<tr class="text-center">

@if((Auth::user()->type!="admin" && $debt->status!='1') || (Auth::user()->type=="admin"))

				<td class="hidden-print"><a href={{"/debts/edit/".$debt->id}}><span class="fa fa-edit fa-1x"></span></a></td>
				@endif
			
				<td>{{number_format($debt->new_total_debt,2)}}</td>
				<td>$ {{number_format($debt->calculatedPaid,2)}}
				<td>{{$debt->rate}}</td>
				<td>{{$debt->dinars}}</td>
				<td>$ {{$debt->dollars}}</td>
				<td>{{$debt->created_at}}</td>
			</tr>
		@endforeach
	</tbody>
       
</table>
</div>
@if(!$customer->hasUnConfirmedDebts())
<div class="col-md-4 col-sm-5 col-xs-10 col-md-offset-0 col-sm-offset-7 col-xs-offset-0 hidden-print" >

@include('layouts.errorMessages')

<div class="panel panel-info">
                <div class="panel-heading text-center">
                  <span class="h3 color-black"><b> وەسڵی قەرزی کڕیار</b></span>
                </div>
                <div class="panel-body">
<form class="form-horizontal" method="POST" action="/debt/store" id="contact_form">
	{{csrf_field()}}
	<input type="hidden" name="customer_id" value="{{$customer->id}}">

	<div class="form-group">

	<div class="col-md-12">
	    <div class="input-group has-warning">
		<input type="number" min="0" value="0" onkeyup="calculateTotalPaid({{$rate->rate}});" onblur="calculateTotalPaid({{$rate->rate}});" name="dollars" class="form-control" id="dollars">
		<span class="input-group-addon">:دۆلار</span>
 
	    </div>

	</div>
	</div>
<div class="form-group">

	<div class="col-md-12">
	    <div class="input-group has-warning">
	<input type="number" min="0" class="form-control" onkeyup="calculateTotalPaid({{$rate->rate}});" onblur="calculateTotalPaid({{$rate->rate}});" name="dinars" value="0" class="form-control" id="dinars">
			<span class="input-group-addon">:دینار</span>   
	    </div>

	</div>
	</div>
<div class="form-group">
		<div class="col-md-12">
	    <div class="input-group has-warning">
			<input readonly='readonly' name="calculatedPaid" class="form-control" id="totalPaid" >
			<span class="input-group-addon">سەرجەم</span>

		</div></div></div>
<div class="form-group">
		<div class="col-md-12">
	    <div class="input-group has-warning">
			<input readonly='readonly' name='rate' value="{{$rate->rate}}" class="form-control" id="exampleInputEmail2">
		<span class="input-group-addon">:نرخی دۆلار</span>
		</div></div></div>

<div class="form-group">
	<div class="col-md-12 inputGroupContainer">
            <div class="input-group has-warning">
                <textarea class="form-control" name="description"></textarea>
                <span class="input-group-addon">زانیاری</span>
            </div>
        </div>
    </div>

<div class="form-group">
	
<div class="col-md-8 col-sm-12">	
		<button type="submit" class="btn btn-primary btn3d btn-lg btn-block"> <strong>تۆمارکردن </strong>    </button>
</div>
</div>

</form>
</div>
</div>
</div>

</div>
@endif
@endif
@endsection
@section('afterFooter')

<script type="text/javascript">
 	$(document).ready(function () {
  $("#menu-top li a").removeClass("menu-top-active");              
  $('#debtHeader').addClass('menu-top-active');
  });
 </script>

 <script type="text/javascript">
  $(document).ready(function() {
    $('.select2').select2();
});
  
 </script>
 @endsection