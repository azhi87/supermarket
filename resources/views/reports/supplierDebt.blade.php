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
									
									<tr>
										<td>{{ $loop->iteration }}</td>
									<td class="text-primary"><a href=" {{ route('payback',$supplier->id) }}"> {{$supplier->name}}</a></td>
										<td>{{number_format($supplier->purchases->sum('total'),2)}}</td>
										<td>{{number_format($supplier->paybacks->sum('discount'),2)}}</td>
										<td>{{number_format($supplier->paybacks->sum('paid'),2)}}</td>
									<td class="">{{ $supplier->purchases->sum('total') - ($supplier->paybacks->sum('total') + $supplier->paybacks->sum('discount')) }}</td>
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