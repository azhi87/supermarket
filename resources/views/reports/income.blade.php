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
										<th class="">Type</th>
										<th class="">Total Sold (IQD)</th>
										<th class="">Total Discount (IQD)</th>
										<th class="">Grand total (IQD)</th>

									</tr>
								</thead>
								<tbody>
									<?php $i = 1; ?>
									@foreach ($sales as $sale)
									<tr class="text-center">
										<td>{{$i++}}</td>
										<td class=" ">{{$sale->user->name}}</td>
										<td class=" ">{{$sale->created_at}}</td>
										<td class=" ">{{$sale->id}}</td>
										<td class=" ">{{$sale->type}}</td>
										<td class=" ">{{number_format($sale->dinars,0)}}</td>
										<td class=" ">{{number_format($sale->discount,0)}}</td>
										<td class=" ">{{number_format($sale->total,0)}}</td>
									</tr>
									@endforeach
								</tbody>
								<tfoot>

									<tr class="h4 text-light">
										<td colspan="2" class="text-info"><strong> Total : {{ number_format($sales->where('type','sale')->sum('total'),0) }} </strong> </td>
										<td colspan="2" class="text-primary"><strong> Discount : {{ number_format($sales->sum('discount'),0) }} </strong> </td>
										<td colspan="2" class="text-danger"><strong> Return : {{ number_format($sales->where('type','returned_sale')->sum('total')) }} </strong> </td>
										<td colspan="2" class="text-success"><strong> Grand total : {{ number_format($sales->sum('total'),0) }} </strong> </td>
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