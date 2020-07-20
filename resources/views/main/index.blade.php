@extends('layouts.master')
@section('content')
<div class="row">
	<div class="col-md-4">
		<div class="row">
			<div class="col-sm-12">
				<div class="card card-topline-green">
					<div class="card-head">
						<header>Today's Income Per Employee</header>
					</div>
					<div class="card-body">
						<div class="table-scrollable">
							<table class="table text-center table-striped">
								<thead>
									<tr class="bg-info">
										<th> Name </th>
										<th> Total </th>
									</tr>
								</thead>
								<?php $total = 0; ?>
								@foreach ($users as $user)
								<tr>
									<?php
									$valuation = $user->todayAmount();
									$total += $valuation;
									?>
									<td> {{$user->name}}</td>
									<td class="text-warning">{{number_format($user->todayAmount(),0)}}</td>
								</tr>
								@endforeach
							</table>
						</div>
						<div class="row">
							<table class="table">
								<tbody class="text-center bordered-1">
									<tr class="success">
										<td colspan="2"><span class="h3"> Total:</span><span class="h3 text-danger bold"> {{number_format($total,0)}}</span></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="row">
			<div class="col-sm-12">
				<div class="card card-topline-yellow">
					<div class="card-head">
						<header>Three Month Expiry</header>
					</div>
					<div class="card-body">
						<div class="table-scrollable">
							<table class="table text-center table-striped">
								<thead>
									<tr class="bg-info">
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
									<td>@php echo (\App\Item::find($stock->id)->name) @endphp</td>
									<td class="text-primary"><strong>{{number_format($stock->quantity)}}</strong></td>
									<td class="text-primary"><strong>{{($stock->exp)}}</strong></td>
								</tr>
								@endforeach
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="row">
			<div class="col-sm-12">
				<div class="card card-topline-red">
					<div class="card-head">
						<header>One Month Expiry</header>
					</div>
					<div class="card-body">
						<div class="table-scrollable">
							<table class="table text-center table-striped">
								<thead>
									<tr class="bg-info">
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
									<td>@php echo (\App\Item::find($stock->id)->name) @endphp</td>
									<td class="text-danger"><strong>{{number_format($stock->quantity)}}</strong></td>
									<td class="text-danger"><strong>{{($stock->exp)}}</strong></td>
								</tr>
								@endforeach
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
						<div class="col-md-4 col-sm-6 col-xs-10 ">
							<div class="card card-topline-green">
								<div class="card-head bg-light">
									<header>Search Stock</header>
									@include('layouts.errorMessages')
								</div>
								<div class="card-body " id="bar-parent">
								<form method="POST" action="{{ route('show-item-stock') }}" id="contact_form">
										{{csrf_field()}}
											<fieldset class="form-group">
												<label for="formGroupExampleInput2">Barcode</label>
												<input type="text" name="barcode"  class="form-control" required>
											</fieldset>

											<div class="form-group">
											<div class="col-md-12">
										<button type="submit" class="btn btn-primary btn3d btn-block"><strong>Search</strong></button>
											</div>
											</div>
									</form>
										
								</div>
							</div>
						</div>

	@if(Auth::user()->type=='admin')
	<div class="col-md-3 col-sm-6">
	<form method="post" action="/rate/add" id="contact_form">
		{{csrf_field()}}

		@include('layouts.errorMessages')
		<div class="card ">
			<div class="panel-heading text-center">
				<span> Change the Rate Dollar </span>
			</div>
			<div class="panel-body text-right">
				<fieldset class="form-group">
					<input type="text" name="rate" class="form-control" value="{{$rate->rate}}" required>
				</fieldset>
				<button type="submit" class="btn btn-info btn-block btn3d"><strong>Save</strong></button>
			</div>
		</div>
	</form>
	</div>
@endif
</div>



@endsection

@section('afterFooter')
{{-- {!! $calendar->script() !!}
 --}} @endsection