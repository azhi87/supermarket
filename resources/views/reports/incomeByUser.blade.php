@extends('layouts.master')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-sm-12">
				<div class="card card-topline-green">
					<div class="card-head">
						<header>Total Income By User</header>
					</div>
					<div class="card-body">
						<div class="table-scrollable">
							<table class="table text-center table-borderd table-striped table-hover">
								<thead>
									<tr class="bg-info text-light">
										<th class="">Employee name</th>
										<th class="">Start date</th>
										<th class="">End date</th>
										<th class="">Sold (IQD)</th>
										<th class="">Discount (IQD)</th>
										<th class="">Returns (IQD)</th>
										<th class="">Total (IQD)</th>
									</tr>
								</thead>
								<tbody>
									
									<tr class="custom_centered">
										<td class=" ">{{ $user }}</td>
										<td class=" ">{{ $from }}</td>
										<td class=" ">{{ $to }}</td>
										<td class=" ">{{number_format($sales->where('type','sale')->sum('total') + $sales->where('type','sale')->sum('discount'),0)}}</td>
										<td class=" ">{{number_format($sales->where('type','sale')->sum('discount'),0)}}</td>
										<td class=" ">{{number_format(abs($sales->where('type','returned_sale')->sum('total')),0)}}</td>
										<td class=" ">{{number_format( $sales->sum('total'),0)}}</td>
									</tr>
								</tbody>
								<tfoot>
									<tr class="h5 text-light bg-info">
										{{-- <td> Total : <span>{{ number_format($sales->sum('total'),0) }}</span></td>
										<td> Discount : <span> {{ number_format($sales->sum('discount'),0) }} </span> </td>
										<td> Grand total : <span> {{ number_format($sales->sum('total') - $sales->sum('discount'),0) }} </span> </td> --}}
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