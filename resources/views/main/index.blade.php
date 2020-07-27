@extends('layouts.master')
@section('content')
<div class="row">
	<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="card card-topline-green">
			<div class="card-head">
				<header>Today's Income</header>
			</div>
			<div class="card-body">
				<div class="table-scrollable">
					<table class="table text-center table-striped">
						<thead>
							<tr class="bg-info text-light">
								<th> Name </th>
								<th> Total </th>
							</tr>
						</thead>
						@php $total = 0; @endphp
						@foreach ($users as $user)
						<tr>
							<td><strong>{{$user->name}}</strong></td>
							<td class="text-primary"><strong>{{number_format($total+=$user->todayAmount()->total,0)}}</strong></td>
						</tr>
						@endforeach
						<tfoot>
							<tr>
								<th><strong>Total</strong></th>
								<td colspan="2" class="h4 text-danger"><strong> {{number_format($total,0)}}</strong></td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-5 col-sm-6 col-xs-12">
		<div class="card card-topline-yellow">
			<div class="card-head">
				<header>Three Month Expiry</header>
			</div>
			<div class="card-body">
				<div class="table-scrollable">
					<table class="table text-center table-striped">
						<thead>
							<tr class="bg-info text-light">
								<th> Name </th>
								<th> Total </th>
								<th> Expiry Date </th>
							</tr>
						</thead>
						<?php $stock = new \App\Stock();
						$stocks = $stock->oneMonthExpirey(3); ?>
						@foreach ($stocks as $stock)
						<tr>
							<?php
							?>
							<td> {{ $stock->name }}</td>
							<td class="text-primary"><strong>{{number_format($stock->quantity)}}</strong></td>
							<td class="text-primary"><strong>{{($stock->exp)}}</strong></td>
						</tr>
						@endforeach
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-4 col-sm-6 col-xs-12">
		<div class="card card-topline-red">
			<div class="card-head">
				<header>One Month Expiry</header>
			</div>
			<div class="card-body">
				<div class="table-scrollable">
					<table class="table text-center table-striped">
						<thead>
							<tr class="bg-info text-light">
								<th> Name </th>
								<th> Total </th>
								<th> Expiry Date </th>
							</tr>
						</thead>
						<?php $stock = new \App\Stock();
						$stocks = $stock->oneMonthExpirey(1); ?>
						@foreach ($stocks as $stock)
						<tr>
							<?php
							?>
							<td> {{ $stock->name }}</td>
							<td class="text-danger"><strong>{{number_format($stock->quantity)}}</strong></td>
							<td class="text-danger"><strong>{{($stock->exp)}}</strong></td>
						</tr>
						@endforeach
					</table>
				</div>
			</div>
		</div>
	</div>
	
		@if(Auth::user()->type=='admin')
	<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="card card-topline-green">
			<div class="card-head bg-light">
				<header>Change Dollar Rate</header>
			</div>
			@include('layouts.errorMessages')
			<form method="post" action="/rate/add" id="contact_form">
				{{csrf_field()}}
				<div class="card-body " id="bar-parent">
					<fieldset class="form-group">
						<input type="text" name="rate" class="form-control" value="{{$rate->rate}}" required>
					</fieldset>
					<button type="submit" class="btn btn-primary btn-block "><strong>Save</strong></button>
				</div>
			</form>
		</div>
	</div>
	@endif
</div>
@endsection