@extends('layouts.master')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-sm-12">
				<div class="card card-topline-green">
					<div class="card-head">
						<header>List of Supplier Debts</header>
					</div>
					<div class="card-body">
						<div class="table-scrollable">
							<table class="table text-center table-borderd table-striped table-hover">
								<thead>
									<tr class="bg-info text-light">
										<th>#</th>
										<th>Supplier name</th>
										<th>Total Purchase</th>
										<th>Total Discount</th>
										<th>Total Payback</th>
										<th>Total Debt</th>
									</tr>
								</thead>
								<tbody>
									<?php $total = 0; ?>
									@foreach($suppliers as $supplier)
									<?php $total += $supplier->supplierDebt(); ?>
									<tr>
										<td>{{$i++}}</td>
										<td class="text-danger"> {{$supplier->name}}</td>
										<td>{{number_format($supplier->purchases->sum('total'),2)}}</td>
										<td>{{number_format($supplier->purchases->sum('discount'),2)}}</td>
										<td>{{number_format($supplier->paybacks->sum('paid'),2)}}</td>
										<td class="">{{number_format($supplier->supplierDebt(),2)}}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
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
		$('#report').addClass('menu-top-active');
	});
</script>

@endsection