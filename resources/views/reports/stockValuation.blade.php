@extends('layouts.master')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-sm-12">
				<div class="card card-topline-green">
					<div class="card-head">
						<header>Stock Valuation</header>
					</div>
					<div class="card-body">
						<div class="table-scrollable">
							<table class="table text-center table-borderd table-striped table-hover">
								<thead>
									<tr class="bg-info text-light">
										<th class="">Barcode</th>
										<th class="">Name</th>
										<th class="">Quantity in stock</th>
										<th class="">Price ($)</th>
										<th class="">Subtotal ($)</th>
									</tr>
								</thead>
								<tbody>
									@foreach($items as $item)
									<tr class="custom_centered">
										<td class=" ">{{ $item->barcode }}</td>
										<td class=" ">{{ $item->name }}</td>
										<td class=" ">{{ number_format($item->stock,2) }}</td>
										<td class=" ">{{ number_format($item->ppi,2) }}</td>
										<td class=" ">{{ number_format($item->subtotal,2) }}</td>
									</tr>
									@endforeach
								</tbody>
								<tfoot>
									<tr class="h5 text-light bg-info">
										 <td> Total : <span>{{ number_format($items->sum('subtotal'),0) }}</span></td>
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