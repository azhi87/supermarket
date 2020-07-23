@extends('layouts.master')
@section('content')

<div class="col-md-12 col-sm-12">
	<div class="card card-topline-green">
		<div class="card-body bg-light " id="bar-parent1">
			@include('layouts.errorMessages')
			<form class="form-horizontal" method="POST" action="/paybacks/search">
				{{csrf_field()}}
				<div class="row form-group">
					<label class="col-md-1 control-label">Supplier</label>
					<div class="col-md-3">
						<select type="text" name="supplier_id" class="form-control">
						</select>
					</div>

					<label class="col-md-1 control-label">From</label>
					<div class="col-md-2">
						<input type="date" name="star_date" class="form-control" />
					</div>
					<label class="col-md-1 control-label">To</label>
					<div class="col-md-2">
						<input type="date" name="end_date" class="form-control" />
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4 col-sm-12">
		<div class="card card-topline-green">
			<div class="card-head">
				<header>Payback Form</header>
			</div>
			<div class="card-body bg-light " id="bar-parent1">
				@include('layouts.errorMessages')
				<form class="form-horizontal" method="POST" action="/paybacks/store">
					{{csrf_field()}}
					<div class="row form-group">
						<label class="col-sm-3 control-label">Supplier</label>
						<div class="col-sm-9">
							<select type="text" name="supplier_id" class="form-control">
							</select>
						</div>
					</div>
					<div class="row form-group">
						<label class="col-sm-3 control-label">Amount</label>
						<div class="col-sm-9">
							<input type="text" name="paid" class="form-control" required />
						</div>
					</div>
					<div class="row form-group">
						<label class="col-sm-3 control-label">Note</label>
						<div class="col-sm-9">
					    	<textarea class="form-control" name="description"></textarea>
	                    </div>				
					</div>
					<div class="form-group text-center">
						<button type="submit" class="btn btn-primary btn-lg btn-block"><b>Save</b></button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="col-md-8 col-sm-12">
		<div class="card card-topline-green">
			<div class="card-body">
				<div class="table-scrollable">
					<div class="table-responsive">
						<table class="table table-bordered text-center table-striped">
							<thead class="bg-success">
								<tr class="text-center">
									<th> User Name</th>
									<th>Date</th>
									<th>Amount </th>
									<th>Note</th>
									<th class="hidden-print">Edit</th>
								</tr>
							</thead>
							<tbody>
								<?php if (isset($searchPaybacks)) {
									$paybacks = $searchPaybacks;
									$update = 1;
								} else {
									$update = 0;
								}
								?>

								@foreach($paybacks as $payback)
								<tr class="text-center">
									<td>{{$payback->user->name}}</td>
									<td>{{$payback->created_at}}</td>
									<td>{{number_format($payback->paid,2)}}</span></td>
									<td>{{$payback->description}}</td>
									<td class="hidden-print"><a href="/payback/edit/{{$payback->id}}"><span class="fa fa-edit fa-1x">
											</span></a></td>

								</tr>
								@endforeach
							</tbody>
							<tfoot>
							    <tr class="bg-info h5 text-light">
							        <th>Total</th>
							        <th colspan="2">{{number_format($paybacks->sum('paid'),2)}}</th>
							    </tr>
							</tfoot>
						</table>
					</div>
					@if ($paybacks->has('links'))
					{{ $paybacks->links('vendor.pagination.bootstrap-4') }}
					@endif
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
@section('afterFooter')
<script type="text/javascript">
	$(document).ready(function() {
		$("#menu-top li a").removeClass("menu-top-active");
		$('#debtHeader').addClass('menu-top-active');
	});
</script>

@endsection