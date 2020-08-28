@extends('layouts.master')
@section('content')

<div class="row">
	<div class="col-md-4 col-sm-12">
		<div class="card card-topline-green">
			<div class="card-head">
				<header>Add Expense</header>
			</div>
			<div class="card-body bg-light" id="bar-parent1">
				@include('layouts.errorMessages')
				<form class="form-horizontal" method="POST" action="/expenses/store" id="addForm">
					{{csrf_field()}}
					<div class="row form-group">
						<label class="col-sm-3 control-label">IQD</label>
						<div class="col-sm-9">
							<input type="text" onkeyup="calculateTotalPaid(0)" onblur="calculateTotalPaid(0)"
								id="dinars" name="amount" class="form-control" />
							<input type="hidden" id="dollars" value="0" class="form-control" />
						</div>
					</div>
					<div class="row form-group hidden">
						<label class="col-sm-3 control-label">Rate</label>
						<div class="col-sm-9">
							<input type="text" id="rate" value="{{$rate->rate ?? 1250}}" onkeyup="calculateTotalPaid(0)"
								onblur="calculateTotalPaid(0)" class="form-control" readonly="" />
						</div>
					</div>

					<div class="row form-group hidden">
						<label class="col-sm-3 control-label">Dollar</label>
						<div class="col-sm-9">
							<input type="text" id="totalPaid" class="form-control" />
						</div>
					</div>

					<div class="row form-group">
						<label class="col-sm-3 control-label">Reason</label>
						<div class="col-sm-9">
							<textarea class="form-control" name="reason" required=""></textarea>
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
			<div class="card-head">
				<header>Expenses</header>
			</div>
			<div class="card-body">
				<div class="table-scrollable">
					<div class="table-responsive">
						<table class="table table-bordered text-center table-striped">
							<thead class="bg-info text-light">
								<tr class="text-center">
									<th> User Name</th>
									<th>Date</th>
									<th>Amount </th>
									<th>Reason</th>
									<th class="hidden-print">Edit</th>
								</tr>
							</thead>
							<tbody>
								<?php if (isset($searchExpenses)) {
									$expenses = $searchExpenses;
									$update = 1;
								} else {
									$update = 0;
								}
								?>

								@foreach ($expenses as $expense)
								<tr class="text-center">
									<td>{{$expense->user->name}}</td>
									<td>{{$expense->created_at}}</td>
									<td>{{number_format($expense->amount,2)}}</span></td>
									<td>{{$expense->reason}}</td>
									<td class="hidden-print"><a href="/expenses/edit/{{$expense->id}}"><span
												class="fa fa-edit fa-1x">
											</span></a></td>
								</tr>
								@endforeach
							</tbody>
							<tfoot>
								<tr class="bg-info h5 text-light">
									<th>Total</th>
									<th colspan="2">{{number_format($expenses->sum('amount'),2)}} $</th>
								</tr>
							</tfoot>
						</table>
					</div>
					@if ($expenses->has('links'))
					{{ $expenses->links('vendor.pagination.bootstrap-4') }}
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
		$('#expense').addClass('menu-top-active');
	});
</script>

@endsection