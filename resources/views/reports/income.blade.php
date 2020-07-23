@extends('layouts.master')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-sm-12">
				<div class="card card-topline-green">
					<div class="card-head">
						<header>List of Sales</header>
					</div>
					<div class="card-body">
						<div class="table-scrollable">
							<table class="table text-center table-borderd table-striped table-hover">
								<thead>
									<tr class="bg-info text-light">
										<th>#</th>
										<th class="">Employee name</th>
										<th class="">Date</th>
										<th class="">Sale ID</th>
										<th class="">Amount (IQD)</th>
										<th class="">Description</th>
									</tr>
								</thead>
								<tbody>
									<?php $i = 1; ?>
									@foreach ($sales as $sale)

									<tr class="custom_centered">
										<td>{{$i++}}</td>
										<td class=" ">{{$sale->user->name}}</td>
										<td class=" ">{{$sale->created_at}}</td>
										<td class=" ">{{number_format($sale->id,0)}}</td>
										<td class=" ">{{number_format($sale->calculatedPaid,0)}}</td>
										<td class="">{{$sale->description}}</td>
									</tr>
									@endforeach
								</tbody>
								<tfoot>
									<tr class="h5 text-light bg-info">
										<td> Total : <span>{{ number_format($sales->sum('total'),0) }}</span></td>
										<td> Discount : <span> {{ number_format($sales->sum('discount'),0) }} </span> </td>
										<td> Grand total : <span> {{ number_format($sales->sum('total') - $sales->sum('discount'),0) }} </span> </td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection